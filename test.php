<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Services\TelegramBot;

$bot = new TelegramBot();

// Coloque aqui o seu chat_id (pode ser seu ID pessoal ou o de um grupo)
$chatId = 'SEU_CHAT_ID';
$text = 'Olá, este é um teste do meu bot! 🚀';

$bot->sendMessage($chatId, $text);
