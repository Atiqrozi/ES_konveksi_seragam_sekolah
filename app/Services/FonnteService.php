<?php

namespace App\Services;

use GuzzleHttp\Client;

class FonnteService
{
    protected $client;
    protected $token;

    public function __construct()
    {
        $this->client = new Client();
        $this->token = env('FONNTE_API_TOKEN');
    }

    public function sendMessage($target, $message, $file = null, $filename = null, $countryCode = '62')
    {
        $url = 'https://api.fonnte.com/send';
        
        $data = [
            'target' => $target,
            'message' => $message,
            'countryCode' => $countryCode,
        ];

        if ($file) {
            $data['file'] = fopen($file, 'r');
            if ($filename) {
                $data['filename'] = $filename;
            }
        }

        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => $this->token,
            ],
            'multipart' => array_map(function ($key, $value) {
                return [
                    'name' => $key,
                    'contents' => $value
                ];
            }, array_keys($data), $data),
        ]);

        return json_decode($response->getBody(), true);
    }
}
