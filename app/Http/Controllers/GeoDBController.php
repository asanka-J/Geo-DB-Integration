<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\GeoDBCountriesService;
use App\Traits\ApiResponseTrait;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;


class GeoDBController extends Controller
{
    use ApiResponseTrait;
    private $geoDBCountriesService;

    public function __construct(GeoDBCountriesService $geoDBCountriesService)
    {
        $this->geoDBCountriesService = $geoDBCountriesService;
    }

    public function getCountryList(Request $request){

        try {
            $apiResponse = $this->geoDBCountriesService->getCountryList();
            $response_data = $this->processSuccessResponse($apiResponse);
        }catch (\Exception $e) {
            $error_code = 500;
            if ($e instanceof ClientException || $e instanceof ServerException || $e instanceof RequestException) {
                $error_code = $e->getResponse()->getStatusCode();
            }

            $response_data = $this->handleException($e, $error_code);
        }
        return response()->json($response_data);
    }

    public function getCountryDetails(Request $request){

        $validatedData = $request->validate([
            'country_id' => 'required|string',
        ]);


        try {
            $country_id = $validatedData['country_id'];
            $apiResponse = $this->geoDBCountriesService->getCountryDetails($country_id);
            $response_data = $this->processSuccessResponse($apiResponse);
        }catch (\Exception $e) {
            $error_code = 500;
            if ($e instanceof ClientException || $e instanceof ServerException || $e instanceof RequestException) {
                $error_code = $e->getResponse()->getStatusCode();
            }

            $response_data = $this->handleException($e, $error_code);
        }
        return response()->json($response_data);

    }


}
