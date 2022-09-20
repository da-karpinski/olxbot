<?php
 require_once "classes/autoload.php";

$database = new Database();

$olx_api_response = file_get_contents($database->getConfig("olx_api_endpoint"));

$olx_api_response = json_decode($olx_api_response);

foreach($olx_api_response->data as $item){
    $offer = new Offer();
    $offer->setOfferId($item->id);

}
