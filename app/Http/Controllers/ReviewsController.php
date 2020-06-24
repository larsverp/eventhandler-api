<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reviews;

class ReviewsController extends Controller
{
    public function index(Request $request){
        return response
        return Reviews::all();
    }

    public function show($id){
        return Reviews::Where('event_id', $id)
            ->Where('approved', true)
            ->get();
    }

    public function check(){
        return Reviews::Where('approved', false)->get();
    }

    public function create(Request $request){
        $ValidateAttributes = request()->validate([
            'event_id' => 'required|uuid|exists:events,id',
            'title' => 'required|max:191|string',
            'rating' => 'required|integer|max:5',
            'description' => 'string',
        ]);
        
        $ValidateAttributes["user_id"] = $request->user()->id;

        $review = Reviews::FindOrFail(Reviews::create($ValidateAttributes)->id);
        return response($review, 201);
    }

    public function approve($id){
        $review = Reviews::FindOrFail($id);
        $review->update(['approved' => true]);
        return response($review, 200);
    }

    public function remove($id){
        $review = Reviews::FindOrFail($id);
        $review->delete();
        return response($review, 200);
    }
}
