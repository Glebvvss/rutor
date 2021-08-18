<?php

namespace Ruter\Request;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request as BaseRequest;

class Request implements RequestInterface
{
    private BaseRequest $baseRequest;

    private array $params  = [];
    private array $cookies = [];
    private array $files   = [];
    private array $server  = [];

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
            $this->params  = $params,
            $this->cookies = $cookies,
            $this->files   = $files,
            $this->server  = $server
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

    public function withUri(string $uri): self
    {
        return new static(
            $uri, 
            $this->method(),
            $this->params,
            $this->cookies,
            $this->files,
            $this->server
        );
    }
}