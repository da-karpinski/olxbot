<?php

class OlxApi
{
    private Database $database;

    public function __construct(){
        $this->database = new Database();
    }

    public function validateAccessKey(){
        $key_valid_to = $this->database->getConfig("olx_api_access_token_expires");
        if($key_valid_to < time()){
            $this->refreshKeys();
            return true;
        }else{
            return null;
        }
    }

    private function refreshKeys(){
        $curl_body = [
            "grant_type" => "refresh_token",
            "client_id" => $this->database->getConfig("olx_api_client_id"),
            "client_secret" => $this->database->getConfig("olx_api_client_secret"),
            "refresh_token" => $this->database->getConfig("olx_api_refresh_token")
        ];

        $response = $this->curlRequest("/api/open/oauth/token", null, $curl_body);
        $response = json_decode($response);

        $access_token_expires_at = time() + $response->expires_in;
        $this->database->updateConfig("olx_api_access_token", $response->access_token);
        $this->database->updateConfig("olx_api_access_token_expires", $access_token_expires_at);

        $refresh_key_old = $this->database->getConfig("olx_api_refresh_token");
        $refresh_key_new = $response->refresh_token;

        if($refresh_key_new !== $refresh_key_old){
            $expires_at = time() + 2592000;
            $this->database->updateConfig("olx_api_refresh_token", $refresh_key_new);
            $this->database->updateConfig("olx_api_refresh_token_expires", $expires_at);
        }
    }

    private function curlRequest(string $uri, ?array $headers, ?array $body){
        $api_url = $this->database->getConfig("olx_api_url");

        $link = $api_url . $uri;
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