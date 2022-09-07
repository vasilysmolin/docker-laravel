<?php

namespace App\Http\Resources;

use App\Objects\Files;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UsersResource extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(fn($item) => [
                'name' => "{$item->first_name} {$item->last_name}",
                'email' => $item->email,
                'photo' => !empty($item->getFirstMedia('image')) ? $item->getFirstMedia('image')->getUrl() : null,
            ]),
        ];
    }
}
