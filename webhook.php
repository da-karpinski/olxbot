<?php
require_once "classes/autoload.php";

$database = new Database();
$telegram = new Telegram();

$request = file_get_contents("php://input");
$headers = getallheaders();
$telegram_webhook_secret = $database->getConfig("telegram_webhook_secret");

if($headers["X-Telegram-Bot-Api-Secret-Token"] !== $telegram_webhook_secret){
    exit;
}


$json = json_decode($request);
$message = $json->message->text;
$command = explode(" ", $message);

if($command[0] === "/details"){
    $telegram->replyMessage($command[1]);
}
