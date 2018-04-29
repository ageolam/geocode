<?php
require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$apiKey = getenv('GEOCODE_API');
$countriesStates = require('germanyStates.php');
$locationArray   = [];

foreach ($countriesStates as $country => $stateArray) {
    foreach ($stateArray as $state) {
        $location = getGeocode($state, $apiKey);
        $locationArray[$country][$state] = [
            'lat'  => $location['lat'],
            'lon'  => $location['lng'],
        ];
    }
}

var_export($locationArray);



function getGeocode($state, $apiKey)
{
    $state = str_replace(' ', '%20', $state);

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://maps.googleapis.com/maps/api/geocode/json?address='.$state.'&key='.$apiKey,
    ]);
    $resp = json_decode(curl_exec($curl), true);
    curl_close($curl);

    return $resp['results'][0]['geometry']['location'];
}
