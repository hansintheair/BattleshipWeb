<?php

session_start();

include "BattleshipsDB.php";


$id_user = $_SESSION["id_user"];

// Sanitize for security
$p1 = filter_input(INPUT_POST, 'p1', FILTER_SANITIZE_STRING);
$p2 = filter_input(INPUT_POST, 'p2', FILTER_SANITIZE_STRING);

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