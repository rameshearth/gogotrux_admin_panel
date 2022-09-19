<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\GetMapAccessToken;
use DB;

class GetMapAcessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getMapAccessToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
         Log::info('this is demo console');
        try {
    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', 'https://outpost.mapmyindia.com/api/security/oauth/token', [
        'form_params' => [
            'grant_type' => 'client_credentials',
            'client_id'=> '33OkryzDZsIv-0ItH_Z5UNahPSK5lioJCcwS1EHG-N4jV0GYSfP9wkajZyi5OJZpLFzje3em2cezmTCxtRv3qfdvSbWCnWWj',     
            'client_secret'=> 'lrFxI-iSEg-dckVUCl7Jqh8tq0OZYdD8hLwIjQQQj3vhUGYRlRFuAif5b3eGhCFYJNTGVxpZnE9ymr2_E4VaKrHRoylQF0e8LPWhmE_MR8M='
        ]
    ]);
    GetMapAccessToken::where('status',1)->update(['status'=> 0]);
    $response = $response->getBody()->getContents();
    $responseData = json_decode($response, true);
        DB::beginTransaction();
        $mapresponse = new GetMapAccessToken;
        $mapresponse->access_token = $responseData['access_token'];
        $mapresponse->token_type = $responseData['token_type'];
        $mapresponse->expires_in = $responseData['expires_in'];
        $mapresponse->project_code = $responseData['project_code'];
        $mapresponse->client_id = $responseData['client_id'];
        $mapresponse->status = 1;
        if($mapresponse->save()){
                DB::commit();
                Log::info('Successfull');
                return $responseData;
            }else{
                DB::rollback();
                $status = false;
                Log::info('Failed');
                return $status;
            }
    } catch (\Exception $e) {
        
        DB::rollback();
    }
    }
}
