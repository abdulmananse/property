<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Property;
use App\Http\Controllers\HomeController;

class ImportCalendar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:calendar {property_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import calendar from ICS file';

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
        ini_set('max_execution_time', 1800);

        $propertyId = $this->argument('property_id');
        $homeController = app()->make(HomeController::class);

        $property = Property::where('property_id', $propertyId)->first();
        if ($propertyId != 0 && $property) {
            $this->info($property->name . ' Calendar Importing');
            $homeController->getEventsFromIcsFile($property);
            $this->info($property->name . ' Calendar Imported');
        } else {
            $properties = Property::get();
            foreach($properties as $property) {
                $this->info($property->name . ' Calendar Importing');
                $homeController->getEventsFromIcsFile($property);
                $this->info($property->name . ' Calendar Imported');
            }
        }

        return 0;
    }
}
