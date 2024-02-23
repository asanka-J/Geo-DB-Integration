<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\GeoDBSearchService;

use App\Traits\ApiResponseTrait;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;


class GeoDBSearchController extends Controller
{
    use ApiResponseTrait;
    private $geoDBSearchService;

    public function __construct(GeoDBSearchService $geoDBSearchService)
    {
        $this->geoDBSearchService = $geoDBSearchService;

    }

    public function searchByCountry(Request $request){

        $validatedData = $request->validate([
            'country' => 'required|string',
        ]);

        try {
            $country = $validatedData['country'];
            $apiResponse = $this->geoDBSearchService->searchByCountry($country);
            $response_data = $this->getData($apiResponse);
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
