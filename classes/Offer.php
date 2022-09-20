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

    public function __construct(){
        //constructor
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

    public function setDescription(string $description){
        $this->description = $description;
    }

    public function setPrice(float $price){
        $this->price = $price;
    }

    public function setRent(float $rent){
        $this->rent = $rent;
    }

    public function setUrl(string $url){
        $this->url = $url;
    }

    //setters
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
        //return $this->last_seen;
        return date("Y-m-d H:i:s");
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

    //methods

    public function save(){

    }
}