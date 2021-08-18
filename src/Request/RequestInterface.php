<?php

namespace Ruter\Request;

interface RequestInterface
{
    const METHOD_GET     = 'GET';
    const METHOD_HEAD    = 'HEAD';
    const METHOD_POST    = 'POST';
    const METHOD_PATCH   = 'PATCH';
    const METHOD_PUT     = 'PUT';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_OPTIONS = 'OPTIONS';

    const SUPPORTED_METHODS = [
        self::METHOD_GET,
        self::METHOD_HEAD,
        self::METHOD_POST,
        self::METHOD_PATCH,
        self::METHOD_PUT,
        self::METHOD_DELETE,
        self::METHOD_OPTIONS,
    ];

    public function uri(): string;

    public function path(): string;

    public function method(): string;

    public function queryParams(): array;

    public function bodyParams(): array;

    public function headers(): array;

    public function files(): array;

    public function withUri(string $uri): self;
}