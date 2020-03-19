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
            'title' => 'required|max:191|string|unique:events,title',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'thumbnail' => 'required|max:191|active_url',
            'seats' => 'required|integer|min:0',
            'postal_code' => 'required|postal_code:NL,BE,DE',
            'hnum' => 'required|max:191|string',
            'notification' => 'required|boolean'    
        ]);
        Events::create($ValidateAttributes);
        return response($ValidateAttributes, 201);
    }

    public function update($id){
        $event = Events::FindOrFail($id);
        $ValidateAttributes = request()->validate([
            'title' => 'max:191|string|unique:events,title',
            'description' => 'string',
            'date' => 'date|after_or_equal:today',
            'thumbnail' => 'max:191|active_url',
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
}