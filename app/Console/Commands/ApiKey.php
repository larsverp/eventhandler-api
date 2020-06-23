<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ApiKey:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an API key for authenticating the users/login endpoint.';

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
        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => env('CLIENT2_ID', '2'),
            'client_secret' => env('CLIENT2_SECRET', 'rsK7oslkgMDZGVsiqXmDgh6ENN6i9AThE5TmrTol'),
        ];

        $request = app('request')->create('/oauth/token', 'POST', $data);
        $response = app('router')->prepareResponse($request, app()->handle($request));

        $this->info($response);
    }
}
