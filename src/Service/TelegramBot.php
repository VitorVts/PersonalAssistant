<?php

namespace App\Service;

use GuzzleHttp\Client;
use App\Config\TelegramConnection;

class TelegramBot
{
    private string $apiurl;
    private Client $client;

    public function __construct($token)
    {
      
    }

}