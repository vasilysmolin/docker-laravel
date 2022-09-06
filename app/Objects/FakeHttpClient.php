<?php

namespace App\Objects;


class FakeHttpClient
{

    public function users() {
        return $this;
    }

    public function get() {
        return [];
    }

}
