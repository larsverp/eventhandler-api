<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tickets;
use App\Events;
use Mail;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketsController extends Controller
{
    public function show(Request $request){
        $tickets = Tickets::where('user_id', $request->user()->id)
            ->where('scanned', false)
            ->pluck('event_id');
        return Events::find($tickets);
    }

    public function create(Request $request){
        $ValidateAttributes = request()->validate([
            'event_id' => ['required', 'uuid', 'exists:events,id', 'unique:tickets,event_id,NULL,id,user_id,'.$request->user()->id]
        ]);
        $ValidateAttributes["user_id"] = $request->user()->id;
        $ValidateAttributes["token"] = Str::random(40);
        
        $ticket = Tickets::FindOrFail(Tickets::create($ValidateAttributes)->id);
        
        $image = \QrCode::format('png')
                         ->merge('images/logo2.png', 0.35, true)
                         ->size(500)->errorCorrection('H')
                         ->generate($request->user()->id.'|'.$ValidateAttributes["token"]);

        $event = Events::find($ValidateAttributes["event_id"]);

        Mail::send('emails.ticket', ['qr' => $image, 'name' => $request->user()->first_name, 'event'=> $event], function ($m) use ($request){
            $m->to($request->user()->email)->subject('Je ticket');
        });

        return response($ticket, 201);
    }        
}
