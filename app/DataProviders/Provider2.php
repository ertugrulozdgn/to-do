<?php

namespace App\DataProviders;

use App\Interface\IProvider;

class Provider2 implements IProvider
{

    public function getUrl(): string
    {
        return 'https://run.mocky.io/v3/7b0ff222-7a9c-4c54-9396-0df58e289143';
    }

    public function getProviderValue(array $data): array
    {
        return [
            'name' => $data['id'],
            'duration' => $data['estimated_duration'],
            'difficulty' => $data['value'],
            'work_units_needed' => $data['estimated_duration'] * $data['value']
        ];
    }

}
