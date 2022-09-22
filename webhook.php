<?php
require_once "classes/autoload.php";

$database = new Database();
$telegram = new Telegram();
$offer = new Offer();

$request = file_get_contents("php://input");
$headers = getallheaders();
$telegram_webhook_secret = $database->getConfig("telegram_webhook_secret");

if($headers["X-Telegram-Bot-Api-Secret-Token"] !== $telegram_webhook_secret){
    exit;
}


$json = json_decode($request);
$message = $json->message->text;
$command = explode(" ", $message);

$html_breaks = ["<br />","<br>","<br/>"];

if($command[0] === "/details"){
    $offer->getOffer(intval($command[1]));

    $offer_id = $offer->getOfferId();
    $offer_title = $offer->getTitle();
    $offer_created = $offer->getCreatedAt();
    $offer_refreshed = $offer->getRefreshedTo();
    $offer_seen = $offer->getLastSeen();
    $offer_description = $offer->getDescription();
    $offer_price = $offer->getPrice();
    $offer_rent = $offer->getRent();
    $offer_url = $offer->getUrl();

    $offer_description = str_ireplace($html_breaks, "", $offer_description);

    $message = "Szczegóły ogłoszenia $offer_id:\n
Tytuł:\n$offer_title\n
Utworzono:\n$offer_created\n
Ważne do:\n$offer_refreshed\n
Ostanio widziane (przez bota):\n$offer_seen\n
Opis:\n
**********POCZĄTEK OPISU**********\n
$offer_description\n
***********KONIEC OPISU***********\n
Cena: $offer_price zł\n
Czynsz (dodatkowo): $offer_rent zł\n
Informacje kontaktowe:
      Imię: !TODO!
      Numer telefonu: !TODO!\n
Link do ogłoszenia:\n$offer_url\n";

    $telegram->replyMessage($message);
}
