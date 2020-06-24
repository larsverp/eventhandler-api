<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Tickets;
use App\Events;
use Mail;
use Illuminate\Support\Carbon;

class sendreminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendreminder:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending reminders to all users subscribed to events that start in less than 48 hours';

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
        $gifs = array("https://media.giphy.com/media/9u514UZd57mRhnBCEk/giphy.gif", "https://media.giphy.com/media/26n6xBpxNXExDfuKc/giphy.gif", "https://media.giphy.com/media/QBd2kLB5qDmysEXre9/giphy.gif", "https://media.giphy.com/media/26Do6la9cIiHvIwMM/giphy.gif", "https://media.giphy.com/media/JzOyy8vKMCwvK/giphy.gif", "https://media.giphy.com/media/3o751ZKB91R8ZvMvde/giphy.gif");

            $events = Events::whereDate('begin_date', '=', Carbon::tomorrow()->toDateString())->get();
            foreach($events as $event){
                $tickets = Tickets::where('event_id', $event->id)->get();
                foreach($tickets as $ticket){
                    $user = User::where('id', $ticket->user_id)->first();
                    $gif = $gifs[rand(0,5)];
                    $email = Mail::send('emails.reminder', ['user' => $user, 'event' => $event, 'gif' => $gif], function ($m) use ($user){
                        $m->to($user["email"])->subject('Event reminder');
                    });
                }
            }
    }
}
