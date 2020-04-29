<?php

namespace App\Http\Controllers;

use App\Events;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index(){
        return Events::all();
    }

    public function show($id){
        return Events::FindOrFail($id);
    }

    public function create(){
        
        $ValidateAttributes = request()->validate([
            'title' => 'required|max:191|string',
            'description' => 'required|string',
            'begin_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:begin_date',
            'thumbnail' => 'required|max:1000|active_url',
            'seats' => 'required|integer|min:0',
            'postal_code' => 'required|postal_code:NL,BE,DE',
            'hnum' => 'required|max:191|string',
            'notification' => 'required|boolean'    
        ]);
        $event = Events::FindOrFail(Events::create($ValidateAttributes)->id);
        return response($event, 201);
    }

    public function update($id){
        $event = Events::FindOrFail($id);
        $ValidateAttributes = request()->validate([
            'title' => 'max:191|string',
            'description' => 'string',
            'begin_date' => 'date|after_or_equal:today',
            'end_date' => 'date|after_or_equal:begin_date',
            'thumbnail' => 'max:1000|active_url',
            'seats' => 'integer|min:0',
            'postal_code' => 'postal_code:NL,BE,DE',
            'hnum' => 'max:191|string',
            'notification' => 'boolean'
        ]);
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