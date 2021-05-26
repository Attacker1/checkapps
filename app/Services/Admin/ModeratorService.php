<?php
namespace App\Services\Admin;

use Exception;
use App\Client\JsonRpcClient;

class ModeratorService
{
    private $client;

    public function __construct(JsonRpcClient $client)
    {
        $this->client = $client;
    }

    public function getModerator()
    {
        $moderator = $this->client->send('User/login', [
            'login' => 'chekapps.com@gmail.com',
            'password' => 'HvJTP.3m,F5KtnH',
        ]);

        try {
            if(isset($moderator->error)) {
                throw new Exception($moderator->message, $moderator->code);
            }

            return $moderator;
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }

    public function getToken()
    {
        $moderator = $this->getModerator();

        try {
            if(isset($moderator->error)) {
                throw new Exception($moderator->message, $moderator->code);
            }

            return $moderator->token_id;
        } catch (Exception $exception) {
            return (object)[
                'code' => $exception->getCode(),
                'error' => $exception->getMessage(),
            ];
        }
    }
}
