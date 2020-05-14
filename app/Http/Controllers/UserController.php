<?php

namespace App\Http\Controllers;

use App\User;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function update($id){
        $user = User::FindOrFail($id);
        $ValidateAttributes = request()->validate([
            'first_name' => 'max:191|string',
            'insertion' => 'max:191|nullable|string',
            'last_name' => 'max:191|string',
            'postal_code' => 'postal_code:NL,BE,DE',
            'password' => 'max:191|string'
        ]);
        if(isset($ValidateAttributes["password"])){
            $ValidateAttributes["password"] = Hash::make($ValidateAttributes["password"]);
        }
        if($user->update($ValidateAttributes)){
            return $user;
        }
        else{
            return response($user->id, 400);
        }
    }

    public function remove($id){
        $user = User::FindOrFail($id);
        $user->delete();
        return response($user, 200);
    }

    public function check(Request $request){
        $ValidateAttributes = request()->validate([
            'username' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        $user = User::where('email', $ValidateAttributes["username"])->firstOrFail();

        if($user->email_verified_at == null){
            return response()->json([
                'message'=>'The email is not validated'
            ], 401);
        }

        $data = [
            'username' => $ValidateAttributes["username"],
            'password' => $ValidateAttributes["password"],
            'client_id' => env('CLIENT_ID', '1'),
            'client_secret' => env('CLIENT_SECRET', 'ijuX5XpSvIA0eFegQxDnWzLzWEUwvitTxHMIWTso'),
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
            'insertion' => 'max:191|nullable|string',
            'last_name' => 'required|max:191|string',
            'email' => 'required|max:191|email:rfc,dns|unique:users,email',
            'postal_code' => 'required|postal_code:NL,BE,DE',
            'password' => 'required|max:191|string'
        ]);
        
        $ValidateAttributes["auth_code"] = rand(100000,999999);
        $ValidateAttributes["password"] = Hash::make($ValidateAttributes["password"]);
        $ValidateAttributes["role"] = "guest";
        
        User::create($ValidateAttributes);
        $this->send_mail($ValidateAttributes["email"]);

        $ValidateAttributes["password"] = "secret";
        $ValidateAttributes["auth_code"] = "secret";
        return $ValidateAttributes;
    }

    public function validation(Request $request){
        $ValidateAttributes = request()->validate([
            'email' => 'required|max:191|email:rfc,dns',
            'token' => 'required|integer'
        ]);

        $user = User::where('email', $ValidateAttributes["email"])->firstOrFail();

        if($user->email_verified_at != null){
            return response()->json([
                'message'=>'The email is already validated'
            ], 409);
        }

        if($user->auth_code == $ValidateAttributes["token"]){
            $user->update(['email_verified_at' => now()]);
            return response()->json([
                'message'=>'Validated'
            ], 201);
        }
        else{
            return response()->json([
                'message'=>'Token is incorrect'
            ], 401);
        }
    }

    public function rockstar(Request $request){

        $ValidateAttributes = request()->validate([
            'first_name' => 'required|max:191|string',
            'insertion' => 'max:191|string',
            'last_name' => 'required|max:191|string',
            'email' => 'required|max:191|email:rfc,dns|unique:users,email',
            'postal_code' => 'required|postal_code:NL,BE,DE',
            'password' => 'required|max:191|string'
        ]);

        $ValidateAttributes["password"] = Hash::make($ValidateAttributes["password"]);
        $ValidateAttributes["role"] = "rockstar";

        User::create($ValidateAttributes);

        $ValidateAttributes["password"] = "secret";
        return $ValidateAttributes;
    }

    public function admin(Request $request){

        $ValidateAttributes = request()->validate([
            'first_name' => 'required|max:191|string',
            'insertion' => 'max:191|string',
            'last_name' => 'required|max:191|string',
            'email' => 'required|max:191|email:rfc,dns|unique:users,email',
            'password' => 'required|max:191|string'
        ]);

        $ValidateAttributes["password"] = Hash::make($ValidateAttributes["password"]);
        $ValidateAttributes["role"] = "admin";

        User::create($ValidateAttributes);

        $ValidateAttributes["password"] = "secret";
        return $ValidateAttributes;
    }

    private function send_mail($mail){
        $user = User::where('email', $mail)->firstOrFail();
        
        if($user->email_verified_at != null){
            return response()->json([
                'message'=>'The email is already validated'
            ], 409);
        }

        $ValidateAttributes["name"] = $user->first_name;
        $ValidateAttributes["verify_code"] = $user->auth_code;
        $ValidateAttributes["email"] = $user->email;
        
        $gifs = array("https://media.giphy.com/media/TdfyKrN7HGTIY/giphy.gif", "https://media.giphy.com/media/b5LTssxCLpvVe/giphy.gif", "https://media.giphy.com/media/3og0ICmyySyzbmnxqE/giphy.gif", "https://media.giphy.com/media/xT5LMHxhOfscxPfIfm/giphy.gif", "https://media.giphy.com/media/xT5LMPczMNDset02Tm/giphy.gif", "https://media.giphy.com/media/7ZjmsISzWnreE/giphy.gif");

        $ValidateAttributes["giflink"] = $gifs[rand(0,5)];

        Mail::send('emails.verify', ['user' => $ValidateAttributes], function ($m) use ($ValidateAttributes){
            $m->to($ValidateAttributes["email"])->subject('Verify your email');
        });
        return true;
    }
}
