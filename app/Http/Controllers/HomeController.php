<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use Revolution\Google\Sheets\Facades\Sheets;

use Carbon\Carbon;

use ICal\ICal;

use App\Models\Sheet;
use App\Models\Property;
use App\Models\Event as EventModel;

use DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $spreadsheetId;


    public function __construct()
    {
        $this->spreadsheetId = config('sheets.post_spreadsheet_id');
    }

    public function searchProperties(Request $request){
        $searchString = $request->searchString;
        if ($searchString) {
            $where = ' WHERE 1 AND properties.ical_link IS NOT NULL AND (properties.name LIKE "%'.$searchString.'%" OR properties.property_id LIKE "%'.$searchString.'%")';
            $orderBy = 'properties.name ASC';
            $query = 'SELECT
                    properties.clickup_id,
                    properties.name,
                    properties.property_id
                FROM properties
                LEFT JOIN `events` ON events.property_id = properties.id
                '. $where .'
                GROUP BY
                    properties.id,properties.property_id
                ORDER BY '.$orderBy.'
                LIMIT 10 ';

            $properties = DB::select(DB::raw($query));

            $searchElements = '';
            foreach($properties as $property){
                $searchElements .= '<div class="search-element">
                <div class="title-element">
                    <h2>' . $property->name . ' </h2>
                    <p>'. $property->property_id.'</p>
                    </div>
                    <div class="btnClick">
                        <a class="'.($property->clickup_id ? 'active' : 'disabled').'" href="'.($property->clickup_id ? $property->clickup_id : 'javascript:void(0)').'" target="_blank">ClickUp</a>
                        </div>
                    </div>';
            }
            return $searchElements;
        }else{
            return '';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request) {

        $properties = [];
        if ($request->filled('start_date') && $request->filled('end_date')) {

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
            if ($request->filled('sort_by')) {
                $sortBy = $request->sort_by;
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
                    default:
                        $orderBy = 'properties.name ASC';
                        break;
                }
            }

            $startDate = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d'); //m/d/Y
            $endDate = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
            $page = ($request->filled('page')) ? (int) $request->page : 1;
            $paginate = 50;

            $query = 'SELECT
                    properties.id,
                    properties.clickup_id,
                    properties.name,
                    properties.property_id,
                    properties.account,
                    properties.country,
                    properties.destination,
                    properties.city,
                    properties.property_type,
                    properties.max_guests,
                    properties.no_of_beds,
                    properties.no_of_bathrooms,
                    properties.no_of_bedrooms,
                    SUM(IF((CAST("'.$startDate.'" AS DATE) BETWEEN DATE(events.start) and DATE_SUB(DATE(events.end), INTERVAL 1 DAY)) OR (CAST("'.$endDate.'" AS DATE) BETWEEN DATE(events.start) and DATE_SUB(DATE(events.end), INTERVAL 1 DAY)) OR (DATE(events.start) > CAST("'.$startDate.'" AS DATE) AND DATE_SUB(DATE(events.end), INTERVAL 1 DAY) < CAST("'.$endDate.'" AS DATE)), 1, 0)) as total_bookings
                FROM properties
                LEFT JOIN `events` ON events.property_id = properties.id
                '. $where .'
                GROUP BY
                    properties.id,properties.property_id
                HAVING total_bookings = 0
                ORDER BY '.$orderBy;

            $properties = DB::select(DB::raw($query));
            $offset = ($page * $paginate) - $paginate ;
            $itemstoshow = array_slice($properties , $offset , $paginate);
            $properties = new LengthAwarePaginator($itemstoshow, count($properties), $paginate, $page, ['path' => $request->url() ]);

        }

        $cities = Property::whereNotNull('destination')->groupBy('destination')->pluck('destination');
        $maxBedrooms = Property::select(DB::raw('MAX(CAST(properties.no_of_bedrooms AS UNSIGNED)) as no_of_bedrooms'))->first()->no_of_bedrooms;

        return view('properties', compact('cities', 'properties', 'maxBedrooms'));
    }

    public function paginate($items , $perpage ){
        $total = count($items);
        $currentpage = \Request::get('page', 1);
        $offset = ($currentpage * $perpage) - $perpage ;
        $itemstoshow = array_slice($items , $offset , $perpage);
        $p = new LengthAwarePaginator($itemstoshow ,$total ,$perpage);
        $p->setPath(\Request::url());

        return $p;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show ($id) {

        $property = Property::with('sheet', 'events');

        return view('property-detail', compact('property'));
    }

    /**
     * Import Sheets
     *
     * @return \Illuminate\Http\Response
     */
    public function importSheets () {
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
            Log:Error('importSheets', [$e]);
        }

        exit('Sheets Imported');
    }

    /**
     * Import Properties
     *
     * @return \Illuminate\Http\Response
     */
    public function importProperties ($sheetId = '') {
        ini_set('max_execution_time', 0);

        $sheet = Sheet::where('name', $sheetId)->first();
        if ($sheet) {
            $this->savePropertyData($sheet);
            dd('Property Imported');
        } else {
            $sheets = Sheet::get();
            foreach ($sheets as $sheet) {
                $this->savePropertyData($sheet);
            }
        }

        dd('Properties Imported');
    }

    /**
     * Import Calander
     *
     * @return \Illuminate\Http\Response
     */
    public function importCalander ($propertyId = 0) {
        ini_set('max_execution_time', 0);

        $property = Property::where('property_id', $propertyId)->first();
        if ($propertyId != 0 && $property) {
            $this->getEventsFromIcsFile($property);
            dd('Calander Imported');
        } else {
            $properties = Property::get();
            foreach($properties as $property) {
                $this->getEventsFromIcsFile($property);
            }
        }

        dd('Calanders Imported');
    }

    /**
     * Save Property Data
     *
     * @param $sheet
     * @return \Illuminate\Http\Response
     */
    public function savePropertyData ($sheet) {

        try {
            $sheetId = $sheet->name;
            $spreadsheetId = $this->spreadsheetId;
            $sheetData = Sheets::spreadsheet($spreadsheetId)
                            ->sheet($sheetId)
                            ->get();

            $header = $sheetData->pull(0);
            $properties = Sheets::collection($header, $sheetData);

            foreach($properties as $key => $property) {
                if (isset($property['Property ID'])) {

                    $propertyId = str_replace(" ", "", $property['Property ID']);
                    if ($propertyId != '') {

                        $where = [
                            'sheet_id' => $sheet->id,
                            'property_id' => $propertyId
                        ];
                        $pisSheetId = $this->getPisId($property);
                        $propertyInformation = $this->getPropertyInformation($pisSheetId);

                        $propertyData = [
                            'clickup_id' => @$property['Clickup ID'],
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

                        Log::Error('PropertyData', $propertyData);

                        $propertyCompleteData = array_merge($propertyData, $propertyInformation);

                        Property::updateOrCreate($where,$propertyCompleteData);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::Error('savePropertyData', [$e]);
        }
    }

    /**
     * Get Pis Id
     *
     * @param $property
     * @return \Illuminate\Http\Response
     */
    private function getPisId ($property) {
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
    }

    /**
     * Get Calendar Id
     *
     * @param $pisSheetId
     * @return \Illuminate\Http\Response
     */
    private function getPropertyInformation ($pisSheetId) {

        $response = [];
        if (!empty($pisSheetId)) {
            $spreadsheetId = $pisSheetId;

            try {
                $sheets = Sheets::spreadsheet($spreadsheetId)
                                        ->sheetList();
                foreach ($sheets as $id => $value) {
                    $sheetId = $value;
                    $sheetData = Sheets::spreadsheet($spreadsheetId)
                            ->sheet($sheetId)
                            ->get();

                    $keys = config('sheets.keys');
                    foreach($keys as $key) {
                        $index = $key['index'] - 1;
                        $valueIndex = (isset($key['value_index']) ?  ($key['value_index'] - 1) : 4);
                        $dbKey = $key['db_key'];

                        if(isset($sheetData[$index][$valueIndex])) {
                            $response[$dbKey] = $sheetData[$index][$valueIndex];

                            if ($dbKey == 'google_calendar_link') {
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

                    }
                    break;
                }
            } catch (\Exception $e) {
                Log::Error('getPropertyInformation', [$e]);
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
    public function getEventsFromIcsFile ($property) {

            if (@$property->ical_link) {

                $icalLink = $property->ical_link;

                try {
                    $ical = new ICal($icalLink,
                    [
                        'defaultSpan'                 => 2,     // Default value
                        'defaultTimeZone'             => 'UTC',
                        'defaultWeekStart'            => 'MO',  // Default value
                        'disableCharacterReplacement' => false, // Default value
                        'filterDaysAfter'             => null,  // Default value
                        'filterDaysBefore'            => null,  // Default value
                        'httpUserAgent'               => null,  // Default value
                        'skipRecurrence'              => false, // Default value
                    ]);

                    if ($ical->hasEvents()) {
                        $events = $ical->events();
                        $this->createOrUpdateEvents($events, $ical, $property);
                    }
                } catch (\Exception $e) {

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
    private function createOrUpdateEvents ($events, $ical, $propertyDb) {
        $uIDs = [];
        foreach($events as $event) {
            $dtstart = $ical->iCalDateToDateTime($event->dtstart_array[3]);
            $dtend = $ical->iCalDateToDateTime($event->dtend_array[3]);

            $where = [
                'property_id' => $propertyDb->id,
                'uid' => $event->uid
            ];

            $uIDs[] = $event->uid;

            $eventDb = EventModel::where($where)->first();
            if(!$eventDb) {
                EventModel::updateOrCreate($where,
                [
                    'name' => $event->summary,
                    'duration' => $event->duration,
                    'start' => $dtstart->format('Y-m-d H:i:s'),
                    'end' => $dtend->format('Y-m-d H:i:s'),
                    'description' => $event->description,
                    'location' => $event->location,
                    'status' => $event->status,
                    'transp' => $event->transp,
                ]);
            }
        }
        $eventsToBeDeleted = EventModel::where('property_id', $propertyDb->id)->whereNotIn('uid', $uIDs);
        if($eventsToBeDeleted->count() > 0){
            Log::Error('DeletingPropertyEvents', [$propertyDb]);
            Log::Error('DeletingEvents', [$eventsToBeDeleted->get()]);
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
    private function like($str, $searchTerm) {
        $searchTerm = strtolower($searchTerm);
        $str = strtolower($str);
        $pos = strpos($str, $searchTerm);
        if ($pos === false)
            return false;
        else
            return true;
    }




    public function edit($id) {


        User::find(1);
        User::where('id', 1)->first();


        $user = User::find($id);
        dd($user);
    }
}
