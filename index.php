<?php
require_once('./vendor/autoload.php');

use Ivanpytlyak\TelegramBot\Service\TelegramBotClient;

$telegramBotClient = new TelegramBotClient('6236144671:AAFPnH5fQUAlZ9Pv1ov5DcXo4RCTG-8SV-M');



$arr = $telegramBotClient->getUpdates();

$dsn = 'mysql:host=localhost;port=3306;dbname=telegram_bot';
$pdo = new PDO($dsn, 'telegram_user', 'pass');

foreach ($arr['result'] as $result) {
    $message = $result['message'];
    $id = $message['from']['id'];
    $first_name = $message['from']['first_name'];
    $message_id = $message['message_id'];
    $text = $message['text'];
    // echo "id: $id, first_name: $first_name, message_id: $message_id, text: $text\n";
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM messages WHERE message_id = ?"); // проверка на уникальность
    $stmt->execute(array($message_id));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // print_r($result);
    if ($result['COUNT(*)'] == 0) {
        // message_id не существует в базе данных, выполняем INSERT
        $stmt = $pdo->prepare("INSERT INTO messages (message_id, first_name, text) VALUES (?,?,?)");
        $stmt->execute(array($message_id, $first_name, $text));
    } else {
        // message_id уже существует в базе данных, пропускаем импорт этой строки
        continue;
    }
}




// print_r($telegramBotClient->getUpdates()); // получаем переписку
// print_r($telegramBotClient->sendMessage(734435386, 'иди спать')); // отправляем текст 734435386- таня / 1123756923- мой






// $telegramBotClient->sendFile('C:\Users\user\Desktop\Новаяпапка\Книга1.xlsx', 1123756923, 'Сработало?');// нет

// require_once ('./vendor/autoload.php');

// use Pashkevichsd\TelegramBotClient\Service\TelegramBotClient;

// $telegramBotClient = new TelegramBotClient('ВАШ ТОКЕН');

// print_r($telegramBotClient->getUpdates()['result'][0]['message']['chat']['id']);

// print_r($telegramBotClient->sendMessage((int) $telegramBotClient->getUpdates()['result'][0]['message']['chat']['id'], 'hello world 123 !!!'));

// while (true) {
//     sleep(5);
//     print_r($telegramBotClient->getUpdates());
// }
