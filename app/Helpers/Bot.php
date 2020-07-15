<?php

namespace App\Helpers;

use Telegram\Bot\Api;


class Bot
{

    public static function sendMsg($msg)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $telegram = new Api($token);
        $params = [
            'chat_id'              => env('ADMIN_CHAT_ID') ? env('ADMIN_CHAT_ID') : '485750575',
            'text'           => $msg . ': ' . '<a>http://localhost:8000/dashboard</a>',
        ];
        $response = $telegram->sendMessage($params);
    }
}
