<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function processSuccessResponse($response)
    {
        // Modify the api format needed for later use
        return [
            'data' => $response,
            'errors' => [],
            'status' => 200,
        ];
    }

    public function handleException($e,$status_code)
    {
        // On exception record a log
        \Log::error('Error while fetching data: ' . $e->getMessage());


        $errorMessage = 'An error occurred while processing your request.';

        return [
            'data' => [],
            'errors' => $e->getMessage(),
            'status' => $status_code,
        ];
    }

    // Extract the data from the response
    public function getData($response){
        return $response->data;
    }
}
