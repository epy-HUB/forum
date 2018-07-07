<?php

namespace App\Http\Controllers;

use App\Channel;

use Illuminate\Http\Request;

class ChannelsController extends Controller
{
    public function index(){
        $channels = Channel::latest()->orderBy('created_at', 'desc')->get();
    
        if(request()->wantsJson()){
            return $channels;
        }
         return view('channel',  compact('channels'));
    }

    public function store (Request $request){
        $this->validate($request, [
            'name' => 'required|spamfree|unique:channels',
            'desc' => 'required|spamfree'
        ]);

        return Channel::create([
            'name' => $request->input(['name']),
            'desc' => $request->input(['desc']),
            'slug' => str_slug($request->input(['name']))
        ]);
     }

    public function show($id){
        return Channel::findOrFail($id);
    }

    public function update(Request $request, $id){
        Channel::findOrFail($id)->update([
            'name' => $request->input(['name']),
            'desc' => $request->input(['desc']),
            'slug' => str_slug($request->input(['name']))
        ]);
    }

    public function  destroy($id){
        Channel::findOrFail($id)->delete();
            // return Channel::destroy($id);
         
    }
}
