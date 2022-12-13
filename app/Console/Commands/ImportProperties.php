<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sheet;
use App\Models\Property;
use App\Http\Controllers\HomeController;
use Carbon\Carbon;
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

        $startDateTime = Carbon::now();
	    Log::error('Import Properties Started', [$startDateTime->format('d-m-Y h:i A')]);
        $this->info('Start: ' . $startDateTime->format('d-m-Y h:i A'));

        $sheetName = $this->argument('sheet');

        $homeController = app()->make(HomeController::class);

        Property::truncate();

        $sheet = Sheet::where('name', $sheetName)->first();
        if ($sheet) {
            $this->info($sheet->name . ' Sheet Property Importing');
            $homeController->savePropertyData($sheet);
        } else {
            $sheets = Sheet::get();
            foreach ($sheets as $sheet) {
                $this->info($sheet->name . ' Sheet Property Importing');
                $homeController->savePropertyData($sheet);
            }
        }
        $endDateTime = Carbon::now();
        $this->info('End: ' . $endDateTime->format('d-m-Y h:i A'));

        $this->info('Time Taken: ' . $startDateTime->diff($endDateTime)->format('%H:%I:%S'));

        return 0;
    }
}
