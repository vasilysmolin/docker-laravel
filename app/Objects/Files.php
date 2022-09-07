<?php

namespace App\Objects;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Files
{
    public function saveByUrl(User $model, string $url): void
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $contents = @file_get_contents($url, false, stream_context_create($arrContextOptions));
        if ($contents !== false) {
            $name = Str::random(40);
            $path = $this->getOptimizeDirectory($name);
            Storage::disk('public')->put(
                $path . 'jpg',
                $contents
            );
            $model
                ->addMedia(Storage::disk('public')->path($path . 'jpg'))
                ->toMediaCollection('image', config('app.flysystem_driver'));
        }
    }

    protected function getOptimizeDirectory(string $string): string
    {
        $dir = '';
        if (mb_strlen($string, 'utf-8') > 4) {
            $dir = mb_substr($string, 0, 2, 'utf-8') . '/' .  mb_substr($string, 2, 2, 'utf-8') . '/';
        }

        return $dir . $string . '/' . $string;
    }
}
