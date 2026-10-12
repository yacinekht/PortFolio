<?php

namespace App\Service;

class TelegramService
{
    public function sendContactMessage(string $name, string $email, string $content): bool
    {
        $message = sprintf(
            "💼 *Nouveau message de contact (Portfolio)*\n\n*De :* %s\n*Email :* %s\n*Message :*\n%s",
            $name,
            $email,
            $content
        );

        return $this->sendMessage($message);
    }
}
