<?php

namespace Ruter\Request;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request as BaseRequest;

class Request implements RequestInterface
{
    private BaseRequest $baseRequest;

    public static function fromGlobals()
    {
        return new self(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD'],
            $_REQUEST,
            $_COOKIE,
            $_FILES,
            $_SERVER
        );
    }

    public function __construct(
        string $uri,
        string $method  = '',
        array  $params  = [],
        array  $cookies = [],
        array  $files   = [],
        array  $server  = []
    )
    {
        $isSupportedMethod = in_array(
            $method = mb_strtoupper($method) ?: static::METHOD_GET,
            static::SUPPORTED_METHODS
        );

        if (!$isSupportedMethod) {
            throw new InvalidArgumentException(
                'Method "' . $method . '" is not supported'
            );
        }

        $this->baseRequest = BaseRequest::create(
            $uri,
            $method,
            $params,
            $cookies,
            $files,
            $server
        );
    }

    public function uri(): string
    {
        return $this->baseRequest->getRequestUri();
    }

    public function path(): string
    {
        return $this->baseRequest->getPathInfo();
    }

    public function method(): string
    {
        return $this->baseRequest->getMethod();
    }

    public function params(): array
    {
        return $this->queryParams() + $this->queryParams();
    }

    public function queryParams(): array
    {
        return $this->baseRequest
                    ->query
                    ->all();
    }

    public function bodyParams(): array
    {
        return $this->baseRequest
                    ->request
                    ->all();
    }

    public function headers(): array
    {
        return $this->baseRequest
                    ->server
                    ->getHeaders();
    }

    public function files(): array
    {
        return $this->baseRequest
                    ->files
                    ->all();
    }

    public function cookies(): array
    {
        return $this->baseRequest
                    ->cookies
                    ->all();
    }

    public function withUri(string $uri): self
    {
        return new static(
            $uri, 
            $this->method(),
            $this->params(),
            $this->cookies(),
            $this->files(),
            $this->baseRequest->server->all()
        );
    }
}