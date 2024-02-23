<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

/**
 * Base class for interacting with the GeoDB API.
 */
abstract class GeoDBAbstractBaseService
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
}
