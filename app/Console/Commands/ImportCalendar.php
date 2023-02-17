<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Property;
use App\Http\Controllers\HomeController;
use App\Models\CronJob;
use App\Models\DuplicateEvent;
use App\Models\Event as EventModel;
use App\Models\Log as ModelsLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        ini_set('max_execution_time', 0);

        //$startDateTime = Carbon::now();
        //Log::error('Import Calendars Started', [$startDateTime->format('d-m-Y h:i A')]);
        //$this->info('Start: ' . $startDateTime->format('d-m-Y h:i A'));

        $propertyId = $this->argument('property_id');

        ModelsLog::where('type', 'calendar')->delete();

        $homeController = app()->make(HomeController::class);

        $property = Property::where('property_id', $propertyId)->first();
        if ($propertyId !== 0 && $property) {
            CronJob::create(['command' => "Starting: import:calendar " . $propertyId]);
            DuplicateEvent::where('property_id', $property->id)->delete();
            //$this->info($property->name . ' Calendar Importing');
            $homeController->getEventsFromIcsFile($property);

            CronJob::create(['command' => "Completed: import:calendar " . $propertyId]);
            //$this->info($property->name . ' Calendar Imported');
        } else {

            $totalDestinations = count(Property::select('destination')->groupBy('destination')->get());
            if ($totalDestinations >= 30) {
                EventModel::truncate();
                DuplicateEvent::truncate();
                $properties = Property::get();
                CronJob::create(['command' => "Starting: import:calendar"]);
                foreach ($properties as $property) {
                    //$this->info($property->name . ' Calendar Importing');
                    $homeController->getEventsFromIcsFile($property);
                }

                DB::statement("INSERT INTO events SELECT * FROM duplicate_events;");
            } else {
                $message = "Total destinations count not correct ignoring calendars import" . " {ErrorMessage}";
                $destinationName = '';
                $pisLink = '';
                $homeController->createDbErrorLog($destinationName, $pisLink, $message, 'calendar');
            }

            CronJob::create(['command' => "Completed: import:calendar"]);
        }
        //$endDateTime = Carbon::now();
        //$this->info('End: ' . $endDateTime->format('d-m-Y h:i A'));

        //$this->info('Time Taken: ' . $startDateTime->diff($endDateTime)->format('%H:%I:%S'));

        return 0;
    }
}