<?php

session_start();

include "BattleshipsDB.php";


$id_user = $_SESSION["id_user"];

$jsonInput = file_get_contents('php://input');
$p1 = json_decode($jsonInput, true)['p1'];
$p2 = json_decode($jsonInput, true)['p2'];

error_log("IN Battleships.php");  //DEBUG
error_log("P1: ".$p1);  //DEBUG
error_log("P2: ".$p2);  //DEBUG

function saveUserGame($id_user, $p1, $p2) {
    $battleship_db = new BattleshipsDB();

    $battleship_db->connect();
    
    // If has saved game, overwrite it
    if ($battleship_db->hasGame($id_user))
    {
        $battleship_db->setGame($id_user, $p1, $p2);
    }
    // If doesn't have saved game, add it
    else
    {
        $battleship_db->addGame($id_user, $p1, $p2);
    }
    $battleship_db->disconnect();
}

echo saveUserGame($id_user, $p1, $p2);