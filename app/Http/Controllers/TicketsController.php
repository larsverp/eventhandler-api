<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tickets;
use App\Events;
use Mail;
use App\Hosts;
use App\Points\Points;
use Carbon\Carbon;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketsController extends Controller
{
    public function show(Request $request){
        return Tickets::where('user_id', $request->user()->id)->get();
    }

    public function create(Request $request){
        $ValidateAttributes = request()->validate([
            'event_id' => ['required', 'uuid', 'exists:events,id', 'unique:tickets,event_id,NULL,id,user_id,'.$request->user()->id]
        ]);
        $ValidateAttributes["user_id"] = $request->user()->id;
        $ValidateAttributes["token"] = Str::random(40);
        
        $ticket = Tickets::FindOrFail(Tickets::create($ValidateAttributes)->id);
        
        $image = \QrCode::format('png')
                         ->merge('images/logo2.png', 0.25, true)
                         ->size(500)->errorCorrection('H')
                         ->generate($request->user()->id.'|'.$ValidateAttributes["token"]);

        $event = Events::FindOrFail($ValidateAttributes["event_id"]);

        $event["begin_date"] = Carbon::parse($event["begin_date"])->format('d-m-Y H:i');
        $event["end_date"] = Carbon::parse($event["end_date"])->format('d-m-Y H:i');

        $pdf = \PDF::loadView('pdfs.pdf', ['qr' => $image, 'name' => $request->user()->first_name, 'event'=> $event, 'host'=> Hosts::where('id', $event->host_id)->first()])->stream();

        Mail::send('emails.ticket', ['qr' => $image,['pdf'=>$pdf], 'name' => $request->user()->first_name, 'event'=> $event], function ($m) use ($request, $event, $pdf){
            $m->to($request->user()->email)->subject('Your ticket for '.$event->title);
            $m->attachData($pdf, 'ticket.pdf');
        });

        //$this->pdf($ValidateAttributes["event_id"].'&'.$ValidateAttributes["user_id"], $event, $image, $request->user()->first_name);

        Points::Hosts('event_subscribe', $event->host_id, $request);

        return response($ticket, 201);
    }
    
    public function remove($id, Request $request){
        $ValidateAttributes = request()->validate([
            'reason' => ['required', 'string', 'max:191']
        ]);
        $ValidateAttributes["unsubscribe"] = true;

        $ticket = Tickets::Where('event_id', $id)
                    ->where('user_id', $request->user()->id)
                    ->FirstOrFail();
        
        $event = Events::FindOrFail($ticket->event_id);
        Points::Hosts('event_unsubscribe', $event->host_id, $request);

        if($ticket->user_id == $request->user()->id){
            if($ticket->update($ValidateAttributes)){
                Mail::send('emails.unsubscribe', ['name' => $request->user()->first_name, 'event'=> $event], function ($m) use ($request, $event){
                    $m->to($request->user()->email)->subject('Unsubscribed for '.$event->title);
                });
                return response()->json([
                    "message" => "Unsubscribed"
                ], 200);
            }
            else{
                return response()->json([
                    "message" => "Failed to update the ticket"
                ], 400);
            }
        }
        else{
            return response()->json([
                "message" => "This user doesn't own this ticket"
            ], 401);
        }
    }

    public function scan(Request $request){
        $ValidateAttributes = request()->validate([
            'event_id' => ['required', 'uuid', 'exists:events,id'],
            'qr_data' => ['required', 'string']
        ]);
        $user_id = explode("|",$ValidateAttributes["qr_data"])[0];
        $qr_token = explode("|",$ValidateAttributes["qr_data"])[1];

        $ticket = Tickets::where('event_id', $ValidateAttributes["event_id"])
            ->where('user_id', $user_id)
            ->where('token', $qr_token)
            ->firstOrFail();

        if($ticket->unsubscribe == false){
            if($ticket->scanned == false){
                $ticket->update(['scanned'=>true]);
            }
            else{
                return response()->json([
                    "message" => "This ticket is already scanned"
                ], 406);
            }
        }
        else{
            return response()->json([
                "message" => "The user unsubscribed from this ticket"
            ], 409);
        }
    }

    public function download($id, Request $request){
        $name = $id.'&'.$request->user()->id.'.pdf';
        return response()->download(storage_path().'/tickets/'.$name, 'Your-ticket.pdf');
    }
}
