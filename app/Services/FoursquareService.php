<?php
namespace App\Services;

/**
 * Foursquare Service
 */
class FoursquareService
{
    /**
     * Get nearby places from Foursquare API
     *
     * @param [string] $cityName, [int] $lng, [int] $lat
     * @return array
     */
    public function getRequestPlace($cityName,$lng,$lat)
    {
        $placeInfo = [];
        $clientId = 'DY2V5QY1XUIZW21O0MPTY1HRDBRL20AUXFOZKA2PRVZRW54K';
        $clientSecret = '0VPSUYLSQXBPOW2E2UI0P5CW0KC0CWTG3KEKTWPFEHRC1ADX';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.foursquare.com/v3/places/nearby?ll='.$lat.'%2C'.$lng.'&categoryId=4deefb944765f83613cdba6e&client_id='.$clientId.'&client_secret='.$clientSecret.'&v='.date('Ymd').'&query=near%3D'.$cityName.'&limit=40', [
            'headers' => [
              'Accept' => 'application/json',
              'Authorization' => 'fsq33XhWwcEYlAdfm63Yah+gpUJf5dO4UTlz3nwOQq6/FCY=',
            ],
          ]);
        $places = json_decode($response->getBody(),true);
        return $this->parsePlace($places['results']);
    }

    /**
     * Parse places data
     *
     * @param [array] $placesArray
     * @return array
     */
    public function parsePlace($placesArray){
        $formattedContainer = [];
        foreach($placesArray as $row){
            $placeInfo['locality'] = isset($row['location']['locality']) ? $row['location']['locality'] : "";
            $placeInfo['address'] = isset($row['location']['address']) ? $row['location']['address'] : "";;
            $placeInfo['name'] = $row['name'];
            $placeInfo['lat'] = $row['geocodes']['main']['latitude'];
            $placeInfo['lng'] = $row['geocodes']['main']['longitude'];

            if(isset($row['location']['locality']) && isset($row['location']['address']))
                $formattedContainer[] = $placeInfo;
        }
        return $formattedContainer;
    }

}