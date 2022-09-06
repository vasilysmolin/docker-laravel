<?php

namespace App\Http\Resources;

use App\Objects\Files;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $files = resolve(Files::class);

        return [
            /** @phpstan-ignore-line */
            'name' => $this->first_name,
            /** @phpstan-ignore-line */
            'email' => $this->email,
            /** @phpstan-ignore-line */
            'photo' => $files->getFilePath($this->image),
        ];
    }
}
