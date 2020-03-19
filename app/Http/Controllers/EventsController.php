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
        return request()->all();
    }
}
