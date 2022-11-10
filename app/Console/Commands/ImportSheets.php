<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Revolution\Google\Sheets\Facades\Sheets;
use App\Models\Sheet;
use Carbon\Carbon;

class ImportSheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Google Sheets and save to database';

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


        $startDateTime = Carbon::now();
        $this->info('Start: ' . $startDateTime->format('d-m-Y h:i A'));

        $this->info('Sheet Importing ' . $this->spreadsheetId);
        $spreadsheetId = $this->spreadsheetId;
        $sheets = Sheets::spreadsheet($spreadsheetId)
            ->sheetList();
        foreach ($sheets as $id => $value) {
            $this->info($value . ' Sheet Imported');
            Sheet::updateOrCreate([
                'sheet_id' => $id,
                'name' => $value
            ]);
        }
        $endDateTime = Carbon::now();
        $this->info('End: ' . $endDateTime->format('d-m-Y h:i A'));

        $this->info('TimeTaken' . $startDateTime->diff($endDateTime)->format('%H:%I:%S'));

        return 0;
    }
}
