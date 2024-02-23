<?php

namespace App\Service;

use App\Service\GeoDBAbstractBaseService;

class GeoDBCountriesService extends GeoDBAbstractBaseService
{
    public function getCountries($offset)
    {
        $url = "{$this->geoApiBase}/geo/countries?limit=10&offset={$offset}";
        $options = [
            'headers' => [
                'X-RapidAPI-Key' => $this->geoApiKey,
            ],
        ];
        return $this->makeRequest('GET', $url, $options)->data;
    }

    public function getCountryList()
    {
        $countries = [];
        for ($offset = 0; $offset <= 1; $offset++) {
            $countries=array_merge($countries,$this->getCountries($offset));
            sleep(2); // added sleeping time to avoid rate limit on the API
        }
        return $countries;
    }

    public function getCountryDetails($country)
    {
        $url = "{$this->geoApiBase}/geo/countries/{$country}";
        $options = [
            'headers' => [
                'X-RapidAPI-Key' => $this->geoApiKey,
            ],
        ];
        return $this->makeRequest('GET', $url, $options);
    }
}
