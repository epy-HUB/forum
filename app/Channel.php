<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{ 

    use RecordsActivity;

    // protected $fillable = ['name', 'slug'];
    
    protected $guarded = [];

    protected static function boot(){
        parent::boot();

        // static::addGlobalScope('replyCount', function($builder){
        //     $builder->withCount('replies');
        // });

        static::deleting(function ($model){
            
            $model->threads->each->delete();
            // dd('thread');
            // $thread->replies->each(function ($reply){
            //     $repl->delete();
            // });
        });

        
    }


    public function getRouteKeyName(){ 
        return 'slug';
    }

    public function threads(){
        return $this->hasMany(Thread::class);
    }

    public function path(){
        return $this->thread->path() . "/$this->slug";
    }
}
