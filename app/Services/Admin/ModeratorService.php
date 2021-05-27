<?php
namespace App\Services\Admin;

use Exception;
use App\Client\JsonRpcClient;

class ModeratorService
{
    private $client;

    public function __construct()
    {
        $this->client = new JsonRpcClient();
    }

    public function getModeratorCreditnails() {
        return [
            'login' => 'chekapps.com@gmail.com',
            'password' => 'HvJTP.3m,F5KtnH',
        ];
    }

    public function getModerator()
    {
        return $this->client->send('User/login', $this->getModeratorCreditnails());
    }

    public function getToken()
    {
        try {
            $moderator = $this->getModerator();

            if(isset($moderator->error)) {
                throw new Exception($moderator->error, $moderator->code);
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
