<?php

namespace Tests\Unit;

use App\Objects\ApiUsersParserInterface;
use App\Objects\FakeHttpClient;
use Tests\TestCase;

class UserParserVKTest extends TestCase
{

    public function testUsersConsole(): void
    {
        app()->bind(ApiUsersParserInterface::class, FakeHttpClient::class);
        $this->artisan('parse-vk-users')->assertExitCode(0);  /** @phpstan-ignore-line */
    }
}
