<?php

namespace Ivanpytlyak\TelegramBot\Service;  // из composer.json первая часть

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;

class TelegramBotClient
{
    private const API = 'https://api.telegram.org/bot';
    private const SEND_MESSAGE = 'sendMessage';
    private const GET_UPDATES = 'getUpdates';

    private string $token;
    private HttpClientInterface $httpClient;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->httpClient = HttpClient::create();
    }

    public function getUpdates(): array
    {
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            self::API . $this->token . '/' . self::GET_UPDATES
        );

        return $response->toArray();
    }

    public function sendMessage(
        int $chatId,
        string $text
    ): array {
        $response = $this->httpClient->request(
            Request::METHOD_GET,
            self::API . $this->token . '/' . self::SEND_MESSAGE . '?chat_id=' . $chatId . '&text=' . $text
        );

        return $response->toArray();
    }
}
