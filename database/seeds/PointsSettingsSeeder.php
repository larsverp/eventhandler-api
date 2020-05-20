<?php

use App\points_settings;
use Illuminate\Database\Seeder;

class PointsSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'event_subscribe' => 1,
            'event_unsubscribe' => -1,
            'host_review_one_star' => -3,
            'host_review_two_star' => -2,
            'host_review_three_star' => 1,
            'host_review_four_star' => 2,
            'host_review_five_star' => 3,
            'cat_review_one_star' => -3,
            'cat_review_two_star' => -2,
            'cat_review_three_star' => 1,
            'cat_review_four_star' => 2,
            'cat_review_five_star' => 3,
            'tinder_like' => 5,
            'tinder_dislike' => -5
        );
        
        foreach($data as $key => $value){
            points_settings::create([
                'setting' => $key,
                'value' => $value
            ]);
        }
    }
}
