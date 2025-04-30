<?php

require 'vendor/autoload.php';

use App\Controllers\WebhookController;
use App\Config\Database;
use App\Controllers\TransacaoController;

$controller = new WebhookController();
$controller->handle();


$db = new Database();
$pdo = $db->connect();

$transacaoController = new TransacaoController($pdo);

// Teste 1: Registrar uma transação
// $transacaoController->registrarTransacao(123456789, 99.90, 'Alimentação', 'saida');
