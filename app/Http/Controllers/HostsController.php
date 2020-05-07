<?php

namespace App\Http\Controllers;

use App\Hosts;
use Illuminate\Http\Request;

class HostsController extends Controller
{
    public function index(Request $request){
        return Hosts::all();
    }

    public function show($id){
        return Hosts::FindOrFail($id);
    }

    public function create(){
        $ValidateAttributes = request()->validate([
            'first_name' => 'required|max:191|string',
            'last_name' => 'required|max:191|string',
            'description' => 'required|string',
            'picture' => 'required|max:1000|active_url',
        ]);
        $host = Hosts::FindOrFail(Hosts::create($ValidateAttributes)->id);
        return response($host, 201);
    }

    public function update($id){
        $host = Hosts::FindOrFail($id);
        $ValidateAttributes = request()->validate([
            'first_name' => 'max:191|string',
            'last_name' => 'max:191|string',
            'description' => 'string',
            'picture' => 'max:1000|active_url',
        ]);
        if($host->update($ValidateAttributes)){
            return $host;
        }
        else{
            return response($host->id, 400);
        }
    }

    public function remove($id){
        $host = Hosts::FindOrFail($id);
        $host->delete();
        return response($host, 200);
    }
}