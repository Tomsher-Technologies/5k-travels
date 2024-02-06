<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class YasinService
{

    private function getHttpOptions()
    {
        if (App::environment('local')) {
            return ['verify' => false];
        }

        return [];
    }

    public function get($url, $data, $needJson = true)
    {
        try {

            $cred = array(
                'Username' => env('YASEIN_USERNAME'),
                'Password' => env('YASIN_PASSWORD'),
            );

            $data = array_merge($data, $cred);

            $response = Http::timeout(300)->withOptions($this->getHttpOptions())->get(env('YASEIN_API_URL') . $url, $data);

            // dd($response );

            // dd([env('YASEIN_API_URL') . $url, http_build_query($data)]);

            if ($response->failed()) {
                dd('failed');
                return null;
            }

            if ($response->status() == 200) {
                if ($needJson) {
                    return $response->json();
                }

                return $response->getBody()->getContents();
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            dd($e);
            return null;
        } catch (RequestException $e) {
            dd($e);
            return null;
        }

        return null;
    }
    public function post($url, $data, $needJson = true)
    {
        try {
            $response = Http::timeout(1)->withOptions($this->getHttpOptions())->withHeaders([
                'Accept-Encoding' => 'gzip, deflate'
            ])->post(env('YASEIN_API_URL') . $url, $data);

            if ($response->failed()) {
                return null;
            }

            if ($response->status() == 200) {
                if ($needJson) {
                    return $response->json();
                }

                return $response->getBody()->getContents();
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return null;
        } catch (RequestException $e) {
            return null;
        }

        return null;
    }
}
