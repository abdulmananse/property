<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\Sheet;
use App\Http\Controllers\HomeController;

class ImportProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:properties {sheet_name?}';

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
        ini_set('max_execution_time', 1800);

        $spreadsheetId = $this->spreadsheetId;
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
            }
        }

        return 0;
    }
}
