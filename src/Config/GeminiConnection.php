<?php

namespace App\Config;

use App\Contracts\ConnectionInterface;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

class GeminiConnection implements ConnectionInterface
{
    private $apiKey;
    private $httpClient;
    private $url;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        
        $this->apiKey = $_ENV['GOOGLE_API_KEY'];
        $this->httpClient = new Client();
        $this->url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $this->apiKey;
    }

    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    public function getApiUrl(): string
    {
        return $this->url;
    }
}
