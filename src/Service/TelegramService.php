<?php


namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class TelegramService
{
    private string $botToken;
    private string $chatId;
    private HttpClientInterface $client;

    public function __construct(
        HttpClientInterface $client,
        string $botToken,
        string $chatId
    ) {
        $this->client = $client;
        $this->botToken = $botToken;
        $this->chatId = $chatId;
    }

    public function sendMessage(string $message): bool
    {
        $url = sprintf('https://api.telegram.org/bot%s/sendMessage', $this->botToken);

        try {
            $response = $this->client->request('POST', $url, [
                'json' => [
                    'chat_id' => $this->chatId,
                    'text' => $message,
                    'parse_mode' => 'HTML',
                ],
            ]);

            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            return false;
        }
    }

}
