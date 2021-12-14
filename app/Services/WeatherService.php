<?php
namespace App\Services;

/**
 * Weather Service
 */
class WeatherService
{
    /**
     * Get weather data from OpenWeatherMap API
     *
     * @param [string] $cityName
     * @return array
     */
    public function getRequestForecast($cityName)
    {
        $weatherInfo = [];
        $appId = 'daf02c61391f9f612411ad0bd83240ed';
        $units = 'metric';
        $days = 5;

        $api_url = 'http://api.openweathermap.org/data/2.5/forecast/daily?q='.$cityName.'&APPID='.$appId.'&units='.$units.'&cnt='.$days;
        
        try {
            $weatherInfo = json_decode(file_get_contents($api_url));
            return $this->parseForecast($weatherInfo);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Parse weather data 
     *
     * @param [type] $forecastArray
     * @return array
     */
    public function parseForecast($forecastArray){
        foreach($forecastArray->list as $row){
            $forecastInfo['dt_txt'] = date('l', $row->dt);
            $forecastInfo['hour'] = date('g:i a', $row->dt);
            $forecastInfo['main'] = $row->weather[0]->main;
            $forecastInfo['description'] = $row->weather[0]->description;
            $forecastInfo['icon'] = $row->weather[0]->icon.'.png';
            $forecastInfo['temp_min'] = $row->temp->min;
            $forecastInfo['temp_max'] = $row->temp->max;
            $forecastInfo['pressure'] = $row->pressure;
            $forecastInfo['humidity'] = $row->humidity;
            $forecastInfo['lng'] = $forecastArray->city->coord->lon;
            $forecastInfo['lat'] = $forecastArray->city->coord->lat;
            
            $formattedContainer[] = $forecastInfo;
        }
        return $formattedContainer;
    }

}