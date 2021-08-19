<?php

namespace Ruter\Route;

use InvalidArgumentException;
use Ruter\Route\Common\Match;
use Ruter\Request\RequestInterface;
use Ruter\Route\Contract\RouteInterface;
use Ruter\Route\Contract\MatchInterface;

class Group implements RouteInterface
{
    private string $prefix;
    private array  $routes;

    public function __construct(string $prefix, array $routes)
    {
        $this->prefix = $prefix;
        $this->routes = $routes;
    }

    public function match(RequestInterface $request): MatchInterface
    {
        if ($this->prefixOf($request) !== $this->prefix) {
            return new Match(false);
        }

        $subRequest = $this->subRequestOf($request);
        foreach($this->routes as $routeName => $route) {
            $match = $route->match($subRequest);
            if ($match->isSuccessfull()) {
                return new Match(true, [
                    '_route' => $routeName,
                    '_extra' => $match->extra()
                ]);
            }
        }

        return new Match(false);
    }

    public function toUrl(array $params = []): string
    {
        if (empty($params['_route'])) {
            throw new InvalidArgumentException(
                'Param "_route" is required for url generating'
            );
        }

        if (!in_array($params['_route'], array_keys($this->routes))) {
            throw new InvalidArgumentException(
                'Param "_route" is not valid'
            );
        }

        return $this->prefix . $this->routes[$params['_route']]->toUrl($params);
    }

    private function prefixOf(RequestInterface $request): string
    {
        return mb_substr(
            $request->uri(), 0, mb_strlen($this->prefix)
        );
    }

    private function subRequestOf(RequestInterface $request): RequestInterface
    {
        return $request->withUri(
            mb_substr($request->uri(), mb_strlen($this->prefix))
        );
    }
}