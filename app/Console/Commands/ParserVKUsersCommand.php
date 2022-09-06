<?php

namespace App\Console\Commands;

use App\Events\UserSaveEvent;
use App\Objects\ApiUsersParserInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        $apiUsersParser = resolve(ApiUsersParserInterface::class);
        $response = $apiUsersParser->users()
            ->get(config('app.vk_api'), [
                'user_ids' => range(1,200),
                'fields' => ['photo_400_orig','nickname'],
            ]);
        collect($response)->each(fn($user) => event(new UserSaveEvent($user)));

        Log::info(__('console.success_import'));
        return 0;
    }
}
