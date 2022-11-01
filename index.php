<?php
 require_once "classes/autoload.php";

$database = new Database();
$telegram_api = new Telegram();

$olx_api_endpoints = json_decode($database->getConfig("olx_api_endpoints"));

foreach($olx_api_endpoints as $endpoint){

    $response = json_decode(file_get_contents($endpoint));

    foreach($response->data as $item){
        $offer = new Offer();
        $offer->setOfferId($item->id);
        $offer->setTitle($item->title);
        $offer->setCreatedAt($item->created_time);
        $offer->setRefreshedTo($item->valid_to_time);
        $offer->setLastSeen(null);
        $offer->setDescription($item->description);
        $offer->setPrice($offer->getOfferPrice($item));
        $offer->setRent($offer->getOfferRent($item));
        $offer->setUrl($item->url);
        $offer->setCategoryId($item->category->id);

        if($database->saveOrUpdate($offer)){
            $telegram_api->sendMessage($offer);
        }
    }
}