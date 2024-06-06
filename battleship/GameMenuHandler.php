<?php

include 'GameMenu.php';
    // Three options from GameMenu.php
    // If submit was new_campaign (Sent via POST method)
    // If submit was load_campaign (Sent via POST method)
    // If submit was delete_campaign (Sent via POST method)
    if (isset($_POST['action'])) {
        $submit = $_POST['action'];
        if ($submit === 'new_campaign') {
            // Code for handling new campaign submission
            // Print something to the screen
            echo "New Campaign";
        } elseif ($submit === 'load_campaign') {
            // Code for handling load campaign submission
            // Print something to the screen
            echo "Load Campaign";
        } elseif ($submit === 'delete_campaign') {
            // Code for handling delete campaign submission
            // Print something to the screen
            echo "Delete Campaign";
        }
    } else {
        // Handle the case when 'submit' is not set
        // For example, you can set a default value or display an error message
        $submit = '';
    }
?>