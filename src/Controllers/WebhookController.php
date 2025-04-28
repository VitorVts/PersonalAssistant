<?php

namespace App\Controllers;

use App\Config\TelegramConnection;
use App\Config\GeminiConnection;
use App\Services\TelegramBot;
use App\Services\GeminiService;

class WebhookController
{
    private TelegramBot $bot;
    private GeminiService $gemini;

    public function __construct()
    {
        $connection = new TelegramConnection();
        $geminiConn = new GeminiConnection();
        $this->bot = new TelegramBot($connection);
        $this->gemini = new GeminiService($geminiConn);
    }

    public function handle()
    {
        try {
            $update = file_get_contents('php://input');
            $update = json_decode($update, true);

            if (isset($update['message'])) {
                $chatId = $update['message']['chat']['id'];
                $text = $update['message']['text'];

                $response = $this->gemini->enviarMensagem($text);
                
                if (empty($response)) {
                    $this->bot->sendMessage($chatId, 'Desculpe, algo deu errado. Tente novamente!');
                    return;
                }
                $this->bot->sendMessage($chatId, $response);
               
            }
        } catch (\Exception $e) {
            error_log("Erro ao processar o webhook: " . $e->getMessage());
            http_response_code(500);
            echo "Erro ao processar o webhook.";
            $this->bot->sendMessage($chatId, 'Erro inesperado. Tente novamente mais tarde.');
        }
    }

}
