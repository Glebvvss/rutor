<?php

namespace Ruter\Route\Common;

use Ruter\Route\Contracts\MatchInterface;

class Match implements MatchInterface
{
    private bool  $success;
    private array $extra;

    public function __construct(bool $success, array $extra = [])
    {
        $this->success = $success;
        $this->extra   = $extra;
    }

    public function isSuccessfull(): bool
    {
        return $this->success;
    }

    public function extra(): array
    {
        return $this->extra;
    }
}