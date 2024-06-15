<?php

namespace App\Services\Api;

use GuzzleHttp\Client as GuzzleClient;
use App\Helpers\Settings;
use MongoDB\Driver\Exception\Exception;

class TermiApi
{

    use Settings;

    private const BASE_URL = "https://api.ng.termii.com/api";

    private function getClient()
    {
        return new GuzzleClient(['timeout' => 20]);
    }

    public function sendVerificationSms($phoneNumber, $verificationCode)
    {
        $url = self::BASE_URL . "/sms/send";
        $body = [
            "to" => $phoneNumber,
            "from" => $this->getSmsFromName(),
            "sms" => "Welcome to SolveIt : ". $verificationCode,
            "type" => "plain",
            "channel" => "dnd",
            "api_key" => $this->getSmsApiKey()
        ];

        $response = $this->getClient()->post($url, [
            'headers' => $this->getHeaders(),
            'json' => $body
        ]);

        return json_decode($response->getBody()->getContents());
    }

    private function getHeaders(): array
    {
         return [
            'Content-Type' => "application/json"
        ];
    }
}
