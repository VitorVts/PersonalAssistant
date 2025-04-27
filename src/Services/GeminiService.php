<?php

namespace App\Services;

use App\Config\GeminiConnection;

class GeminiService
{
    private $connection;

    public function __construct(GeminiConnection $connection)
    {
        $this->connection = $connection;
    }

    public function enviarMensagem(string $mensagem)
    {
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $mensagem],
                    ],
                ],
            ],
        ];

        try {
            $response = $this->connection->getHttpClient()->post(
                $this->connection->getApiUrl(),
                [
                    'headers' => ['Content-Type' => 'application/json'],
                    'json' => $data,
                ]
            );

            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            if ($statusCode >= 200 && $statusCode < 300) {
                return $this->processarResposta($body);
            } else {
                return "Erro na requisição HTTP: Status Code " . $statusCode . ", Body: " . $body;
            }

        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return "Erro Guzzle: " . $e->getMessage();
        }
    }

    private function processarResposta(string $response)
    {
        $responseData = json_decode($response, true);

        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            return trim($responseData['candidates'][0]['content']['parts'][0]['text']);
        } elseif (isset($responseData['error']['message'])) {
            return "Erro da API: " . $responseData['error']['message'];
        } else {
            return "Resposta da API não reconhecida.";
        }
    }
}
