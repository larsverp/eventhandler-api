<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    //TODO make this damm function work!
    public function check(){
        $ValidateAttributes = request()->validate([
            'username' => 'required|email',
            'password' => 'required'   
        ]);

        $scope = 'rockstar';

        $response = Http::post('http://localhost/oauth/token', [
            'grant_type' => 'password',
            'client_id' => '2',
            'client_secret' => 'odDN1FhXATGjowUpcN8RTIfbNLfopO91QbHKplOg',
            'username' => request()->username,
            'password' => request()->password,
            'scope' => $scope
        ]);

        return $response->throw();;
        //return $ValidateAttributes;
    }
}
