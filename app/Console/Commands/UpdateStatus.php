<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class UpdateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cat:updatestatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Config Cat';

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
        //
        DB::table('configcrawcat')
        ->update(['status' => 1]);
    }
}
