<?php

namespace App\Http\Controllers;

use App\Events;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function show(){
        $event = Events::all();
        return $event;
    }
}
