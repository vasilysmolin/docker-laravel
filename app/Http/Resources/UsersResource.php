<?php

namespace App\Http\Resources;

use App\Objects\Files;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UsersResource extends ResourceCollection
{

    public function toArray($request)
    {
        $files = resolve(Files::class);
        return [
            'data' => $this->collection->map(fn($item) => [
                'name' => $item->first_name,
                'email' => $item->email,
                'photo' => $files->getFilePath($item->image),
            ]),
        ];
    }
}
