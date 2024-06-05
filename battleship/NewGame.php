<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/game-style.css">
    <script type="text/javascript" src="Game.js"></script>
    <script type="text/javascript" src="Player.js"></script>
    <script type="text/javascript" src="CookieIO.js"></script>
</head>
<body>
    
    <div class="container">
        <div class="left">
            <div class="ship-images">
                <img src="images/Carrier_big.png" class="ship-image" alt="Carrier [5 Squares]">
                <img src="images/Battleship_big.png" class="ship-image" alt="Battleship [4 Squares]">
                <img src="images/Destroyer_big.png" class="ship-image" alt="Destroyer [3 Squares]">
                <img src="images/Sub_big.png" class="ship-image" alt="Submarine [3 Squares]">
                <img src="images/Patrol_big.png" class="ship-image" alt="Patrol Boat [2 Squares]">
            </div>
            <div id="message"></div> <!-- feedback messages -->
            <button id="toggle-button">Mode: Vertical</button>
            <button id="reset-button">Reset Board</button>
            <button id="reset-selected-ship-button">Reset Selected Ship</button>
            <button id="confirm-button">Confirm Placement</button>
        </div>
        <div class="right">
            <div id="board-container">
                <div id="board-ships"></div> <!-- Placement Table -->
                <div id="ship-overlay"></div> <!-- Ship image on cells -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const p1 = new Player();
            const shipsContainer = document.getElementById("board-ships");
            p1.displayShips(shipsContainer);
            p1.selectShip();
            
            document.getElementById("reset-button").addEventListener("click", () => {
                p1.resetBoard();
            });
            
            const toggleButton = document.getElementById("toggle-button");
            toggleButton.addEventListener("click", () => {
                p1.togglePlacementMode();
                toggleButton.textContent = `Mode: ${p1.placementMode}`;
            });
            
            document.getElementById("reset-selected-ship-button").addEventListener("click", () => {
                p1.resetSelectedShip();
            });
            
            document.getElementById("confirm-button").addEventListener("click", () => {
                
                
                
                // (TEST CODE CAN DELETE) simulate loading saved player state to a new player instance  
                //Save current player's state
                setCookie("p1", p1);
                //Load state (to new player instance i.e. when we are loading a saved game)
                let p3 = new Player();
                p3.fromJSON(getCookie("p1"));
                console.log("P3");
                console.log(p3.ships[1]);
                // ^TEST CODE CAN DELETE^
                
                
                
                
                
            
                alert("Ships confirmed (put a cool message here)");
            });
        });
    </script>
</body>
</html>
