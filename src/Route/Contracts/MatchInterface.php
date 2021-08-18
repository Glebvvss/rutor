<?php

namespace Ruter\Route\Contracts;

interface MatchInterface
{
    public function isSuccessfull(): bool;

    public function extra(): array;
}