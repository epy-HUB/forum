<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\activity;

class ProfilesController extends Controller
{
    public function show(User $user){



    // return $activities;
        return view('profiles.show', [
            'profileUser' => $user,
            // 'threads' => $user->threads()->paginate(30),
            'activities' =>\App\Activity::feed($user)
        ]);
    }

    
}
