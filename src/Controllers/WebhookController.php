<?php

namespace App\Controllers;

use App\Config\TelegramConnection;
use App\Config\GeminiConnection;
use App\Services\TelegramBot;
use App\Services\GeminiService;
use App\Controllers\TransacaoController;
use App\Config\Database;

class WebhookController
{
    private TelegramBot $bot;
    private GeminiService $gemini;
    private TransacaoController $transacaoController;

    public function __construct()
    {
        $connection = new TelegramConnection();
        $geminiConn = new GeminiConnection();
        $this->bot = new TelegramBot($connection);
        $this->gemini = new GeminiService($geminiConn);

        $pdo = (new Database())->connect();
        $this->transacaoController = new TransacaoController($pdo);
    }

    public function handle()
    {
        try {
    $update = file_get_contents('php://input');
    $update = json_decode($update, true);

    if (isset($update['message'])) {
        $chatId = $update['message']['chat']['id'];
        $firstName = $update['message']['from']['first_name'];
        $telegramId = $update['message']['from']['id'];
        $text = trim($update['message']['text']);

        // if (str_starts_with($text, '/add')) {
        //     $parts = explode(' ', $text);
        //     if (count($parts) < 3) {
        //         $this->bot->sendMessage($chatId, 'Uso correto: /add <valor> <categoria>');
        //         return;
        //     }

        //     $valor = floatval(preg_replace('/[^\d.]+/', '', $parts[1]));
        //     $categoria = strtolower(trim($parts[2]));

        //     $this->transacaoController->registrarTransacao($telegramId, $firstName, $valor, $categoria);
        //     $this->bot->sendMessage($chatId, "Registrado: R$ {$valor} em {$categoria}. 🧾");
        //     return;
        // }

        $this->bot->sendMessage($chatId, 'Rasgando seu dinheiro, um momento...');
        $dados = $this->gemini->interpretarTransacao($text);

        if ($dados && isset($dados['valor'], $dados['categoria'])) {
            $valor = floatval(preg_replace('/[^\d.]+/', '', $dados['valor']));
            $categoria = strtolower(trim($dados['categoria']));
            $mensagem = $dados['mensagem'] ?? "Registrado: R$ {$valor} em {$categoria}.";

            $this->transacaoController->registrarTransacao($telegramId,$firstName, $valor, $categoria);
            $this->bot->sendMessage($chatId, $mensagem);
        } else {
            $this->bot->sendMessage($chatId, 'Desculpe, não entendi sua mensagem.');
        }
    }
               
        } catch (\Exception $e) {
            error_log("Erro ao processar o webhook: " . $e->getMessage());
            http_response_code(500);
            echo "Erro ao processar o webhook.";
            $this->bot->sendMessage($chatId, 'Erro inesperado. Tente novamente mais tarde.');
        }
    }

}
