<?php

namespace App\Config;

use App\Contracts\ConnectionInterface;
use Dotenv\Dotenv;

class TelegramConnection implements ConnectionInterface
{
    private string $apiurl;
    private string $token;
    public function __construct()
    {
        if (!isset($_ENV['TELEGRAM_BOT_TOKEN'])) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();
        }
        $this->token = $_ENV['TELEGRAM_BOT_TOKEN'];
        $this->apiurl = $_ENV['TELEGRAM_API_URL'] . $this->token . '/';
    }

    public function getApiUrl(): string
    {
        return $this->apiurl;
    }
}
