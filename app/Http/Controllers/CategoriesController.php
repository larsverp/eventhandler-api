<?php

namespace App\Http\Controllers;

use App\Categories;
use App\CatEve;
use App\cat_use;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(){
        return Categories::all();
    }

    public function event($id){
        $cat_ids = CatEve::where('event_id', $id)->pluck('category_id');
        return Categories::whereIn('id', $cat_ids)->get();
    }

    public function show($id){
        return Categories::FindOrFail($id);
    }

    public function create(){
        $ValidateAttributes = request()->validate([
            'name' => 'required|max:191|string',
            'thumbnail' => 'required|max:1000|active_url',
            'description' => 'required|string',
        ]);
        $category = Categories::FindOrFail(Categories::create($ValidateAttributes)->id);
        return response($category, 201);
    }

    public function update($id){
        $category = Categories::FindOrFail($id);
        $ValidateAttributes = request()->validate([
            'name' => 'max:191|string',
            'thumbnail' => 'max:1000|active_url',
            'description' => 'string',
        ]);
        if($category->update($ValidateAttributes)){
            return $category;
        }
        else{
            return response($category->id, 400);
        }
    }

    public function remove($id){
        $category = Categories::FindOrFail($id);
        $category->delete();
        return response($category, 200);
    }

    public function follow(Request $request){
        $ValidateAttributes = request()->validate([
            'category_id' => ['required', 'uuid', 'exists:categories,id']
        ]);
        $ValidateAttributes["user_id"] = $request->user()->id;

        $data = cat_use::where('category_id', $ValidateAttributes["category_id"])
            ->where('user_id', $ValidateAttributes["user_id"])
            ->First();
        if($data == null){
            $data = cat_use::FindOrFail(cat_use::create($ValidateAttributes)->id);
        }
        $data->update(['following' => true]);
        return response($data, 201);
    }

    public function unfollow($id, Request $request){
        $unfollow = cat_use::where('user_id', $request->user()->id)
            ->where('category_id', $id)
            ->FirstOrFail();
        $unfollow->update(['following' => false]);
        return response($unfollow, 200);
    }

    public function followers($id, Request $request){
        $users = cat_use::where('category_id', $id)
            ->where('following', true)
            ->pluck('user_id');
        return response()->json([
            "total" => count($users)
        ], 200);
    }
}
