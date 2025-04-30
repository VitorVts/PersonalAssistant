<?php

namespace App\Controllers;

use PDO;

class TransacaoController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function registrarTransacao(int $telegramId,string $name, float $valor, string $categoria, string $tipo = 'saida'): void
    {
        $userId = $this->getOuCriaUsuario($telegramId,$name);

        $stmt = $this->pdo->prepare("
            INSERT INTO transactions (user_id, type, value, category)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$userId, $tipo, $valor, $categoria]);
    }

    private function getOuCriaUsuario(int $telegramId,$name): int
    {
        $stmt = $this->pdo->prepare("
            SELECT id FROM users WHERE telegram_id = ?
        ");
        $stmt->execute([$telegramId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return (int) $user['id'];
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO users (telegram_id, nome)
            VALUES (?, ?)
        ");
        $stmt->execute([$telegramId,$name]);
        return (int) $this->pdo->lastInsertId();
    }
}
