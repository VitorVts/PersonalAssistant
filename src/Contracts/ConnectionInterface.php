<?php

namespace App\Contracts;

interface ConnectionInterface
{
    public function getApiUrl(): string;
}
