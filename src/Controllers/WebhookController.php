<?php

namespace App\Controllers;

use App\Services\TelegramBot;

class WebhookController
{
  private TelegramBot $bot;

  public function __construct()
  {
    $this->bot = new TelegramBot();
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
