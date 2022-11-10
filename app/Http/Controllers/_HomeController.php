<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Google\Client;
use Revolution\Google\Sheets\Facades\Sheets;

use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;

use ICal\ICal;

use App\Models\Sheet;
use App\Models\Property;
use App\Models\Event as EventModel;

use Storage;
use DB;

class _HomeController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request) {

        $properties = [];
        if ($request->filled('start_date') && $request->filled('end_date')) {

            $startDate = date('Y-m-d', strtotime($request->start_date));
            $endDate = date('Y-m-d', strtotime($request->end_date));
            $page = ($request->filled('page')) ? (int) $request->page : 1;
            $paginate = 10;

            $query = 'SELECT
                    properties.id,
                    properties.name,
                    properties.property_id,
                    properties.account,
                    properties.description,
                    sheets.name as sheet_name,
                    SUM(IF((CAST("'.$startDate.'" AS DATE) BETWEEN DATE(events.start) and DATE(events.end) OR CAST("'.$endDate.'" AS DATE) BETWEEN DATE(events.start) and DATE(events.end)), 1, 0))  as total_bookings
                FROM
                    properties
                LEFT JOIN `events` ON events.property_id = properties.id
                LEFT JOIN `sheets` ON properties.sheet_id = sheets.id
                GROUP BY
                    properties.id,properties.property_id
                HAVING total_bookings = 0
                ORDER BY `properties`.`id`  ASC';

            $properties = DB::select(DB::raw($query));
            $offset = ($page * $paginate) - $paginate ;
            $itemstoshow = array_slice($properties , $offset , $paginate);
            $properties = new LengthAwarePaginator($itemstoshow, count($properties), $paginate, $page, ['path' => $request->url() ]);


            // DB::enableQueryLog();
            // $properties = Property::select(
            //                     'properties.*',
            //                     DB::raw('IF((CAST("'. $startDate .'" AS DATE) BETWEEN DATE(events.start) and DATE(events.end) OR CAST("'. $endDate .'" AS DATE) BETWEEN DATE(events.start) and DATE(events.end)), 1, 0)  as total_bookings')
            //                 )
            //                 ->leftJoin('events', 'events.property_id', '=', 'properties.id')
            //                 //->with('sheet')
            //                 ->groupBy('properties.id', 'properties.property_id', 'properties.name')
            //                 //->having('total_bookings', 0)
            //                 ->get();
            // dd(DB::getQueryLog());

            //dd($properties->toArray());
        }

        return view('properties', compact('properties'));
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
        $spreadsheetId = $this->spreadsheetId;
        $sheets = Sheets::spreadsheet($spreadsheetId)
            ->sheetList();
            foreach ($sheets as $id => $value) {
                $sheet = Sheet::updateOrCreate([
                    'sheet_id' => $id,
                    'name' => $value
                ]);
            }
            exit('Sheets Imported');
    }

    /**
     * Import Properties
     *
     * @return \Illuminate\Http\Response
     */
    public function importProperties ($sheetId) {
        ini_set('max_execution_time', 180);

        $spreadsheetId = $this->spreadsheetId;

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
        ini_set('max_execution_time', 180000);

        $spreadsheetId = $this->spreadsheetId;

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
    private function savePropertyData ($sheet) {

        $sheetId = $sheet->name;
        $spreadsheetId = $this->spreadsheetId;
        $sheetData = Sheets::spreadsheet($spreadsheetId)
                        ->sheet($sheetId)
                        ->get();

        $header = $sheetData->pull(0);
        $properties = Sheets::collection($header, $sheetData);

        foreach($properties as $property) {
            if (isset($property['Property ID'])) {

                $propertyId = str_replace(" ", "", $property['Property ID']);
                if ($propertyId != '') {

                    $where = [
                        'sheet_id' => $sheet->id,
                        'property_id' => $propertyId
                    ];
                    //$propertyDbEx = Property::where($where)->first(); // remove after import
                    //if (!$propertyDbEx) { // remove after import
                        $pisSheetId = $this->getPisId($property);
                        $propertyInformation = $this->getPropertyInformation($pisSheetId);

                        $propertyData = [
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

                        $propertyCompleteData = array_merge($propertyData, $propertyInformation);

                        $propertyDb = Property::updateOrCreate($where,$propertyCompleteData);

                        if ($propertyDb) {
                            //$this->getEventsFromIcsFile($propertyDb);
                        }
                    //}
                    //dd('done 1');
                }
            }
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

        if (!empty($pisSheetId)) {
            $spreadsheetId = $pisSheetId;
            $sheets = Sheets::spreadsheet($spreadsheetId)
                                    ->sheetList();
            foreach ($sheets as $id => $value) {
                $sheetId = $value;
                $sheetData = Sheets::spreadsheet($spreadsheetId)
                        ->sheet($sheetId)
                        ->get();
                //dd($sheetData);

                if(isset($sheetData[3][4]) && @$sheetData[3][1] == 'Media') {
                    $response['images_folder_link'] = $sheetData[3][4];
                }

                if(isset($sheetData[4][4]) && @$sheetData[4][3] == 'Youtube Embed Link') {
                    $response['youtube_embed_link'] = $sheetData[4][4];
                }

                if(isset($sheetData[6][4]) && @$sheetData[6][3] == 'Public Google Calendar') {
                    $response['google_calendar_link'] = $googleCalendarLink = $sheetData[6][4];
                    $calendarIdArr = explode('?src=', $googleCalendarLink);
                    if (isset($calendarIdArr[1])) {
                        $calendarIdArr = explode('%40group.calendar', $calendarIdArr[1]);
                        if (isset($calendarIdArr[0])) {
                            $response['google_calendar_id'] = $calendarIdArr[0];
                        }
                    }
                }

                if(isset($sheetData[7][4]) && @$sheetData[7][3] == 'Internal iCal link') {
                    $response['ical_link'] = $sheetData[7][4];
                }

                if(isset($sheetData[28][4]) && $this->like(@$sheetData[28][3], 'Rating')) {
                    $response['property_rating'] = $sheetData[28][4];
                }

                if(isset($sheetData[29][4]) && @$sheetData[29][3] == 'Property Type') {
                    $response['property_type'] = $sheetData[29][4];
                }

                if(isset($sheetData[30][4]) && $this->like(@$sheetData[30][3], 'Design')) {
                    $response['design_type'] = $sheetData[30][4];
                }

                if(isset($sheetData[31][4]) && $this->like(@$sheetData[31][3], 'Owner')) {
                    $response['owner_name'] = $sheetData[31][4];
                }

                if(isset($sheetData[32][4]) && $this->like(@$sheetData[32][3], 'Manager')) {
                    $response['property_manager'] = $sheetData[32][4];
                }

                if(isset($sheetData[33][4]) && $this->like(@$sheetData[33][3], 'Guest')) {
                    $response['max_guests'] = $sheetData[33][4];
                }

                if(isset($sheetData[34][4]) && $this->like(@$sheetData[34][3], 'Beds')) {
                    $response['no_of_beds'] = $sheetData[34][4];
                }

                if(isset($sheetData[35][4]) && $this->like(@$sheetData[35][3], 'Bathrooms')) {
                    $response['no_of_bathrooms'] = $sheetData[35][4];
                }

                if(isset($sheetData[36][4]) && $this->like(@$sheetData[36][3], 'Bedrooms')) {
                    $response['no_of_bedrooms'] = $sheetData[36][4];
                }

                if(isset($sheetData[37][4]) && @$sheetData[37][3] == 'Descriptive Text') {
                    $response['description'] = $sheetData[37][4];
                }

                if(isset($sheetData[38][4]) && $this->like(@$sheetData[37][3], 'tag')) {
                    $response['tag_line'] = $sheetData[38][4];
                }

                if(isset($sheetData[39][4]) && $this->like(@$sheetData[39][3], 'size')) {
                    $response['property_size'] = $sheetData[39][4];
                }

                if(isset($sheetData[40][4]) && $this->like(@$sheetData[40][3], 'Complex')) {
                    $response['hotel_complex'] = $sheetData[40][4];
                }

                if(isset($sheetData[41][4]) && $this->like(@$sheetData[41][3], 'Gated Community')) {
                    $response['gated_community'] = $sheetData[41][4];
                }

                if(isset($sheetData[42][4]) && $this->like(@$sheetData[42][3], 'Eco Friendly')) {
                    $response['eco_friendly'] = $sheetData[42][4];
                }

                if(isset($sheetData[43][4]) && $this->like(@$sheetData[43][3], 'View Types')) {
                    $response['view_types'] = $sheetData[43][4];
                }

                if(isset($sheetData[44][4]) && $this->like(@$sheetData[44][3], 'Placement')) {
                    $response['placement_types'] = $sheetData[44][4];
                }

                if(isset($sheetData[45][4]) && $this->like(@$sheetData[45][3], 'Curator')) {
                    $response['curator'] = $sheetData[45][4];
                }

                if(isset($sheetData[47][4]) && $this->like(@$sheetData[47][3], 'Events')) {
                    $response['parties_events'] = $sheetData[47][4];
                }

                if(isset($sheetData[48][4]) && $this->like(@$sheetData[48][3], 'Smoking')) {
                    $response['smoking'] = $sheetData[48][4];
                }

                if(isset($sheetData[49][4]) && $this->like(@$sheetData[49][3], 'Smoking')) {
                    $response['pets'] = $sheetData[49][4];
                }

                if(isset($sheetData[50][4]) && $this->like(@$sheetData[50][3], 'Adults')) {
                    $response['adults'] = $sheetData[50][4];
                }

                if(isset($sheetData[51][4]) && $this->like(@$sheetData[51][3], 'Good to know')) {
                    $response['good_to_know'] = $sheetData[51][4];
                }

                if(isset($sheetData[52][4]) && $this->like(@$sheetData[52][3], 'Coordinates')) {
                    $response['coordinates'] = $sheetData[52][4];
                }

                if(isset($sheetData[53][4]) && $this->like(@$sheetData[53][3], 'Street')) {
                    $response['street'] = $sheetData[53][4];
                }

                if(isset($sheetData[54][4]) && $this->like(@$sheetData[54][3], 'Zip Code')) {
                    $response['zip_code'] = $sheetData[54][4];
                }

                if(isset($sheetData[55][4]) && $this->like(@$sheetData[55][3], 'City')) {
                    $response['city'] = $sheetData[55][4];
                }

                if(isset($sheetData[56][4]) && $this->like(@$sheetData[56][3], 'Country')) {
                    $response['country'] = $sheetData[56][4];
                }

                if(isset($sheetData[57][4]) && $this->like(@$sheetData[57][3], 'Location')) {
                    $response['location_description'] = $sheetData[57][4];
                }

                if(isset($sheetData[58][4]) && $this->like(@$sheetData[58][3], 'Airport')) {
                    $response['airport'] = $sheetData[58][4];
                }

                if(isset($sheetData[67][4]) && $this->like(@$sheetData[67][3], 'Other Room details')) {
                    $response['other_room_details'] = $sheetData[67][4];
                }

                break;
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
    private function getEventsFromIcsFile ($property) {

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
        foreach($events as $event) {
            $dtstart = $ical->iCalDateToDateTime($event->dtstart_array[3]);
            $dtend = $ical->iCalDateToDateTime($event->dtend_array[3]);

            $where = [
                'property_id' => $propertyDb->id,
                'uid' => $event->uid
            ];

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
}
