<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\Sheet;
use App\Http\Controllers\HomeController;
use Carbon\Carbon;

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
        $this->info('Start: ' . $startDateTime->format('d-m-Y h:i A'));

        $sheetName = $this->argument('sheet');

        $homeController = app()->make(HomeController::class);

        $sheet = Sheet::where('name', $sheetName)->first();
        if ($sheet) {
            $this->info($sheet->name . ' Sheet Property Importing');
            $homeController->savePropertyData($sheet);
            $this->info($sheet->name . ' Property Imported');
        } else {
            $sheets = Sheet::get();
            foreach ($sheets as $sheet) {
                $this->info($sheet->name . ' Sheet Property Importing');
                $homeController->savePropertyData($sheet);
                $this->info($sheet->name . ' Property Imported');
                sleep(10);
            }
        }
        $endDateTime = Carbon::now();
        $this->info('End: ' . $endDateTime->format('d-m-Y h:i A'));

        $this->info('TimeTaken' . $startDateTime->diff($endDateTime)->format('%H:%I:%S'));

        return 0;
    }
}
