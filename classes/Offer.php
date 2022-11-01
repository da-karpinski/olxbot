<?php

class Offer
{
    private int $offer_id;
    private string $title;
    private string $created_at;
    private string $refreshed_to;
    private string $last_seen;
    private string $description;
    private float $price;
    private float $rent;
    private string $url;
    private int $category_id;

    private Database $database;

    public function __construct(){
        $this->database = new Database();
    }

    //setters
    public function setOfferId(int $offer_id){
        $this->offer_id = $offer_id;
    }

    public function setTitle(string $title){
        $this->title = $title;
    }

    public function setCreatedAt(string $created_at){
        $this->created_at = $created_at;
    }

    public function setRefreshedTo(string $refreshed_to){
        $this->refreshed_to = $refreshed_to;
    }

    public function setLastSeen(?string $last_seen){
        if($last_seen){
            $this->last_seen = $last_seen;
        }else{
            $this->last_seen = date("Y-m-d H:i:s");
        }
    }

    public function setDescription(string $description){
        $this->description = $description;
    }

    public function setPrice(?float $price){
        if($price){
            $this->price = $price;
        }else{
            $this->price = 0;
        }

    }

    public function setRent(?float $rent){
        if($rent){
            $this->rent = $rent;
        }else{
            $this->rent = 0;
        }

    }

    public function setUrl(string $url){
        $this->url = $url;
    }

    public function setCategoryId(int $category_id){
        $this->category_id = $category_id;
    }

    //getters
    public function getOfferId(): int
    {
        return $this->offer_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getRefreshedTo(): string
    {
        return $this->refreshed_to;
    }

    public function getLastSeen(): string
    {
        return $this->last_seen;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getRent(): float
    {
        return $this->rent;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    //methods

    public function getOffer(int $offer_id){
        $offer = $this->database->select($offer_id);
        $this->setOfferId($offer[0]->offer_id);
        $this->setTitle($offer[0]->title);
        $this->setCreatedAt($offer[0]->created_at);
        $this->setRefreshedTo($offer[0]->refreshed_to);
        $this->setLastSeen($offer[0]->last_seen);
        $this->setDescription($offer[0]->description);
        $this->setPrice($offer[0]->price);
        $this->setRent($offer[0]->rent);
        $this->setUrl($offer[0]->url);
        $this->setCategoryId($offer[0]->category_id);
    }

    public function getOfferPrice($offer): ?float
    {
        (float)$price = null;

        foreach ($offer->params as $param){
            if($param->key === "price"){
                $price = floatval($param->value->value);
            }
        }

        return $price;
    }

    public function getOfferRent($offer): ?float
    {
        (float)$rent = null;

        foreach ($offer->params as $param) {
            if($param->key === "rent"){
                $rent = floatval($param->value->key);
            }
        }

        return $rent;
    }
}