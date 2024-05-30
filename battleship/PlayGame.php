<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Basic CSS for the table */
        body {
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            margin: 0;
            background-color: #f0f0f0; /* Optional: Add a background color */
        }
        #board-ships {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* Optional: Keep elements in a column */
            position: relative;
        }
        table {
            border-collapse: collapse;
            width: auto;
            border: 1px solid black;
        }
        th, td {
            border: 1px solid black;
            padding: 0; /* Remove padding to ensure fixed size */
            text-align: center;
            width: 5vh;
            height: 5vh;
            background-color: transparent;
        }
        th {
            background-color: #f2f2f2;
        }
        .ship-image {
            cursor: pointer;
        }
        .selected-ship {
            border: 2px solid red;
        }
        #message {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        #reset-button, #toggle-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        #ship-overlay {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 10;
        }
        #ship-overlay img {
            position: absolute;
            border: none; /* Ensure no border is present */
        }
        #confirm-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            display: none; /* Initially hidden until all ships placed */
        }
    </style>
    <script type="text/javascript" src="Game.js"></script>
    <script type="text/javascript" src="Player.js"></script>
</head>
<body>
    <h1>Place your ships!</h1>
    
    <div id="container">
        <div id="ship-images">
            <img src="images/Carrier_big.png" class="ship-image" alt="Carrier [5 Squares]">
            <img src="images/Battleship_big.png" class="ship-image" alt="Battleship [4 Squares]">
            <img src="images/Destroyer_big.png" class="ship-image" alt="Destroyer [3 Squares]">
            <img src="images/Sub_big.png" class="ship-image" alt="Submarine [3 Squares]">
            <img src="images/Patrol_big.png" class="ship-image" alt="Patrol Boat [2 Squares]">
        </div>
    </div>
    
    <div id="board-ships"></div> <!-- Placement Table -->
    <div id="ship-overlay" style="position: absolute; pointer-events: none;"></div> <!-- Ship image on cells -->
    <div id="message"></div> <!-- feedback messages -->
    
    <button id="toggle-button">Mode: Vertical</button>
    <button id="reset-button">Reset Board</button>
    <button id="reset-selected-ship-button">Reset Selected Ship</button>
    <button id="confirm-button">Confirm Placement</button>
    
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            p1 = new Player();
            const shipsContainer = document.getElementById("board-ships");
            p1.displayShips(shipsContainer);
            p1.selectShip();
            
            document.getElementById("reset-button").addEventListener("click", () => {
                p1.resetBoard();
            });
            
            const toggleButton = document.getElementById("toggle-button");
            toggleButton.addEventListener("click", () => {
                p1.togglePlacementMode();
                // Changes button text after click (vertical/horizontal)
                toggleButton.textContent = `Mode: ${p1.placementMode}`;
            });
            
            document.getElementById("reset-selected-ship-button").addEventListener("click", () => {
                p1.resetSelectedShip();
            });
            
            document.getElementById("confirm-button").addEventListener("click", () => {
                alert("Ships confirmed (put a cool message here)");
            });
        });
    </script>
</body>
</html>

