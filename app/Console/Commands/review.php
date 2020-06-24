<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Tickets;
use App\Events;
use Mail;
use Illuminate\Support\Carbon;

class review extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'review:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the review emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events = Events::whereDate('end_date', '=', Carbon::yesterday()->toDateString())->get();
        foreach($events as $event){
            $tickets = Tickets::where('event_id', $event->id)
                                ->where('scanned', true)
                                ->get();
            foreach($tickets as $ticket){
                $user = User::where('id', $ticket->user_id)->first();
                $email = Mail::send('emails.review', ['user' => $user, 'event' => $event], function ($m) use ($user){
                    $m->to($user["email"])->subject('How did we do?');
                });
            }
        }
    }
}
