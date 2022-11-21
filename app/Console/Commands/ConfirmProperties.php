<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;

class ConfirmProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:confirm-properties';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command confirms properties import data';

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
     * @return int
     */
    public function handle()
    {
        $totalProperties = Property::whereNotNull('destination')->groupBy('destination')->count();
        if($$totalProperties < 25){
            $this->call('import:sheets');
            $this->call('import:properties');
            $this->call('import:calendar');
        }
        return 0;
    }
}
