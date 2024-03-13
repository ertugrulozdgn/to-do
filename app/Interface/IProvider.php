<?php

namespace App\Interface;

interface IProvider
{
    public function getUrl(): string;

    public function getProviderValue(array $data): array;

}
