<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function check(Request $request){
        $ValidateAttributes = request()->validate([
            'username' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        $user = User::where('email', $ValidateAttributes["username"])->firstOrFail();

        $data = [
            'username' => $ValidateAttributes["username"],
            'password' => $ValidateAttributes["password"],
            'client_id' => env('CLIENT_ID', '1'),
            'client_secret' => env('CLIENT_SECRET', 'mTw2NYRyqBGt0hlPzEAzHQiH6Vwy2DzXTnOMVhYY'),
            'grant_type' => 'password',
            'scope' => $user->role
        ];

        $request = app('request')->create('/oauth/token', 'POST', $data);
        $response = app('router')->prepareResponse($request, app()->handle($request));

        return $response;
    }

    public function create(Request $request){

        $ValidateAttributes = request()->validate([
            'first_name' => 'required|max:191|string',
            'insertion' => 'max:191|string',
            'last_name' => 'required|max:191|string',
            'email' => 'required|max:191|email:rfc,dns|unique:users,email',
            'postal_code' => 'required|postal_code:NL,BE,DE',
            'password' => 'required|max:191|string'
        ]);

        $ValidateAttributes["password"] = Hash::make($ValidateAttributes["password"]);
        $ValidateAttributes["role"] = "guest";

        User::create($ValidateAttributes);

        $ValidateAttributes["password"] = "secret";
        return $ValidateAttributes;
    }

    public function rockstar(Request $request){

        $ValidateAttributes = request()->validate([
            'first_name' => 'required|max:191|string',
            'insertion' => 'max:191|string',
            'last_name' => 'required|max:191|string',
            'email' => 'required|max:191|email:rfc,dns|unique:users,email',
            'password' => 'required|max:191|string'
        ]);

        $ValidateAttributes["password"] = Hash::make($ValidateAttributes["password"]);
        $ValidateAttributes["role"] = "rockstar";

        User::create($ValidateAttributes);

        $ValidateAttributes["password"] = "secret";
        return $ValidateAttributes;
    }
}
