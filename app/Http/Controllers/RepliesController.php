<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests\CreatePostRequest;

use App\Notifications\YouWereMentioned;

use App\Thread;
use App\Reply;
use App\User;



class RepliesController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['except' => 'index']);
    }

    public function index($channelId, Thread $thread){
        
        return $thread->replies()->paginate(10);
    }

    public function store($channelId, Thread $thread, CreatePostRequest $form){

        return $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ])->load('owner');
       
    }

    public function update(Reply $reply){

        $this->authorize('update', $reply);

        $this->validate(request(), [
            'body' => 'required|spamfree'
        ]);

            $reply->update( request(['body']));

    }

    public function destroy(Reply $reply){

        $this->authorize('update', $reply);
        $reply->delete();

        if(request()->expectsJson()){
            return response(['status' => 'Reply Deleted']);
        }

        return back();
    }

  
}
