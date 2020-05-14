<?php

namespace App\Http\Controllers;

use App\Events;
use App\Cat_Eve;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index(Request $request){
        if($request->user()->role == "rockstar" || $request->user()->role == "admin"){
            return Events::all();
        }
        else{
            return Events::where('rockstar', false)->get();
        }
    }

    public function preview(){
        return Events::where('rockstar', false)->get();
    }

    public function show($id){
        return Events::FindOrFail($id);
    }

    public function create(){
        $ValidateAttributes = request()->validate([
            'title' => 'required|max:191|string',
            'description' => 'required|string',
            'host_id' => 'uuid|exists:hosts,id',
            'begin_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:begin_date',
            'thumbnail' => 'required|max:1000|active_url',
            'seats' => 'required|integer|min:0',
            'postal_code' => 'required|postal_code:NL,BE,DE',
            'hnum' => 'required|max:191|string',
            'categories' => 'required|array',
            'notification' => 'required|boolean',
            'rockstar' => 'required|boolean'
        ]);
        $event = Events::FindOrFail(Events::create($ValidateAttributes)->id);
        foreach($ValidateAttributes["categories"] as $category){
            Cat_Eve::create(['event_id' => $event->id, 'category_id' => $category]);
        }
        return response($event, 201);
    }

    public function update($id){
        $event = Events::FindOrFail($id);
        $ValidateAttributes = request()->validate([
            'title' => 'max:191|string',
            'description' => 'string',
            'host_id' => 'string|max:191|exists:hosts,id',
            'begin_date' => 'date|after_or_equal:today',
            'end_date' => 'date|after_or_equal:begin_date',
            'thumbnail' => 'max:1000|active_url',
            'seats' => 'integer|min:0',
            'postal_code' => 'postal_code:NL,BE,DE',
            'hnum' => 'max:191|string',
            'categories' => 'array',
            'notification' => 'boolean',
            'rockstar' => 'boolean'
        ]);
        
        if(isset($ValidateAttributes["categories"])){
            $previous = Cat_Eve::where('event_id', $event->id)->get();
            $previous->delete();
            foreach($ValidateAttributes["categories"] as $category){
                Cat_Eve::create(['event_id' => $event->id, 'category_id' => $category]);
            }
        }

        if($event->update($ValidateAttributes)){
            return $event;
        }
        else{
            return response($event->id, 400);
        }
    }

    public function remove($id){
        $event = Events::FindOrFail($id);
        $event->delete();
        return response($event, 200);
    }
}