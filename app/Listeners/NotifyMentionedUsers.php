<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        
        // $mentionedUsers = $event->reply->mentionedUsers();

        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(function($user) use($event){
                $user->notify(new YouWereMentioned($event->reply));
            });


        // foreach($mentionedUsers as $name){
        //     if( $user = User::whereName($name)->first()){
        //         $user->notify(new YouWereMentioned($event->reply));
        //     }
        // }
    }
}
