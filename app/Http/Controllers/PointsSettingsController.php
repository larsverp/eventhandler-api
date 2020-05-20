<?php

namespace App\Http\Controllers;

use App\points_settings;
use Illuminate\Http\Request;

class PointsSettingsController extends Controller
{
    public function index(Request $request){
        return points_settings::all();
    }

    public function update(){
        $ValidateAttributes = request()->validate([
            'event_subscribe' => 'integer',
            'event_unsubscribe' => 'integer',
            'host_review_one_star' => 'integer',
            'host_review_two_star' => 'integer',
            'host_review_three_star' => 'integer',
            'host_review_four_star' => 'integer',
            'host_review_five_star' => 'integer',
            'cat_review_one_star' => 'integer',
            'cat_review_two_star' => 'integer',
            'cat_review_three_star' => 'integer',
            'cat_review_four_star' => 'integer',
            'cat_review_five_star' => 'integer',
            'tinder_like' => 'integer',
            'tinder_dislike' => 'integer',
        ]);

        foreach($ValidateAttributes as $key => $value){
            points_settings::where('setting', $key)->update(["value" => $value]);
        }
        
        return response(points_settings::all(), 200);
    }
}
