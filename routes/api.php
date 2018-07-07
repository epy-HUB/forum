<?php

use Illuminate\Http\Request;
use App\Channel;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function(){
    Route::get('channel', function(){
        return Channel::latest()->orderBy('created_at', 'desc')->get();
    });

    Route::get('channel/{id}', function($id){
       return Channel::findOrFail($id);
    });

    Route::post('channel/store', function(Request $request){
        return Channel::create([
            'name' => $request->input(['name']),
            'slug' => $request->input(['slug'])
        ]);
     });

    Route::patch('channel/{id}', function(Request $request, $id){
        Channel::findOrFail($id)->update([
            'name' => $request->input(['name']),
            'slug' => $request->input(['slug'])
        ]);
     });

    Route::delete('channel/{id}', function($id){
        return Channel::destroy($id);
     });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
