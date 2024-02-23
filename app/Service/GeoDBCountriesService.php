<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class GeoDBCountriesService
{
    protected $httpClient;
    protected $geoApiBase;
    protected $geoApiKey;
    protected $geoApiLimit;


    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->geoApiBase = config('services.geodb.endpoint');
        $this->geoApiKey = config('services.geodb.api_key');
        $this->geoApiLimit = config('services.geodb.limit');
    }


    protected function makeRequest(string $method, string $url, array $options = [])
    {
        try {
            $response = $this->httpClient->request($method, $url, $options);
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            $errorMessage = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'Unknown error';
            Log::error("Request failed: {$errorMessage}");
            throw new \Exception("Failed to fetch data: {$errorMessage}");
        }
    }

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
            sleep(2);
        }
        // dd($countries);

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
