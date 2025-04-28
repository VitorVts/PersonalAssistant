<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Config\TelegramConnection;
use App\Contracts\ConnectionInterface;

class TelegramBot
{
    private Client $client;
    private TelegramConnection $conn;

    public function __construct(ConnectionInterface $connection)
    {
      $this->client = new Client();
      $this->conn = $connection;
    }


    public function sendMessage(int|string $chatId, string $text): void
    {
      try {
        $this->client->post($this->conn->getApiUrl() . 'sendMessage', [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => $text,
            ],
        ]);
      } catch (\GuzzleHttp\Exception\GuzzleException $e) {
        echo 'Erro ao enviar mensagem: ' . $e->getMessage();
      }
    }

}
