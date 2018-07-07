<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;

use App\Events\ThreadReceivedNewReply;
class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];
    protected $with = ['creator', 'channel'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot(){
        parent::boot();

        // static::addGlobalScope('replyCount', function($builder){
        //     $builder->withCount('replies');
        // });

        static::deleting(function ($thread){
            
            $thread->replies->each->delete();
            // dd('thread');
            // $thread->replies->each(function ($reply){
            //     $repl->delete();
            // });
        });

        
    }


  


    public function path(){
        return '/threads/'. $this->channel->slug. '/'. $this->slug;
    }


    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel(){
        return $this->belongsTo(Channel::class);
    }


    public function addReply($reply){
        $reply =  $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        // $this->notifySubscribers($reply);

        // $this->subscriptions->filter(function ($sub) use($reply){
        //     return $sub->user_id !=  $reply->user_id;
        // })->each->notify($reply);

        // foreach($this->subscriptions as $subscription){
        //     if($subscription->user_id !=  $reply->user_id){
        //         $subscription->user->notify(new ThreadWasUpdated($this, $reply));
        //     }
        // }


        return $reply;
    }

    // public function notifySubscribers($reply){
    //     $this->subscriptions
    //         ->where('user_id', '!=', $reply->user_id)
    //         ->each
    //         ->notify($reply);
    // }


    public function scopeFilter($query, $filters){
        return $filters->apply($query);
    }

    public function unsubscribe($userId = null){
        $this->subscriptions()
        ->where('user_id', $userId ? : auth()->id())
        ->delete();
    }

    public function subscribe($userId = null){
        $this->subscriptions()->create([
            'user_id' => $userId ? : auth()->id()
        ]);
    }

    public function subscriptions(){
       return $this->hasMany(ThreadSubscription::class);
    }


    public function getIsSubscribedToAttribute(){
       return $this->subscriptions()
        ->where('user_id', auth()->id())
        ->exists();
    }

    public function hasUpdatesFor($user){
        
        // $user = $user ?: auth()->user();
        $key = $user->visitedThreadCacheKey($this);
       
        return $this->updated_at > cache($key);
    }

    public function getRouteKeyName(){ 
        return 'slug';
    }

    // public function setSlugAttribute($value){

    //     if(static::whereSlug($slug = str_slug($value))->exists()){
    //         $slug = $this->incrementSlug($slug);
    //     }

    //     $this->attributes['slug'] = $slug;
    // }

    public function setSlugAttribute($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }
        
        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug){
        $max = static::whereTitle($this->title)->latest('id')->value('slug');
        // dd($max);
        if(is_numeric($max[-1])){
            // dd('here');
            return preg_replace_callback('/(\d+)$/', function($matches){
                
                return $matches[1] + 1;
            }, $max);

        }
        
        return "{$slug}-2";
    }
}
