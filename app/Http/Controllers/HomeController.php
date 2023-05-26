<?php

namespace App\Http\Controllers;

use App\Models\DuplicateEvent;
use App\Models\DuplicateProperty;
use App\Models\DuplicatePropertyPrice;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use Revolution\Google\Sheets\Facades\Sheets;

use Carbon\Carbon;

use ICal\ICal;

use App\Models\Sheet;
use App\Models\Property;
use App\Models\Event as EventModel;
use App\Models\Log as ModelsLog;
use App\Models\PropertyPrice;

use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $spreadsheetId;
    public $salesPersons;
    public $readProperty;
    public $readPropertySheet;
    public $readIndex;


    public function __construct()
    {
        $this->spreadsheetId = config('sheets.post_spreadsheet_id');

        $this->salesPersons = json_decode('{"id":"f800b11f-b48b-42df-bb10-5a0b85e322fb","name":"Requestee","type":"drop_down","type_config":{"default":0,"placeholder":null,"new_drop_down":true,"options":[{"id":"54e3071e-b89d-4da6-896b-8c6d904e4f55","name":"Miguel","value":"Miguel","type":"text","color":"#81B1FF","orderindex":0,"workspace_id":null},{"id":"a8711b82-e426-430c-a9f5-0e95250b5dd3","name":"Lisa ","value":"Lisa ","type":"text","color":"#81B1FF","orderindex":1,"workspace_id":null},{"id":"70faa27b-25e0-47e9-8839-318827d397de","name":"Deb","value":"Deb","type":"text","color":"#81B1FF","orderindex":2,"workspace_id":null},{"id":"9694edf1-142d-45b1-b79d-7e9b9cc17175","name":"Julia","value":"Julia","type":"text","color":"#81B1FF","orderindex":3,"workspace_id":null},{"id":"71c358d1-f602-474e-90c9-b79243dfa88d","name":"Luiz","value":"Luiz","type":"text","color":"#81B1FF","orderindex":4,"workspace_id":null},{"id":"00d24ba5-99c8-4530-88ae-5ea94c4fac59","name":"Jo","value":"Jo","type":"text","color":"#81B1FF","orderindex":5,"workspace_id":null},{"id":"b77a9a35-b723-494d-aa9b-ab39843902eb","name":"Joana","value":"Joana","type":"text","color":"#81B1FF","orderindex":6,"workspace_id":null},{"id":"4ef9ea16-da80-4fae-a418-5fe4fae5690a","name":"Ali","value":"Ali","type":"text","color":"#81B1FF","orderindex":7,"workspace_id":null},{"id":"8fc565e1-2819-4b93-b2a5-f00217a95e3c","name":"Sonia","value":"Sonia","type":"text","color":"#81B1FF","orderindex":8,"workspace_id":null},{"id":"5d937092-1fd5-4015-8b5c-316b5198d91b","name":"Lucia","value":"Lucia","type":"text","color":"#81B1FF","orderindex":9,"workspace_id":null},{"id":"d9abbc6b-252b-4f22-a4c8-a313a8194a20","name":"Susana","value":"Susana","type":"text","color":"#81B1FF","orderindex":16,"workspace_id":null},{"id":"27532980-1f79-40fd-b9c0-17fedc3446d8","name":"Melanie","value":"Melanie","type":"text","color":"#81B1FF","orderindex":11,"workspace_id":null},{"id":"2ae60d9d-3c2a-4fb5-87f9-62a293dc054e","name":"Roberto","value":"Roberto","type":"text","color":"#81B1FF","orderindex":12,"workspace_id":null},{"id":"37ec2459-72df-470d-9100-2ecbd0e87b23","name":"Lidia","value":"Lidia","type":"text","color":"#81B1FF","orderindex":13,"workspace_id":null},{"id":"ba0cabd9-d021-49dc-8325-48e4e6c4b4b1","name":"Valerie","value":"Valerie","type":"text","color":"#81B1FF","orderindex":14,"workspace_id":null},{"id":"f192e197-d300-4edf-aadf-712a22524337","name":"Margarida","value":"Margarida","type":"text","color":"#81B1FF","orderindex":15,"workspace_id":null},{"id":"d9abbc6b-252b-4f22-a4c8-a313a8194a20","name":"Angelica","value":"Angelica","type":"text","color":"#81B1FF","orderindex":16,"workspace_id":null},{"id":"c0fc6229-2fc6-4e09-a86f-ea8e9636eda9","name":"Berenice","value":"Berenice","type":"text","color":"#81B1FF","orderindex":17,"workspace_id":null},{"id":"c7fce691-bdf6-4bbf-88a6-cda7bdc56f1b","name":"Rita","value":"Rita","type":"text","color":"#81B1FF","orderindex":18,"workspace_id":"4656098"},{"id":"53630545-9351-41c0-9701-37c3cc40a7a8","name":"Danielle","value":"Danielle","type":"text","color":"#81B1FF","orderindex":19,"workspace_id":"4656098"},{"id":"f1c6daa9-6457-4fb1-ac85-190768811e9b","name":"Other","value":"Other","type":"text","color":"#81B1FF","orderindex":20,"workspace_id":null},{"id":"ff7872b0-b778-43ba-8d8e-be3094113f2e","name":"Channels","value":"Channels","type":"text","color":"#667684","orderindex":21,"workspace_id":null},{"id":"bc981c3a-0721-4a12-ab7b-2d001f55dd24","name":"Pipedrive","value":"Pipedrive","type":"text","color":"#667684","orderindex":22,"workspace_id":"4656098"},{"id":"4cf6bd42-fac1-4a29-8dad-155667cd8a35","name":"Sales Platform","value":"Sales Platform","type":"text","color":"#667684","orderindex":23,"workspace_id":"4656098"}]}}');

        $this->readProperty = '';
        $this->readPropertySheet = '';
        $this->readIndex = '';
    }

    public function searchProperties(Request $request)
    {
        $searchString = $request->searchString;
        if ($searchString) {
            $where = ' WHERE 1 AND properties.ical_link IS NOT NULL AND (properties.name LIKE "%' . $searchString . '%" OR properties.property_id LIKE "%' . $searchString . '%")';
            $orderBy = 'properties.name ASC';
            $query = 'SELECT
                    properties.clickup_id,
                    properties.name,
                    properties.property_id
                FROM properties
                LEFT JOIN `events` ON events.property_id = properties.id
                ' . $where . '
                GROUP BY
                    properties.id,properties.property_id
                ORDER BY ' . $orderBy . '
                LIMIT 10 ';

            $properties = DB::select(DB::raw($query));

            $searchElements = '';
            foreach ($properties as $property) {
                $searchElements .= '<div class="search-element w-100 d-flex">
                <div class="title-element w-75 text-left">
                    <h2>' . $property->name . ' </h2>
                    <p>' . $property->property_id . '</p>
                    </div>
                    <div class="btnClick">
                        <a class="' . ($property->clickup_id ? 'active' : 'disabled') . '" href="' . ($property->clickup_id ? $property->clickup_id : 'javascript:void(0)') . '" target="_blank">ClickUp</a>
                        </div>
                    </div>';
            }
            return $searchElements;
        } else {
            return '';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $salesPersons = $this->salesPersons;

        $salesPersonsList = [];
        if (isset($salesPersons->type_config->options)) {
            $salesPersonsList = $salesPersons->type_config->options;
        }

        $properties = [];
        $startDate = $endDate = '';
        if ($request->filled('daterange')) {

            $where = ' WHERE 1 AND properties.ical_link IS NOT NULL ';
            if ($request->filled('city')) {
                $destination = $request->city;
                $where .= ' AND destination LIKE "%' . $destination . '%" ';
            }
            if ($request->filled('bedrooms')) {
                $bedrooms = (int) $request->bedrooms;
                $where .= ' AND no_of_bedrooms = ' . $bedrooms . ' ';
            }
            $orderBy = 'properties.name ASC';
            $sortBy = $request->sort_by;
            if ($sortBy) {
                switch ($sortBy) {
                    case 'Property Name A to Z':
                        $orderBy = 'properties.name ASC';
                        break;
                    case 'No. of Bedrooms':
                        $orderBy = 'CAST(properties.no_of_bedrooms AS UNSIGNED) ASC';
                        break;
                    case 'Property Type':
                        $orderBy = 'properties.property_type ASC';
                        break;
                    case 'Community Ascending':
                        $orderBy = 'properties.community ASC';
                        break;
                }
            }

            list($startDate, $endDate) = explode(' - ', $request->daterange);
            $iterateStartDate = $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');

            $rangeDatesArray = [];
            while (strtotime($iterateStartDate) <= strtotime($endDate)) {
                $rangeDatesArray[date('Ymd', strtotime($iterateStartDate))] = $iterateStartDate;
                $iterateStartDate = date('Y-m-d', strtotime("+1 day", strtotime($iterateStartDate)));
            }

            $page = ($request->filled('page')) ? (int) $request->page : 1;
            $paginate = 200;

            $query = 'SELECT
                    properties.id,
                    properties.clickup_id,
                    properties.name,
                    properties.property_id,
                    properties.account,
                    properties.currency,
                    properties.currency_symbol,
                    properties.community,
                    properties.country,
                    properties.destination,
                    properties.city,
                    properties.property_type,
                    properties.max_guests,
                    properties.no_of_beds,
                    properties.no_of_bathrooms,
                    properties.no_of_bedrooms,
                    SUM(IF((CAST("' . $startDate . '" AS DATE) BETWEEN DATE(events.start) and DATE_SUB(DATE(events.end), INTERVAL 1 DAY)) OR (CAST("' . $endDate . '" AS DATE) BETWEEN DATE(events.start) and DATE_SUB(DATE(events.end), INTERVAL 1 DAY)) OR (DATE(events.start) > CAST("' . $startDate . '" AS DATE) AND DATE_SUB(DATE(events.end), INTERVAL 1 DAY) < CAST("' . $endDate . '" AS DATE)), 1, 0)) as total_bookings
                FROM properties
                LEFT JOIN `events` ON events.property_id = properties.id
                ' . $where . '
                GROUP BY
                    properties.id,properties.property_id
                HAVING total_bookings = 0
                ORDER BY ' . $orderBy;

            $properties = DB::select(DB::raw($query));


            foreach ($properties as $key => $property) {
                $totalPrice = 0;
                foreach ($rangeDatesArray as $date) {
                    $prices = PropertyPrice::where(['property_id' => $property->id])->whereDate('from', '<=', $date)->whereDate('to', '>=', $date)->first();
                    if ($prices) {
                        $totalPrice += $prices->per_night_price;
                        $properties[$key]->prices[$date] = $prices->per_night_price;
                    } else {
                        $properties[$key]->prices[$date] = 0.00;
                    }
                }
                $properties[$key]->total_price = $totalPrice;
                $properties[$key]->average = $totalPrice / count($rangeDatesArray);
            }

            $offset = ($page * $paginate) - $paginate;

            if ($sortBy && $sortBy == 'Price Low to High') {
                $properties = collect($properties)->sortBy('average')->toArray();
            }

            $itemstoshow = array_slice($properties, $offset, $paginate);
            $properties = new LengthAwarePaginator($itemstoshow, count($properties), $paginate, $page, ['path' => $request->url()]);

        }

        $cities = Property::whereNotNull('destination')->groupBy('destination')->pluck('destination');
        $maxBedrooms = Property::select(DB::raw('MAX(CAST(properties.no_of_bedrooms AS UNSIGNED)) as no_of_bedrooms'))->first()->no_of_bedrooms;

        return view('properties', compact('cities', 'properties', 'maxBedrooms', 'salesPersonsList', 'endDate', 'startDate'));
    }

    public function errorLogs(Request $request)
    {

        $errorLogs = ModelsLog::all();

        return view('error_logs', compact('errorLogs'));
    }

    public function paginate($items, $perpage)
    {
        $total = count($items);
        $currentpage = \Request::get('page', 1);
        $offset = ($currentpage * $perpage) - $perpage;
        $itemstoshow = array_slice($items, $offset, $perpage);
        $p = new LengthAwarePaginator($itemstoshow, $total, $perpage);
        $p->setPath(\Request::url());

        return $p;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $property = Property::with('sheet', 'events');

        return view('property-detail', compact('property'));
    }

    public function createDbErrorLog($destinationName = '', $pisLink = '', $message = '', $type = 'property', $errorType = 'error', $erroCategory = 'Data Team')
    {
        ModelsLog::create([
            'message' => $message,
            'destination_name' => $destinationName,
            'pis_link' => $pisLink,
            'type' => $type,
            'error_type' => $errorType,
            'error_category' => $erroCategory
        ]);
    }

    /**
     * Import Sheets
     *
     * @return \Illuminate\Http\Response
     */
    public function importSheets()
    {
        try {
            $spreadsheetId = $this->spreadsheetId;
            $sheets = Sheets::spreadsheet($spreadsheetId)
                ->sheetList();
            foreach ($sheets as $id => $value) {
                Sheet::updateOrCreate([
                    'sheet_id' => $id,
                    'name' => $value
                ]);
            }
        } catch (\Exception $e) {
            $error = $this->parseException($e);
            $message = "Unable to read sheets using spreadsheet ID $spreadsheetId. {ErrorMessage} $error";
            $destinationName = '';
            $pisLink = '';
            $this->createDbErrorLog($destinationName, $pisLink, $message, 'property', 'error', 'Tech Team');
        }

        //exit('Sheets Imported');
    }

    /**
     * Import Properties
     *
     * @return \Illuminate\Http\Response
     */
    public function importProperties($sheetId = '')
    {
        ini_set('max_execution_time', 0);

        $sheet = Sheet::where('name', $sheetId)->first();
        if ($sheet) {
            $this->savePropertyData($sheet);
            //dd('Property Imported');
        } else {
            $sheets = Sheet::get();
            foreach ($sheets as $sheet) {
                $this->savePropertyData($sheet);
            }
        }

        //dd('Properties Imported');
    }

    /**
     * Import Calander
     *
     * @return \Illuminate\Http\Response
     */
    public function importCalander($propertyId = 0)
    {
        ini_set('max_execution_time', 0);

        try {
            $property = Property::where('property_id', $propertyId)->first();
            if ($propertyId != 0 && $property) {
                $this->getEventsFromIcsFile($property);
                //dd('Calander Imported');
            } else {
                $properties = Property::get();
                foreach ($properties as $property) {
                    $this->getEventsFromIcsFile($property);
                }
            }
        } catch (\Exception $e) {
            $error = $this->parseException($e);
            $message = "Unable to read calendars using property ID $propertyId. {ErrorMessage} $error";
            $destinationName = '';
            $pisLink = '';
            $this->createDbErrorLog($destinationName, $pisLink, $message, 'calendar', 'error', 'Data/Tech Team');
        }


        //dd('Calanders Imported');
    }

    private function propertyImport($sheet, $properties, $skipProperties = [])
    {
        try {
            foreach ($properties as $key => $property) {
                $pisSheetId = $this->getPisId($property);
                $this->readProperty = $property;
                if (isset($property['Property ID'])) {

                    $propertyId = str_replace(" ", "", $property['Property ID']);
                    if ($propertyId != '') {

                        $where = [
                            'sheet_id' => $sheet->id,
                            'property_id' => $propertyId
                        ];
                        $propertyInformation = $this->getPropertyInformation($sheet->name, $pisSheetId);
                        if ($propertyInformation) {

                            if (!isset($property['Clickup ID']) || !$property['Clickup ID']) {
                                $message = "Unable to get ClickUp ID. " . ' {ErrorMessage}';
                                $destinationName = $sheet->name;
                                $pisLink = $pisSheetId;
                                $property['Clickup ID'] = null;
                                $this->createDbErrorLog($destinationName, $pisLink, $message, 'property', 'error', 'Data Team');
                            }

                            $propertyData = [
                                'clickup_id' => @$property['Clickup ID'], //'Clickup ID'
                                'name' => @$property['Property Name'],
                                'account' => @$property['Account'],
                                'pis' => @$property['PIS'],
                                'pis_sheet_id' => $pisSheetId,
                                'calendar_fallback' => @$property['Calendar Fallback'],
                                'comments' => @$property['Comments'],
                                'slide_link' => @$property['Slide Link'],
                                'pdf_link' => @$property['pdfLink'],
                                'price_doc_link' => @$property['Price Doc Link'],
                                'price_pdf_link' => @$property['Price PDF Link'],
                                'property_pdf_notes' => @$property['PropertyPDF Notes'],
                            ];

                            //Log::Error('PropertyData', $propertyData);

                            $propertyPrices = $propertyInformation['pricing'];
                            unset($propertyInformation['pricing']);

                            $propertyCompleteData = array_merge($propertyData, $propertyInformation);

                            $propertyCompleteData['destination'] = isset($propertyCompleteData['destination']) ? str_replace('  ', ' ', $propertyCompleteData['destination']) : '';

                            $propertyCompleteData['currency_symbol'] = '&dollar;';
                            switch ($propertyCompleteData['currency']) {
                                case 'EUR':
                                    $propertyCompleteData['currency_symbol'] = '&euro;';
                                    break;
                                case 'GBP':
                                    $propertyCompleteData['currency_symbol'] = '&pound;';
                                    break;
                            }

                            DuplicateProperty::updateOrCreate($where, $propertyCompleteData);

                            $propertyInfo = DuplicateProperty::where($where)->first();
                            DuplicatePropertyPrice::where('property_id', $propertyInfo->id)->delete();
                            foreach ($propertyPrices as $priceArray) {
                                if ($priceArray['from'] || $priceArray['to']) {
                                    DuplicatePropertyPrice::create([
                                        'property_id' => $propertyInfo->id,
                                        'from' => $priceArray['from'],
                                        'to' => $priceArray['to'],
                                        'per_night_price' => isset($priceArray['per_night_price']) ? $priceArray['per_night_price'] : 0
                                    ]);
                                }
                            }
                        } else {
                            $message = "Unable to get property information. Skipping parsing. " . ' {ErrorMessage}';
                            $destinationName = $sheet->name;
                            $pisLink = $pisSheetId;
                            $this->createDbErrorLog($destinationName, $pisLink, $message, 'property', 'error', 'Data/Tech Team');
                        }
                    }
                } else {
                    $message = "Property ID index not found. Skipping parsing." . ' {ErrorMessage}';
                    $destinationName = $sheet->name;
                    $pisLink = $pisSheetId;
                    $this->createDbErrorLog($destinationName, $pisLink, $message, 'property', 'error', 'Data Team');
                }
            }
        } catch (\Exception $e) {
            $pisSheetId = $this->getPisId($this->readProperty);
            $error = $this->parseException($e);
            $message = "Unable to read properties using sheet $sheet. {ErrorMessage} $error";
            $destinationName = $sheet->name;
            $pisLink = $pisSheetId;
            $this->createDbErrorLog($destinationName, $pisLink, $message, 'property', 'error', 'Data/Tech Team');

            $skipProperties[] = $this->readProperty['Property ID'];
            $this->propertyImport($sheet, $properties, $skipProperties);
        }
    }

    /**
     * Save Property Data
     *
     * @param $sheet
     * @return \Illuminate\Http\Response
     */
    public function savePropertyData($sheet)
    {

        try {
            $sheetId = $sheet->name;
            $spreadsheetId = $this->spreadsheetId;
            $sheetData = Sheets::spreadsheet($spreadsheetId)
                ->sheet($sheetId)
                ->get();

            $header = $sheetData->pull(0);
            $properties = Sheets::collection($header, $sheetData);
            $this->propertyImport($sheet, $properties);

        } catch (\Exception $exception) {
            try {
                $sheetIdLastCharacterIndex = strlen($sheetId) - 1;
                $sheetId = ($sheetId[$sheetIdLastCharacterIndex] === '*') ? rtrim($sheetId, '*') : $sheetId . '*';
                $spreadsheetId = $this->spreadsheetId;
                $sheetData = Sheets::spreadsheet($spreadsheetId)
                    ->sheet($sheetId)
                    ->get();

                $header = $sheetData->pull(0);
                $properties = Sheets::collection($header, $sheetData);
                $this->propertyImport($sheet, $properties);
            } catch (\Exception $e) {
                $error = $this->parseException($e);
                $message = "Unable to read destination $sheet->name properties. {ErrorMessage} $error";
                $destinationName = $sheet->name;
                $pisLink = '';
                $this->createDbErrorLog($destinationName, $pisLink, $message, 'property', 'error', 'Data/Tech Team');
            }
            //Log::Error('savePropertyData', [$e]);
        }
    }

    /**
     * Get Pis Id
     *
     * @param $property
     * @return \Illuminate\Http\Response
     */
    private function getPisId($property)
    {
        try {
            $pisSheetId = '';
            $pis = str_replace(" ", "", $property['PIS']);
            if (!empty($pis)) {
                $pis = explode('d/', $property['PIS']);
                if (isset($pis[1])) {
                    $pis = explode('/edit', $pis[1]);
                    if (isset($pis[0])) {
                        $pisSheetId = $pis[0];
                    }
                }
            }
            return $pisSheetId;
        } catch (\Exception $e) {
            $error = $this->parseException($e);
            $message = "Some error occurred. {ErrorMessage} $error";
            $destinationName = '';
            $pisLink = '';
            $this->createDbErrorLog($destinationName, $pisLink, $message, 'property', 'error', 'Data/Tech Team');
        }
    }

    private function parseException($e)
    {
        return json_encode(json_decode(json_encode($e->getMessage()), true));
    }

    /**
     * Get Calendar Id
     *
     * @param $pisSheetId
     * @return \Illuminate\Http\Response
     */
    private function getPropertyInformation($destination, $pisSheetId, $skipIndexes = [])
    {
        $response = [];
        if (!empty($pisSheetId)) {
            $spreadsheetId = $pisSheetId;

            try {
                $sheets = Sheets::spreadsheet($spreadsheetId)
                    ->sheetList();
                foreach ($sheets as $value) {
                    $this->readPropertySheet = $sheetId = $value;

                    if (in_array($sheetId, config('sheets.sheets_to_be_imported'))) {
                        $sheetData = Sheets::spreadsheet($spreadsheetId)
                            ->sheet($sheetId)
                            ->get();

                        switch ($sheetId) {
                            case '🏡 Information':

                                $verifyCalendar =

                                    $keys = config('sheets.keys_information');

                                foreach ($keys as $key) {
                                    $this->readIndex = $index = $key['index'] - 1;
                                    $valueIndex = (isset($key['value_index']) ? ($key['value_index'] - 1) : 4);
                                    $dbKey = $key['db_key'];
                                    if (!in_array($index, $skipIndexes)) {
                                        if (isset($sheetData[$index][$valueIndex])) {
                                            $response[$dbKey] = $sheetData[$index][$valueIndex];

                                            if ($dbKey == 'google_calendar_link') {
                                                if (isset($sheetData[$index][10]) && $sheetData[$index][10] === '🚩') {
                                                    return false;
                                                }
                                                $googleCalendarLink = $sheetData[$index][$valueIndex];
                                                $calendarIdArr = explode('?src=', $googleCalendarLink);
                                                if (isset($calendarIdArr[1])) {
                                                    $calendarIdArr = explode('%40group.calendar', $calendarIdArr[1]);
                                                    if (isset($calendarIdArr[0])) {
                                                        $response['google_calendar_id'] = $calendarIdArr[0];
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        $response[$dbKey] = '';
                                    }
                                }
                                break;
                            case '💰 Pricing':
                                $response['pricing'] = [];
                                foreach ($sheetData as $i => $values) {
                                    if ($i > 1) {
                                        $keys = config('sheets.keys_pricing');
                                        foreach ($keys as $key) {
                                            $this->readIndex = $index = $key['index'];
                                            $dbKey = $key['db_key'];
                                            if (!in_array($index, $skipIndexes)) {
                                                if (isset($values[$index]) && $values[$index]) {
                                                    if (in_array($dbKey, array('from', 'to')) && $values[$index]) {
                                                        $values[$index] = str_replace(' ', ' ', $values[$index]);
                                                        if (preg_match("/([1-9]|0[1-9]|1[0-2]|2[0-9]|3[0-1])+\s[A-Za-z]{3}\s[0-9]{4}/i", $values[$index])) {
                                                            $values[$index] = @Carbon::createFromFormat('d M Y', $values[$index])->format('Y-m-d');
                                                        } else {
                                                            $message = "Invalid Date found. Date: " . $values[$index] . ' {ErrorMessage}';
                                                            $destinationName = $destination;
                                                            $pisLink = $pisSheetId;
                                                            $this->createDbErrorLog($destinationName, $pisLink, $message, 'property', 'error', 'Data Team');
                                                            $values[$index] = null;
                                                        }
                                                    } else if ($values[$index]) {
                                                        if (preg_match("/(\d+)(\,?)(\d?)\.[0-9]{2}/i", $values[$index])) {
                                                            $values[$index] = str_replace(',', '', $values[$index]);
                                                        } else {
                                                            $message = "Invalid Price found. Price: " . $values[$index] . ' {ErrorMessage}';
                                                            $destinationName = $destination;
                                                            $pisLink = $pisSheetId;
                                                            $this->createDbErrorLog($destinationName, $pisLink, $message, 'property', 'error', 'Data Team');
                                                            $values[$index] = null;
                                                        }
                                                    } else {
                                                        $values[$index] = null;
                                                    }
                                                } else {
                                                    $values[$index] = null;
                                                }
                                            } else {
                                                $values[$index] = null;
                                            }
                                            if (isset($response['pricing'][$i])) {
                                                $response['pricing'][$i] = array_merge($response['pricing'][$i], [$dbKey => $values[$index]]);
                                            } else {
                                                $response['pricing'][$i] = [$dbKey => $values[$index]];
                                            }
                                        }
                                    }
                                }
                                break;
                        }

                    }
                }
            } catch (\Exception $e) {
                $error = $this->parseException($e);
                $message = "Unable to read property information property id $pisSheetId, Sheet Id " . $this->readPropertySheet . " . {ErrorMessage} $error";
                $destinationName = $destination;
                $pisLink = $pisSheetId;
                $errorEncoded = json_decode(json_encode($e->getMessage()), true);
                $errorCategory = (isset($errorEncoded['error']['code'])) ? 'Tech Team' : 'Data Team';
                $this->createDbErrorLog($destinationName, $pisLink, $message, 'property', 'error', $errorCategory);

                $skipIndexes[] = $this->readIndex;
                $this->getPropertyInformation($destination, $pisSheetId, $skipIndexes);
            }
        }

        return $response;
    }

    /**
     * Create Or Update Events
     *
     * @param $property
     * @return \Illuminate\Http\Response
     */
    public function getEventsFromIcsFile($property)
    {

        if (@$property->ical_link) {

            $icalLink = $property->ical_link;

            try {
                $ical = new ICal(
                    $icalLink,
                    [
                        'defaultSpan' => 2,
                        // Default value
                        'defaultTimeZone' => 'UTC',
                        'defaultWeekStart' => 'MO',
                        // Default value
                        'disableCharacterReplacement' => false,
                        // Default value
                        'filterDaysAfter' => null,
                        // Default value
                        'filterDaysBefore' => null,
                        // Default value
                        'httpUserAgent' => null,
                        // Default value
                        'skipRecurrence' => false,
                        // Default value
                    ]
                );

                if ($ical->hasEvents()) {
                    $events = $ical->events();
                    //Log::Error("Events", [$events]);
                    //Log::Error("Ical", [$ical]);
                    //Log::Error("Property", [$property]);
                    $this->createOrUpdateEvents($events, $ical, $property);
                } else {
                    $message = "No calendar events found Destination " . $property->destination . ", Property Name " . $property->name . ' {ErrorMessage}';
                    $destinationName = $property->destination;
                    $pisLink = $property->pis_sheet_id;
                    $this->createDbErrorLog($destinationName, $pisLink, $message, 'calendar', 'warning', 'Sales Team');
                }
            } catch (\Exception $e) {
                $error = $this->parseException($e);
                $message = "Unable to read calendar events from Google -  Destination " . $property->destination . ", Property Name " . $property->name . " . {ErrorMessage} $error";
                $destinationName = $property->destination;
                $pisLink = $property->pis_sheet_id;
                $this->createDbErrorLog($destinationName, $pisLink, $message, 'calendar', 'error', 'Data/Tech Team');
            }
        }
    }

    /**
     * Create Or Update Events
     *
     * @param $events
     * @param $ical
     * @param $propertyDb
     * @return \Illuminate\Http\Response
     */
    private function createOrUpdateEvents($events, $ical, $propertyDb)
    {
        $uIDs = [];
        foreach ($events as $event) {
            $dtstart = $ical->iCalDateToDateTime($event->dtstart_array[3]);
            $dtend = $ical->iCalDateToDateTime($event->dtend_array[3]);

            $where = [
                'property_id' => $propertyDb->id,
                'uid' => $event->uid
            ];

            $uIDs[] = $event->uid;

            DuplicateEvent::updateOrCreate(
                $where,
                [
                    'name' => $event->summary,
                    'duration' => $event->duration,
                    'start' => $dtstart->format('Y-m-d H:i:s'),
                    'end' => $dtend->format('Y-m-d H:i:s'),
                    'description' => $event->description,
                    'location' => $event->location,
                    'status' => $event->status,
                    'transp' => $event->transp,
                ]
            );
        }
        $eventsToBeDeleted = DuplicateEvent::where('property_id', $propertyDb->id)->whereNotIn('uid', $uIDs);
        if ($eventsToBeDeleted->count() > 0) {
            $eventsToBeDeleted->delete();
        }

    }


    /**
     * SQL Like operator in PHP.
     * Returns TRUE if match else FALSE.
     * @param string $str
     * @param string $searchTerm
     * @return bool
     */
    private function like($str, $searchTerm)
    {
        $searchTerm = strtolower($searchTerm);
        $str = strtolower($str);
        $pos = strpos($str, $searchTerm);
        if ($pos === false)
            return false;
        else
            return true;
    }




    public function edit($id)
    {


        User::find(1);
        User::where('id', 1)->first();


        $user = User::find($id);
        //dd($user);
    }

    public function createTask(Request $request)
    {
        $this->validate($request, [
            'property_id' => 'required',
            'daterange_mobile' => 'required',
            'requestee_id' => 'required'
        ]);

        $requesteeValue = config('app.clickup_custom_field_requestee_value');
        if ($request->filled('requestee_id')) {
            $requesteeValue = $request->requestee_id;
        }

        list($startDate, $endDate) = explode(' - ', $request->daterange_mobile);

        $url = config('app.clickup_base_url') . 'list/' . config('app.clickup_list_id') . '/task';
        $requestData = [
            'name' => $request->property_id . ' - Sales Platform Unavailability',
            'status' => config('app.clickup_status'),
            'custom_fields' => [
                [
                    'id' => config('app.clickup_custom_field_request_desc_id'),
                    'value' => 'Please mark this house NOT available from ' . $startDate . ' until ' . $endDate
                ],
                [
                    'id' => config('app.clickup_custom_field_request_type_id'),
                    'value' => config('app.clickup_custom_field_request_type_value')
                ],
                [
                    'id' => config('app.clickup_custom_field_requestee_id'),
                    'value' => $requesteeValue
                ]
            ]
        ];
        try {

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => config('app.clickup_api_key')
            ])->post($url, $requestData);

            if ($response->status() == 200) {
                return response()->json(['success' => true], 200);
            } else {
                return response()->json(['success' => false], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false], 200);
        }
    }
}