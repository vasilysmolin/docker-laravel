<?php

namespace App\Listeners;

use App\Events\UserSaveEvent;
use App\Models\User;
use App\Objects\Files;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserSaveListener
{

    public function handle(UserSaveEvent $event): void
    {
        $photo = !empty($event->user['photo_400_orig']) ? $event->user['photo_400_orig'] : null;
        $event->user['external_id'] = $event->user['id'];
        $user = User::where('external_id', $event->user['id'])->first();
        if(!empty($user)){
            $user->fill($event->user);
            $user->update();
        } else {
            $user = new User();
            $user->fill($event->user);
            $user->save();
        }

        if(!empty($photo)) {
            $files = resolve(Files::class);
            $files->saveByUrl($user, $photo);
        }
    }
}
