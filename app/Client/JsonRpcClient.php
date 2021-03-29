<?php

namespace App\Client;

use App\Exceptions\JsonRpcException;
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
        try {
            $response = $this->client
                ->post(self::METHOD_URI, [
                    RequestOptions::JSON => [
                        'jsonrpc' => self::JSON_RPC_VERSION,
                        'id' => time(),
                        'method' => $method,
                        'params' => $params
                    ]
                ])->getBody()->getContents();
            $resp = json_decode($response);

            if (isset($resp->error)) {
                $error = $resp->error;
                throw new JsonRpcException($error->message, $error->code);
            } else {
                return $resp->result;
            }
        } catch (JsonRpcException $exception) {
            return (object) [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'error' => $exception->getCode()
            ];
        }
    }
}
