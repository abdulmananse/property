<?php

namespace App\Console\Commands;

use App\Models\Event as EventModel;
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
        ini_set('max_execution_time', 0);

        $totalProperties = Property::whereNotNull('destination')->groupBy('destination')->count();
        $totalEvents = EventModel::groupBy('property_id')->count();
        if($totalProperties < 100){
            $this->call('import:sheets');
            $this->call('import:properties');
        }
        if($totalEvents < 40){
            $this->call('import:calendar');
        }
        return 0;
    }
}
