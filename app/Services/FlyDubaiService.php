<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class FlyDubaiService
{

    private function getHttpOptions()
    {
        if (App::environment('local')) {
            return ['verify' => false];
        }

        return [];
    }

    public function callAPI($url, $data, $needJson = true)
    {
        $response = Http::timeout(300)->withOptions($this->getHttpOptions())->withHeaders([
            'Accept-Encoding' => 'gzip, deflate',
            'Authorization' => 'Bearer ' . getToken()
        ])->post(env('FLY_DUBAI_API_URL') . $url, $data);


        if ($response->status() == 200) {
            if ($needJson) {
                return $response->json();
            }

            return $response->getBody()->getContents();
        }

        return null;
    }

    // public function bookFlight($url, $data, $needJson = true)
    // {
    //     return $this->callAPI($url, $data, $needJson = true);
    // }
}
