<?php

namespace App\Controllers;

use App\Config\TelegramConnection;
use App\Services\TelegramBot;

class WebhookController
{
  private TelegramBot $bot;

  public function __construct()
  {
    $connection = new TelegramConnection();
    $this->bot = new TelegramBot($connection);
  }

  public function handle()
  {
    $update = file_get_contents('php://input');
    $update = json_decode($update,true);
    if (isset($update['message']))
    {
      $chatId = $update['message']['chat']['id'];
      $text = $update['message']['text'];

      $response = "Você disse: " . $text;
      $this->bot->sendMessage($chatId,$response);
    }
  }

}
