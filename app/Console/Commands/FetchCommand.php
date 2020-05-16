<?php

namespace App\Console\Commands;
use App\Services\KeywordsFetcher;
use Illuminate\Console\Command;
use DB;
class FetchCommand extends Command {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'keywords:fetch';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Fetch Google Keywords from last day.';

    /**
    * Create a new command instance.
    *
    * @return void
    */

    public function __construct() {
        parent::__construct();
    }

    /**
    * Execute the console command.
    *
    * @return mixed
    */

    public function handle() {
        //
        //require base_path('Services/KeywordsFetcher');
        $datas = DB::table('config_tracking_keyword')->where('status',1)->get();
        foreach($datas as $data){
            //dd($data);
            $params = ['websites' => [
                [
                    'url' =>  $data->url,
                    'credentials' => storage_path( 'app/'.$data->credentials),
                    'user_id' => $data->user_id
                ],
            ]];
            $fetcher = new KeywordsFetcher($params);
            $fetcher->fetchAll();
    
            $this->info("Command executed.");
        }
      
    }
}
