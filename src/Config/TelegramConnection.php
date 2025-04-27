<?php

use Dotenv\Dotenv;


class TelegramConnection
{
    private string $apiurl;
    private string $token;
    public function __construct()
    {
        if (!isset($_ENV['TELEGRAM_BOT_TOKEN'])) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();
        }

        $this->token = $token ?? $_ENV['TELEGRAM_BOT_TOKEN'];
        $this->apiurl = $_ENV['TELEGRAM_API_URL'] . $this->token . '/';
    }

    public function getConnection(): string
    {
        return $this->apiurl;
    }
}