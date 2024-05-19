<?php

class BattleshipsDB {

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "battleship";
    private $db;
    
    function connect() {
        $this->db = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->db_name
        );
        
        echo "Connecting to ".$this->db_name."... ";
        
        // Check connection
        if ($this->db->connect_error) {
            die("Connection failed<br>".$this->db->connect_error);
        }
        
        echo "Succeeded<br>";
    }
    
    function disconnect() {
        
        echo "Disconnecting from ".$this->db_name."... ";

        if (!$this->db) {
            echo "Nothing to disconnect.<br>";
            return;
        }
        
        if ($this->db->close()) {
            echo "Succeeded<br>";
        }
        else {
            echo "Failed<br>";
        }
    }
    
    function checkUserExists($email) {
        $query = "SELECT * FROM ".$this->db_name.".`entity_users` AS `entity_users` WHERE `email` = '".$email."'";

        return (bool)$this->db->query($query)->fetch_assoc();
    }
    
    function getUser($email) {
        $query = "SELECT `id_user` AS `USER_UID`, `email` AS `EMAIL`, `password` AS `PASSWORD` FROM ".$this->db_name.".`entity_users` AS `entity_users` WHERE `email` = '".$email."'";
    
        return $this->db->query($query)->fetch_assoc();
    }
    
    function addUser($email, $password) {
        $query = "INSERT INTO ".$this->db_name.".`entity_users` (`email`, `password`) VALUES ('".$email."', '".$password."')";
        
        $this->db->query($query);
    }

}
