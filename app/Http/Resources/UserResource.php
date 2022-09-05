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
            'name' => $this->first_name,
            'email' => $this->email,
            'photo' => $files->getFilePath($this->image),
        ];
    }
}
