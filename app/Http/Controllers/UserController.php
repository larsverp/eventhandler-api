<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function check(Request $request){
        $ValidateAttributes = request()->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $data = [
            'username' => $ValidateAttributes["username"],
            'password' => $ValidateAttributes["password"],
            'client_id' => env('CLIENT_ID', '2'),
            'client_secret' => env('CLIENT_SECRET', 'odDN1FhXATGjowUpcN8RTIfbNLfopO91QbHKplOg'),
            'grant_type' => 'password',
            'scope' => 'rockstar'
        ];

        $request = app('request')->create('/oauth/token', 'POST', $data);
        $response = app('router')->prepareResponse($request, app()->handle($request));

        return $response;
    }
}
