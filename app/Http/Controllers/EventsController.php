<?php

namespace App\Http\Controllers;

use App\Events;
use App\Tickets;
use App\CatEve;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EventsController extends Controller
{
    public function index(Request $request){
        if($request->user()->role == "rockstar" || $request->user()->role == "admin"){
            $events = Events::all();
            foreach($events as $event){
                $event["available_seats"] = $this->seats($event);
                $event["begin_date"] = Carbon::parse($event["begin_date"])->format('d-m-Y H:i');
                $event["end_date"] = Carbon::parse($event["end_date"])->format('d-m-Y H:i');
            }
            return $events;
        }
        else{
            $events = Events::where('rockstar', false)->get();
            foreach($events as $event){
                $event["available_seats"] = $this->seats($event);
                $event["begin_date"] = Carbon::parse($event["begin_date"])->format('d-m-Y H:i');
                $event["end_date"] = Carbon::parse($event["end_date"])->format('d-m-Y H:i');
            }
            return $events;
        }
    }

    public function preview(){
        $events = Events::where('rockstar', false)->get();
        foreach($events as $event){
            $event["available_seats"] = $this->seats($event);
            $event["begin_date"] = Carbon::parse($event["begin_date"])->format('d-m-Y H:i');
            $event["end_date"] = Carbon::parse($event["end_date"])->format('d-m-Y H:i');
        }
        return $events;
    }

    public function show($id){
        $event = Events::FindOrFail($id);
        $event["available_seats"] = $this->seats($event);
        $event["begin_date"] = Carbon::parse($event["begin_date"])->format('d-m-Y H:i');
        $event["end_date"] = Carbon::parse($event["end_date"])->format('d-m-Y H:i');
        return $event;

    }

    public function create(){
        $ValidateAttributes = request()->validate([
            'title' => 'required|max:191|string',
            'description' => 'required|string',
            'host_id' => 'uuid|exists:hosts,id',
            'begin_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:begin_date',
            'thumbnail' => 'required|max:1000|active_url',
            'seats' => 'required|integer|min:0',
            'postal_code' => 'required|postal_code:NL,BE,DE',
            'hnum' => 'required|max:191|string',
            'categories' => 'required|array',
            'notification' => 'required|boolean',
            'rockstar' => 'required|boolean'
        ]);
        
        $response = Http::withHeaders([
            'token' => '998911cc-e815-41b3-9c33-20369fd6e5c3',
        ])->get('http://json.api-postcode.nl?postcode='.$ValidateAttributes['postal_code']);
        $ValidateAttributes['city'] = $response['city'];
        $ValidateAttributes['street'] = $response['street'];
        $ValidateAttributes["begin_date"] = Carbon::parse($ValidateAttributes["begin_date"])->format('Y-m-d H:i:s');
        $ValidateAttributes["end_date"] = Carbon::parse($ValidateAttributes["end_date"])->format('Y-m-d H:i:s');

        $event = Events::FindOrFail(Events::create($ValidateAttributes)->id);
        foreach($ValidateAttributes["categories"] as $category){
            CatEve::create(['event_id' => $event->id, 'category_id' => $category]);
        }

        $event["begin_date"] = Carbon::parse($event["begin_date"])->format('d-m-Y H:i');
        $event["end_date"] = Carbon::parse($event["end_date"])->format('d-m-Y H:i');
        return response($event, 201);
    }

    public function update($id){
        $event = Events::FindOrFail($id);
        $ValidateAttributes = request()->validate([
            'title' => 'max:191|string',
            'description' => 'string',
            'host_id' => 'string|max:191|exists:hosts,id',
            'begin_date' => 'date|after_or_equal:today',
            'end_date' => 'date|after_or_equal:begin_date',
            'thumbnail' => 'max:1000|active_url',
            'seats' => 'integer|min:0',
            'postal_code' => 'postal_code:NL,BE,DE',
            'hnum' => 'max:191|string',
            'categories' => 'array',
            'notification' => 'boolean',
            'rockstar' => 'boolean'
        ]);
        
        if(isset($ValidateAttributes["categories"])){
            $previous = CatEve::where('event_id', $event->id)->get();
            foreach($previous as $data){
                $data->delete();
            }
            foreach($ValidateAttributes["categories"] as $category){
                CatEve::create(['event_id' => $event->id, 'category_id' => $category]);
            }
        }

        if(isset($ValidateAttributes["postal_code"])){
            $response = Http::withHeaders([
                'token' => '998911cc-e815-41b3-9c33-20369fd6e5c3',
            ])->get('http://json.api-postcode.nl?postcode='.$ValidateAttributes['postal_code']);
            $ValidateAttributes['city'] = $response['city'];
            $ValidateAttributes['street'] = $response['street'];
        }

        if(isset($ValidateAttributes["begin_date"])){
            $ValidateAttributes["begin_date"] = Carbon::parse($ValidateAttributes["begin_date"])->format('Y-m-d H:i:s');
        }

        if(isset($ValidateAttributes["end_date"])){
            $ValidateAttributes["end_date"] = Carbon::parse($ValidateAttributes["end_date"])->format('Y-m-d H:i:s');
        }

        if($event->update($ValidateAttributes)){
            $event["available_seats"] = $this->seats($event);
            $event["begin_date"] = Carbon::parse($event["begin_date"])->format('d-m-Y H:i');
            $event["end_date"] = Carbon::parse($event["end_date"])->format('d-m-Y H:i');
            return $event;
            
        }
        else{
            return response($event->id, 400);
        }
    }

    public function remove($id){
        $event = Events::FindOrFail($id);
        $event->delete();
        $event["begin_date"] = Carbon::parse($event["begin_date"])->format('Y-m-d H:i:s');
        $event["end_date"] = Carbon::parse($event["end_date"])->format('Y-m-d H:i:s');
        return response($event, 200);
    }

    private function seats($event){
       return $event->seats - count(Tickets::where('event_id', $event->id)
                                        ->where('unsubscribe', false)
                                        ->pluck('event_id'));
    }
}