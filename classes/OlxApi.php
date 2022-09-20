<?php

class OlxApi
{
    private Database $database;
    private array $credentials;

    public function __construct(){
        $this->database = new Database();
        $this->credentials["olx_api_client_id"] = $this->database->getConfig("olx_api_client_id");
        $this->credentials["olx_api_client_secret"] = $this->database->getConfig("olx_api_client_secret");
    }
}