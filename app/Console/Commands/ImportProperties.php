<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sheet;
use App\Models\Property;
use App\Http\Controllers\HomeController;
use App\Models\CronJob;
use App\Models\DuplicateProperty;
use App\Models\DuplicatePropertyPrice;
use App\Models\Log as ModelsLog;
use App\Models\PropertyPrice;
// use App\Models\PropertyPrice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:properties {sheet?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import properties from google sheets and save to database';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $spreadsheetId;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->spreadsheetId = config('sheets.post_spreadsheet_id');
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
        //Log::error('Import Properties Started', [$startDateTime->format('d-m-Y h:i A')]);
        //$this->info('Start: ' . $startDateTime->format('d-m-Y h:i A'));

        $sheetName = $this->argument('sheet');

        ModelsLog::where('type', 'property')->delete();

        $homeController = app()->make(HomeController::class);

        $sheet = Sheet::where('name', $sheetName)->first();
        if ($sheet) {
            DuplicateProperty::where('sheet_id', $sheet->id)->delete();
            CronJob::create(['command' => "Starting: import:properties " . $sheetName]);
            //$this->info($sheet->name . ' Sheet Property Importing');
            $homeController->savePropertyData($sheet);
            Property::where('sheet_id', $sheet->id)->delete();
            DuplicateProperty::query()
                ->where('sheet_id', $sheet->id)
                ->each(function ($oldRecord) {
                    $newRecord = $oldRecord->replicate();
                    $newRecord->setTable('property');
                    $newRecord->save();

                    DuplicatePropertyPrice::query()
                        ->where('property_id', $oldRecord->property_id)
                        ->each(
                            function ($oldPricing) {
                                    $newRecord = $oldPricing->replicate();
                                    $newRecord->setTable('property_pricing');
                                    $newRecord->save();
                                    $oldPricing->delete();
                                }
                        );

                    $oldRecord->delete();
                });
            CronJob::create(['command' => "Completed: import:properties " . $sheetName]);
        } else {
            DuplicateProperty::truncate();
            DuplicatePropertyPrice::truncate();
            $sheets = Sheet::get();
            CronJob::create(['command' => "Starting: import:properties"]);
            foreach ($sheets as $sheet) {
                //$this->info($sheet->name . ' Sheet Property Importing');
                $homeController->savePropertyData($sheet);
            }
            CronJob::create(['command' => "Completed: import:properties"]);

            Property::truncate();
            PropertyPrice::truncate();
            $totalDestinations = count(DuplicateProperty::select('destination')->groupBy('destination')->get());
            if (($totalDestinations) >= 30) {
                DB::statement("INSERT INTO properties SELECT * FROM duplicate_properties;");
                DB::statement("INSERT INTO property_pricing SELECT * FROM duplicate_property_pricing;");
            } else {
                $message = "Unable to read all destinations. Parsed {TotalDestinations} $totalDestinations" . ' {ErrorMessage}';
                $destinationName = '';
                $pisLink = '';
                $homeController->createDbErrorLog($destinationName, $pisLink, $message);
            }
        }

        //$endDateTime = Carbon::now();
        //$this->info('End: ' . $endDateTime->format('d-m-Y h:i A'));

        //$this->info('Time Taken: ' . $startDateTime->diff($endDateTime)->format('%H:%I:%S'));

        return 0;
    }
}