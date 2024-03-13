<?php

namespace App\DataProviders;

use App\Interface\IProvider;

class Provider1 implements IProvider
{

    public function getUrl(): string
    {
        return 'https://run.mocky.io/v3/27b47d79-f382-4dee-b4fe-a0976ceda9cd';
    }

    public function getProviderValue(array $data): array
    {
        return [
            'name' => $data['id'],
            'duration' => $data['sure'],
            'difficulty' => $data['zorluk'],
            'work_units_needed' => $data['sure'] * $data['zorluk']
        ];
    }

}
