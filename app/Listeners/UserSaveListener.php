<?php

namespace App\Listeners;

use App\Events\UserSaveEvent;
use App\Models\User;
use App\Objects\Files;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserSaveListener
{

    public function handle(UserSaveEvent $event)
    {
        $photo = $event->user['photo_400_orig'];
        $user = new User();
        $user->fill($event->user);
        $user->save();
        if(!empty($photo)) {
            $files = resolve(Files::class);
            $files->saveByUrl($user, $photo);
        }
    }
}
