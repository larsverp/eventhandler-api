<?php

namespace App\Points;

use Illuminate\Http\Request;
use App\hos_use;
use App\cat_use;
use App\points_settings;

class Points
{
    static function Hosts($setting, $host, Request $request){
        $settings = points_settings::pluck('setting')->toArray();
        if(in_array($setting, $settings)){
            $data = hos_use::where('host_id', $host)
                        ->where('user_id', $request->user()->id)
                        ->First();
            if($data == null){
                $data = hos_use::FindOrFail(hos_use::create(['host_id' => $host, 'user_id' => $request->user()->id])->id);
            }
            $newPoints = $data->points + points_settings::where('setting', $setting)->pluck('value')[0];
            $data->update(['points' => $newPoints]);
        }
        else{
            dd( response()->json([
                'succes' => false,
                'reason' => 'The given setting is not a valid setting, see documentation for further info'
            ], 403));
        }
    }

    static function Categories($setting, $category, Request $request){
        $settings = points_settings::pluck('setting')->toArray();
        if(in_array($setting, $settings)){
            $data = cat_use::where('category_id', $category)
                        ->where('user_id', $request->user()->id)
                        ->First();
            if($data == null){
                $data = cat_use::FindOrFail(cat_use::create(['category_id' => $category, 'user_id' => $request->user()->id])->id);
            }
            $newPoints = $data->points + points_settings::where('setting', $setting)->pluck('value')[0];
            $data->update(['points' => $newPoints]);
        }
        else{
            dd( response()->json([
                'succes' => false,
                'reason' => 'The given setting is not a valid setting, see documentation for further info'
            ], 403));
        }
    }
    
}