<?php
namespace App\Client;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class JsonRpcClient
{
    const JSON_RPC_VERSION = '2.0';

    const METHOD_URI = 'data';

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'X-API-key' => env('APP_FINIKO_API_KEY'),
                'Accept-Language' => 'en',
                'Access-Control-Allow-Headers' => 'Authorization',
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE',
                'Access-Control-Allow-Origin' => '*',
            ],
            'base_uri' => env('APP_FINIKO_API_URL'),
            'verify' => false,
        ]);
    }

    public function send($method, array $params)
    {
        $response = $this->client
            ->post(self::METHOD_URI, [
                RequestOptions::JSON => [
                    'jsonrpc' => self::JSON_RPC_VERSION,
                    'id' => time(),
                    'method' => $method,
                    'params' => $params
                ]
            ])->getBody()->getContents();
        dd(json_decode($response, true));
        return json_encode($response, true);
    }
}
