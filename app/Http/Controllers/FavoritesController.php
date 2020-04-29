<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorites;
use App\Events;

class FavoritesController extends Controller
{
    public function show(Request $request){
        $favorites = Favorites::where('user_id', $request->user()->id)->pluck('event_id');
        return Events::find($favorites);
    }

    public function create(Request $request){
        $ValidateAttributes = request()->validate([
            'event_id' => ['required', 'uuid', 'exists:events,id', 'unique:favorites,event_id,NULL,id,user_id,'.$request->user()->id]
        ]);
        $ValidateAttributes["user_id"] = $request->user()->id;
        
        $favorite = Favorites::FindOrFail(Favorites::create($ValidateAttributes)->id);
        return response($favorite, 201);
    }

    public function remove($id, Request $request){
        $favorite = Favorites::where('user_id', $request->user()->id)
            ->where('event_id', $id)
            ->FirstOrFail();
        $favorite->delete();
        return response($favorite, 200);
    }
}
