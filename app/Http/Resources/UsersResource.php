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
                /** @phpstan-ignore-line */
                'name' => $item->first_name,
                /** @phpstan-ignore-line */
                'email' => $item->email,
                /** @phpstan-ignore-line */
                'photo' => $files->getFilePath($item->image),
            ]),
        ];
    }
}
