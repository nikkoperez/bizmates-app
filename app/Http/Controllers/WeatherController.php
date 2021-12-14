<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Services\FoursquareService;

class WeatherController extends Controller
{
    /**
     * Weather service dependency
     *
     * @var [type]
     */
    private $weatherService;

    /**
     * Foursquare service dependency
     *
     * @var [type]
     */
    private $foursquareService;
    
    /**
     * Constructor
     *
     * @param WeatherService $wService, FoursquareService $fService
     */
    public function __construct(WeatherService $wService, FoursquareService $fService){
        $this->weatherService = $wService;
        $this->foursquareService = $fService;
    }

    /**
     * Index page
     *
     * @return void
     */
    public function index(){
        return view('content.weather');
    }

    /**
     * Retrieve weather details
     *
     * @param Request $request
     * @return json
     */
    public function getForecast(Request $request){
        $forecast = $this->weatherService->getRequestForecast($request->get('city'));
        if (is_array($forecast))
            echo json_encode($forecast);
        else
            echo json_encode(0);
    }

    /**
     * Retrieve places details 
     *
     * @param Request $request
     * @return json
     */
    public function getPlaces(Request $request){
        $places = $this->foursquareService->getRequestPlace($request->get('city'),$request->get('lng'),$request->get('lat'));
        echo json_encode($places);
    }
}
