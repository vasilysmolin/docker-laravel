<?php

namespace App\Console\Commands;

use App\Events\UserSaveEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use VK\Client\VKApiClient;

class ParserVKUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse-vk-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'parse-vk-users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $vk = new VKApiClient();
        $response = $vk->users()
            ->get(config('app.vk_api'), [
                'user_ids' => range(1,3),
                'fields' => ['photo_400_orig','nickname'],
            ]);
        collect($response)->each(fn($user) => event(new UserSaveEvent($user)));

        Log::info(__('console.success_import'));
    }
}
