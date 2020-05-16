<?php

namespace App\Console\Commands;
use App\Services\KeywordsFetcher;
use Illuminate\Console\Command;

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
        $fetcher = new KeywordsFetcher(\Config::get('laravel-google-keywords'));
        $fetcher->fetchAll();

        $this->info("Command executed.");
    }
}
