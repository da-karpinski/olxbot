<?php

class Telegram
{
    private Database $database;
    private string $api_url;
    private int $chat_id;
    private string $api_token;

    public function __construct(){
        $this->database = new Database();
        $this->api_url = $this->database->getConfig("telegram_api_url");
        $this->chat_id = $this->database->getConfig("telegram_chat_id");
        $this->api_token = $this->database->getConfig("telegram_api_token");
    }

    public function sendMessage(Offer $offer){
        $offer_id = $offer->getOfferId();
        $title = $offer->getTitle();
        $price = $offer->getPrice();
        $rent = $offer->getRent();
        $url = $offer->getUrl();

        $message = "📣 NOWE OGŁOSZENIE: \"$title\" za $price zł + $rent zł czynszu. Link do ogłoszenia: $url\n[ID: $offer_id]";

        $curl_body = [
            "chat_id" => $this->chat_id,
            "text" => $message
        ];

        $this->curlRequest("/sendMessage", null, $curl_body);
    }

    public function replyMessage(string $message){

        $curl_body = [
            "chat_id" => $this->chat_id,
            "text" => $message
        ];

        $this->curlRequest("/sendMessage", null, $curl_body);
    }

    private function curlRequest(string $uri, ?array $headers, ?array $body){
        $link = $this->api_url . $this->api_token . $uri;
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if($headers){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        if($body){
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($body));
        }

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}