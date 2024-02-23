<?php

namespace App\Service;

use App\Traits\ApiResponseTrait;
use App\Service\GeoDBCountriesService;

class GeoDBSearchService extends GeoDBAbstractBaseService
{
    use ApiResponseTrait;

    private $geoDBCitiesService, $geoDBCountriesService, $geoDBSearchService;

    public function __construct(GeoDBCitiesService $geoDBCitiesService, GeoDBCountriesService $geoDBCountriesService)
    {
        $this->geoDBCitiesService = $geoDBCitiesService;
        $this->geoDBCountriesService = $geoDBCountriesService;

    }

    public function searchByCountry($country)
    {
        $country_details = $this->geoDBCountriesService->getCountryDetails($country);
        $country_details = $this->getData($country_details);
        $capital_city = $country_details->capital;
        sleep(2) ;
        $capitalCityDetails=$this->geoDBCitiesService->findCityByCountryAndName($country,$capital_city);
        $capitalCityDetails = $this->getData($capitalCityDetails)[0];
        $capital_city_id = $capitalCityDetails->id;
        sleep(2) ;

        $nearby_cities = $this->geoDBCitiesService->getNearbyCities($capital_city_id);
        $nearby_cities = $this->getData($nearby_cities);

        $response_data = [
            "country"=>$this->formatCountryDetails($country_details),
            "capital_city"=>$this->formatCapitalCityDetails($capitalCityDetails),
            "places_near_city"=>$this->formatNearbyCities($nearby_cities)
        ];
        return $this->formatResponseToHtml($response_data);
    }


    protected function formatCapitalCityDetails($capitalCityDetails)
    {
        return [
                "name"=>$capitalCityDetails->name,
                "region"=>$capitalCityDetails->region,
                "region_code"=>$capitalCityDetails->regionCode,
                // "elevation"=>$capitalCityDetails->elevation,
                "latitude"=>$capitalCityDetails->latitude,
                "longitude"=>$capitalCityDetails->longitude,
                "population"=>$capitalCityDetails->population,
        ];
    }
    protected function formatNearbyCities($nearby_cities)
    {
        $formatted_nearby_cities = [];
        foreach ($nearby_cities as $city) {

            $formatted_nearby_cities[] = [
                'name' => $city->name,
                'region' => $city->region,
                'region_code' => $city->regionCode,
                // 'elevation' => $city->elevation,
                'latitude' => $city->latitude,
                'longitude' => $city->longitude,
                'population' => $city->population,
            ];
        }
        return $formatted_nearby_cities;
    }

    protected function formatCountryDetails($country_details)
    {
        return [
            "name" =>$country_details->name,
            "code" =>$country_details->code,
            "currency"=>$country_details->currencyCodes[0],
            "flag"=>$country_details->flagImageUri,
        ];
    }

    public function formatResponseToHtml($response_data)
    {
        $html = "<h1>Country: ".$response_data['country']['name']."</h1>";
        $html .= "<h3>Country Details</h3>";
        $html .= "<p>Country Code: ".$response_data['country']['code']."</p>";
        $html .= "<p>Currency: ".$response_data['country']['currency']."</p>";
        $html .= "<p>Flag: <img src='".$response_data['country']['flag']."' style='height: 50px;'></p>";

        $html .= "<h2>Capital City: ".$response_data['capital_city']['name']."</h2>";
        $html .= "<h3>Capital City Details</h3>";
        $html .= "<p>Region: ".$response_data['capital_city']['region']."</p>";
        $html .= "<p>Region Code: ".$response_data['capital_city']['region_code']."</p>";
        // $html .= "<p>Elevation: ".$response_data['capital_city']['elevation']."</p>";
        $html .= "<p>Latitude: ".$response_data['capital_city']['latitude']."</p>";
        $html .= "<p>Longitude: ".$response_data['capital_city']['longitude']."</p>";
        $html .= "<p>Population: ".$response_data['capital_city']['population']."</p>";

        $html .= "<h3>Places near Capital City</h3>";
        $html .= "<table border='1'>";
        $html .= "<tr><th>Name</th><th>Region</th><th>Region Code</th><th>Latitude</th><th>Longitude</th><th>Population</th></tr>";
        foreach ($response_data['places_near_city'] as $city) {
            $html .= "<tr>";
            $html .= "<td>".$city['name']."</td>";
            $html .= "<td>".$city['region']."</td>";
            $html .= "<td>".$city['region_code']."</td>";
            // $html .= "<td>".$city['elevation']."</td>";
            $html .= "<td>".$city['latitude']."</td>";
            $html .= "<td>".$city['longitude']."</td>";
            $html .= "<td>".$city['population']."</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";

        return $html;
    }
}
