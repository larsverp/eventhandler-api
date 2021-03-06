<?php

namespace App\Http\Controllers;

use App\Hosts;
use App\hos_use;
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
            'insertion' => 'max:191|string',
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
            'insertion' => 'max:191|string',
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

    public function follow(Request $request){
        $ValidateAttributes = request()->validate([
            'host_id' => ['required', 'uuid', 'exists:hosts,id']
        ]);
        $ValidateAttributes["user_id"] = $request->user()->id;

        $data = hos_use::where('host_id', $ValidateAttributes["host_id"])
            ->where('user_id', $ValidateAttributes["user_id"])
            ->First();
        if($data == null){
            $data = hos_use::FindOrFail(hos_use::create($ValidateAttributes)->id);
        }
        $data->update(['following' => true]);
        return response($data, 201);
    }

    public function unfollow($id, Request $request){
        $unfollow = hos_use::where('user_id', $request->user()->id)
            ->where('host_id', $id)
            ->FirstOrFail();
        $unfollow->update(['following' => false]);
        return response($unfollow, 200);
    }

    public function followers($id, Request $request){
        $users = hos_use::where('host_id', $id)
            ->where('following', true)
            ->pluck('user_id');
        return response()->json([
            "total" => count($users)
        ], 200);
    }
}