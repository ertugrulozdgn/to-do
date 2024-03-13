<?php

namespace App\Console\Commands;

use App\Models\Task;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use NunoMaduro\Collision\Provider;

class TasksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tasks-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected array $providerPaths = [
        'App\DataProviders\Provider1',
        'App\DataProviders\Provider2',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Command Başladı');
        foreach ($this->providerPaths as $providerPath) {
            $provider = app($providerPath);

            $this->info('Veri çekiliyor: ' . $provider->getUrl());
            $data = $this->getData($provider->getUrl());

            foreach ($data as $item) {
                try {
                    Task::create($provider->getProviderValue($item));
                } catch (\Exception $e) {
                    $this->error('Hata oluştu: ' . $e->getMessage());
                }
            }
        }
        $this->info('Command Bitti');
    }

    private function getData($url)
    {
        $client = new Client();

        $response = $client->get($url);

        return json_decode($response->getBody(), true);
    }
}
