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

    function getDb() {
        return $this->db;
    }

    function checkUserExists($email) {
        $query = "SELECT * FROM `entity_users` WHERE `email` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        return $result->num_rows > 0;
    }

    function getUser($email) {
        $query = "SELECT `id_user` AS `USER_UID`, `email` AS `EMAIL`, `password` AS `PASSWORD`, `isAdmin` AS `IS_ADMIN`, `wins`, `losses` FROM `entity_users` WHERE `email` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        return $user;
    }

    function addUser($email, $password, $isAdmin, $wins, $losses) {
        $query = "INSERT INTO `entity_users` (`email`, `password`, `isAdmin`, `wins`, `losses`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            error_log("Prepare failed: " . $this->db->error);
            return false;
        }
        $stmt->bind_param("ssiii", $email, $password, $isAdmin, $wins, $losses);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            error_log("Execution failed: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    function updateUser($user) {
        $query = "UPDATE `entity_users` SET `email` = ?, `password` = ?, `isAdmin` = ?, `wins` = ?, `losses` = ? WHERE `id_user` = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->db->error);
            return false;
        }
        $stmt->bind_param("ssiisi", $user['email'], $user['password'], $user['isAdmin'], $user['wins'], $user['losses'], $user['USER_UID']);
        $result = $stmt->execute();
        if (!$result) {
         error_log("Execution failed: " . $stmt->error);
        }
        $stmt->close();
        return $result;
}

    function deleteUser($user_id) {
        $query = "DELETE FROM `entity_users` WHERE `id_user` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }

    function deleteUserByEmail($email) {
        $query = "DELETE FROM `entity_users` WHERE `email` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    function getAllUsers() {
        $query = "SELECT * FROM `entity_users`";
        $result = $this->db->query($query);
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }
}
?>