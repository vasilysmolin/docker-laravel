<?php

namespace Tests\Unit;

use App\Objects\ApiUsersParserInterface;
use App\Objects\FakeHttpClient;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UserParserVKTest extends TestCase
{

    public function testUsersConsole()
    {
//        Http::fake([
//            'https://api.vk.com/method/*' => Http::response([
//                'name' => 'test',
//                'email' => 'test@test.ru',
//                'photo' => null,
//            ], 200),
//        ]);
        app()->bind(ApiUsersParserInterface::class, FakeHttpClient::class);
        $this->artisan('parse-vk-users')->assertExitCode(0);
    }
}
