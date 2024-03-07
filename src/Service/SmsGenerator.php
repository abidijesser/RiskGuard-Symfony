<?php
// src/Service/SmsGenerator.php
namespace App\Service;

use Twilio\Rest\Client;

class SmsGenerator
{
    private $accountSid;
    private $authToken;
    private $fromNumber;

    public function __construct(string $accountSid, string $authToken, string $fromNumber)
    {
        $this->accountSid = $accountSid;
        $this->authToken = $authToken;
        $this->fromNumber = $fromNumber;
    }

    public function sendSms(string $number, string $name, string $text)
    {
        // Création du client Twilio
        $client = new Client($this->accountSid, $this->authToken);

        // Construction du message
        $message = "{$name} vous a envoyé le message suivant: {$text}";

        // Envoi du SMS
        $client->messages->create(
            $number,
            [
                'from' => $this->fromNumber,
                'body' => $message,
            ]
        );
    }
}