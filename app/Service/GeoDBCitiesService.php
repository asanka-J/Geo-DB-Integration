<?php

namespace App\Service;
use App\Service\GeoDBAbstractBaseService;

/**
 * Service class for interacting with the GeoDB Cities API.
 */
class GeoDBCitiesService extends GeoDBAbstractBaseService
{
    public function getCitiesByCountry($request_data)
    {
        $url = "{$this->geoApiBase}/geo/cities";
        $options = [
            'headers' => [
                'X-RapidAPI-Key' => $this->geoApiKey,
            ],
            'query' => [
                'countryIds' => $request_data['country'],
                'offset' => isset($request_data['offset'])?$request_data['offset']:'',
                'limit' => isset($request_data['limit']) && $request_data['limit'] < $this->geoApiLimit ? $request_data['limit'] : 10,
            ],
        ];
        return $this->makeRequest('GET', $url, $options);
    }

    public function getCityListByCountry($country)
    {
        $url = "{$this->geoApiBase}/geo/cities";
        $options = [
            'headers' => [
                'X-RapidAPI-Key' => $this->geoApiKey,
            ],
            'query' => [
                'countryIds' => $country
            ],
        ];
        return $this->makeRequest('GET', $url, $options);
    }

    public function getCityDetails($city_id)
    {
        $url = "{$this->geoApiBase}/geo/cities/{$city_id}";
        $options = [
            'headers' => [
                'X-RapidAPI-Key' => $this->geoApiKey,
            ],
        ];
        return $this->makeRequest('GET', $url, $options);
    }

    public function getNearbyCities($city_id, $radius = 100)
    {
        $url = "{$this->geoApiBase}/geo/cities/{$city_id}/nearbyCities";
        $options = [
            'headers' => [
                'X-RapidAPI-Key' => $this->geoApiKey,
            ],
            'query' => [
                'radius' => $radius,
            ],
        ];
        return $this->makeRequest('GET', $url, $options);
    }

    public function findCityByCountryAndName($country,$capital_city_name)
    {
        $url = "{$this->geoApiBase}/geo/cities";
        $options = [
            'headers' => [
                'X-RapidAPI-Key' => $this->geoApiKey,
            ],
            'query' => [
                'countryIds' => $country,
                'namePrefix'=> $capital_city_name
            ],
        ];
        return $this->makeRequest('GET', $url, $options);
    }
}
