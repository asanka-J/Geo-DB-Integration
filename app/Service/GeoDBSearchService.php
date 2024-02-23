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

        $capitalCityDetails=$this->geoDBCitiesService->findCityByCountryAndName($country,$capital_city);
        $capitalCityDetails = $this->getData($capitalCityDetails)[0];
        $capital_city_id = $capitalCityDetails->id;
        $nearby_cities = $this->geoDBCitiesService->getNearbyCities($capital_city_id);

        $response_data = [
            'country' => $country_details,
            'capital_city' => $capitalCityDetails,
            'nearby_cities' => $nearby_cities,
        ];

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
                "elevation"=>$capitalCityDetails->elevation,
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
                'elevation' => $city->elevation,
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
            "currency"=>$country_details->currency,
            "flag"=>$country_details->flagImageUri,
        ];
    }

    public function formatResponseToHtml($response_data)
    {
        $html = "<h1>Country: ".$response_data['country']['name']."</h1>";
        $html .= "<h2>Capital City: ".$response_data['capital_city']['name']."</h2>";
        $html .= "<h3>Places near Capital City</h3>";
        $html .= "<ul>";
        foreach ($response_data['places_near_city'] as $city) {
            $html .= "<li>".$city['name']."</li>";
        }
        $html .= "</ul>";
        return $html;
    }
}
