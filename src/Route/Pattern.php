<?php

namespace Ruter\Route;

use Ruter\Route\Common\Match;
use Ruter\Route\Common\Template;
use Ruter\Request\RequestInterface;
use Ruter\Route\Contract\RouteInterface;
use Ruter\Route\Contract\MatchInterface;

class Pattern implements RouteInterface
{
    private Template $template;

    public function __construct(string $template)
    {
        $this->template = new Template($template);
    }

    public function match(RequestInterface $request): MatchInterface
    {
        return preg_match_all($this->template->toRegExp(), $request->path(), $matches)
            ? new Match(true, $this->paramsFromMatches($matches))
            : new Match(false);
    }

    public function toUrl(array $params = []): string
    {        
        return str_replace(
            array_map(
                fn(string $paramName): string => '{' . $paramName . '}',
                array_keys($params)
            ),
            array_values($params),
            $this->template->toString()
        );
    }

    private function paramsFromMatches(array $matches): array
    {
        $paramNames = array_filter(
            array_keys($matches),
            fn($key) => !is_int($key)
        );

        $params = [];
        foreach($paramNames as $name) {
            if (in_array($name, $this->template->params())) {
                $params[$name] = $matches[$name][0];
            }            
        }

        return $params;
    }
}