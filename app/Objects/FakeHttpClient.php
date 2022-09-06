<?php

namespace App\Objects;

class FakeHttpClient
{
    public function users(): object
    {
        return $this;
    }

    public function get(): array
    {
        return [];
    }
}
