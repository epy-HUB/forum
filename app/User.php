<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoleAndPermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path', 'isAdmin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email', 
    ];

    public function getRouteKeyName(){
        return 'name';
    }

    public function threads(){
        return $this->hasMany(Thread::class)->latest();
    }

    public function lastReply(){
        return $this->hasOne(Reply::class)->latest();
    }

    public function activity(){
        return $this->hasMany(Activity::class)->latest();
    }


    public function read($thread){
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
         );
    }


    public function getAvatarPathAttribute($avatar){

        // return asset( $avatar ?: 'images/avatars/default.png');
        if(!$avatar){
            return asset('images/avatars/default.png');
        }
        return asset('storage/'.$avatar);
    }

    public function visitedThreadCacheKey($thread){
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }
}
