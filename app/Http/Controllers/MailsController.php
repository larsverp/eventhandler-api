<?php

namespace App\Http\Controllers;

use App\Mails;
use App\User;
use Mail;
use Illuminate\Http\Request;

class MailsController extends Controller
{
    public function index(){
        return Mails::all();
    }

    public function show($id){
        return Mails::FindOrFail($id);
    }

    public function create(){
        $ValidateAttributes = request()->validate([
            'title' => 'required|max:191|string|unique:mails,title',
            'language' => 'required|max:191|string',
            'subject' => 'required|max:191|string',
            'body' => 'required|max:16500000|string',
        ]);
        
        $mail = Mails::FindOrFail(Mails::create($ValidateAttributes)->id);
        return response($mail, 201);
    }

    public function update($id){
        $mail = Mails::FindOrFail($id);

        $ValidateAttributes = request()->validate([
            'title' => 'max:191|string|unique:mails,title',
            'language' => 'max:191|string|',
            'subject' => 'max:191|string',
            'body' => 'max:16500000|string',
        ]);

        if($mail->update($ValidateAttributes)){
            return $mail;
        }
        else{
            return response($mail->id, 400);
        }
    }

    public function remove($id){
        $mail = Mails::FindOrFail($id);
        $mail->delete();
        return response($mail, 200);
    }

    public function verify(){
        $ValidateAttributes = request()->validate([
            'email' => 'required|max:191|email:rfc,dns'
        ]);

        $user = User::where('email', $ValidateAttributes["email"])->firstOrFail();
        
        if($user->email_verified_at != null){
            return response()->json([
                'message'=>'The email is already validated'
            ], 409);
        }

        $ValidateAttributes["name"] = $user->first_name;
        $ValidateAttributes["verify_code"] = $user->auth_code;
        
        $gifs = array("https://media.giphy.com/media/TdfyKrN7HGTIY/giphy.gif", "https://media.giphy.com/media/b5LTssxCLpvVe/giphy.gif", "https://media.giphy.com/media/3og0ICmyySyzbmnxqE/giphy.gif", "https://media.giphy.com/media/xT5LMHxhOfscxPfIfm/giphy.gif", "https://media.giphy.com/media/xT5LMPczMNDset02Tm/giphy.gif", "https://media.giphy.com/media/7ZjmsISzWnreE/giphy.gif");

        $ValidateAttributes["giflink"] = $gifs[rand(0,5)];

        $email = Mail::send('emails.verify', ['user' => $ValidateAttributes], function ($m) use ($ValidateAttributes){
            $m->to($ValidateAttributes["email"])->subject('Je verificatie code');
        });
        return response($email, 201);
    }
}
