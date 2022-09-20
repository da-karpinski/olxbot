<?php
 require_once "classes/autoload.php";

$database = new Database();

$olx_api_response = file_get_contents($database->getConfig("olx_api_endpoint"));

$olx_api_response = json_decode($olx_api_response);

foreach($olx_api_response->data as $item){
    $offer = new Offer();
    $offer->setOfferId($item->id);
    $offer->setTitle($item->title);
    $offer->setCreatedAt($item->created_time);
    $offer->setRefreshedTo($item->valid_to_time);
    $offer->setLastSeen();
    $offer->setDescription($item->description);
    $offer->setPrice($offer->getOfferPrice($item));
    $offer->setRent($offer->getOfferRent($item));
    $offer->setUrl($item->url);

    $database->saveOrUpdate($offer);
}