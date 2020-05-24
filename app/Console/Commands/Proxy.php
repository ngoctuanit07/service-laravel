<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class Proxy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
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
        $proxyCollection = DB::table('proxy')->get();
        foreach ($proxyCollection as $proxy) {
            $proxyUrl = $proxy->url;
            $checkproxy = $this->checkProxy($proxyUrl);
            if ($checkproxy == true) {
                DB::table('proxy')
              ->where('id', $proxy->id)
              ->update(['status' => 1]);
                sleep(60);
            }else{
                  DB::table('proxy')
              ->where('id', $proxy->id)
              ->update(['status' => 0]);
                sleep(60);
            }
        }
    }

    protected function checkProxy($proxy = null)
    {
        $proxy = explode(':', $proxy);
        $host = $proxy[0];
        $port = $proxy[1];
        $waitTimeoutInSeconds = 30;
        if ($fp = @fsockopen($host, $port, $errCode, $errStr, $waitTimeoutInSeconds)) {
            return true;
        } else {
            return false;
        }
        fclose($fp);
    }
}
