<?php

class Database
{
    private PDO $db;
    private string $db_host = "localhost";
    private string $db_name = "olxbot_oop";
    private string $db_user = "root";
    private string $db_password = "";

    public function __construct(){
        $this->db = new PDO("mysql:host=$this->db_host;dbname=$this->db_name;charset=utf8mb4", $this->db_user, $this->db_password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function saveOrUpdate(Offer $offer){
        $offerId = $offer->getOfferId();

        $query = $this->db->prepare("SELECT id FROM offers WHERE offer_id=:offer_id");
        $query->bindParam(':offer_id',$offerId,PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll();

        if(empty($result)){
            $this->insert($offer);
        }else{
            $this->update($offer, $result);
        }

    }

    public function getConfig(string $key): ?string
    {
        $query = $this->db->prepare("SELECT * FROM config WHERE config_key=:key");
        $query->bindParam(':key',$key,PDO::PARAM_STR);
        $query->execute();
        $value = $query->fetchAll();

        if(empty($value)){
            return null;
        }else {
            return $value[0]["config_value"];
        }
    }

    private function insert(Offer $offer){
        $offerId = $offer->getOfferId();
        $title = $offer->getTitle();
        $createdAt = $offer->getCreatedAt();
        $refreshedTo = $offer->getRefreshedTo();
        $lastSeen = $offer->getLastSeen();
        $description = $offer->getDescription();
        $price = $offer->getPrice();
        $rent = $offer->getRent();
        $url = $offer->getUrl();

        $query = $this->db->prepare("INSERT INTO offers
                    (offer_id, title, created_at, refreshed_to, last_seen, description, price, rent, url)
                    VALUES
                    (:offer_id, :title, :created_at, :refreshed_to, :last_seen, :description, :price, :rent, :url)");

        $query->bindParam(':offer_id', $offerId, PDO::PARAM_INT);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':created_at', $createdAt, PDO::PARAM_STR);
        $query->bindParam(':refreshed_to', $refreshedTo, PDO::PARAM_STR);
        $query->bindParam(':last_seen', $lastSeen, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':rent', $rent, PDO::PARAM_STR);
        $query->bindParam(':url', $url, PDO::PARAM_STR);

        $query->execute();
    }

    private function update(Offer $offer, $result){
        $lastSeen = $offer->getLastSeen();

        $query = $this->db->prepare("UPDATE offers SET last_seen=:last_seen WHERE id=:id");
        $query->bindParam(':last_seen', $lastSeen, PDO::PARAM_STR);
        $query->bindParam(':id', $result[0]['id'], PDO::PARAM_INT);

        $query->execute();
    }
}