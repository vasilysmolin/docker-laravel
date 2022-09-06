<?php

namespace App\Objects;

interface ApiUsersParserInterface
{
    public function users(): object;

    public function get(): array;
}
