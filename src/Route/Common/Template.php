<?php

namespace Ruter\Route\Common;

class Template
{
    private const PARAM_REGEXP = '[^/]+';

    private string $template;

    public function __construct(string $template)
    {
        $this->template = $template;
    }

    public function toRegExp(): string
    {
        $regExp = '~^' . $this->template . '$~ui';
        foreach ($this->params() as $param) {
            $regExp = preg_replace(
                '~\{' . $param . '\}~ui', 
                '(?<' . $param . '>' . static::PARAM_REGEXP . ')', 
                $regExp
            );
        }

        return $regExp;
    }

    public function toString(): string
    {
        return $this->template;
    }

    public function params(): array
    {
        preg_match_all(
            '~{(' . static::PARAM_REGEXP . ')}~ui', 
            $this->template, 
            $matches
        );

        return isset($matches[1]) ? $matches[1] : [];
    }
}