<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;

class BestRepliesController extends Controller
{
    public function store(Reply $reply){

        // abort_if($reply->thread->user_id != auth()->id(), 403);
        $this->authorize('update', $reply->thread);
        // $reply->thread->update(['best_reply_id' => $reply->id]);
        $reply->thread->markBestReply($reply);
    }
}
