<?php
namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class RecaptchaService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function check($token, $ip)
    {
        try {
            if(!config('recaptcha.enabled')) {
                throw new Exception('Google Recaptcha отключена', 404);
            }

            $response = $this->client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret'   => config('recaptcha.secret'),
                    'response' => $token,
                    'remoteip' => $ip,
                ],
            ]);

            $response = json_decode((string) $response->getBody(), true);

            return (bool) $response['success'];
        } catch (Exception $exception) {
            return (object) [
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ];
        }
    }
}

