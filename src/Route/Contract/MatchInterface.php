<?php

namespace Ruter\Route\Contract;

interface MatchInterface
{
    public function isSuccessfull(): bool;

    public function extra(): array;
}