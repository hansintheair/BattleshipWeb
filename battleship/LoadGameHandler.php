<?php

session_start();

include "BattleshipsDB.php";


$id_user = $_SESSION["id_user"];

function loadUserGame($id_user) {
    $battleship_db = new BattleshipsDB();

    $battleship_db->connect();
    $data = $battleship_db->getGame($id_user);
    $battleship_db->disconnect();
    
    return json_encode($data);
}

//error_log("IN LoadGameHander.php");  //DEBUG
//error_log("ID_USER: ".$id_user);  //DEBUG
//error_log("DATA: ".loadUserGame($id_user));  //DEBUG

header("Content-Type: application/json;charset=utf8;");
echo loadUserGame($id_user);