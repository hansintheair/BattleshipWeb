<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/gameplay-styles.css">
    <script type="text/javascript" src="Player.js"></script>
    <script type="text/javascript" src="PlayerHuman.js"></script>
    <script type="text/javascript" src="PlayerComp.js"></script>
    <script type="text/javascript" src="CookieIO.js"></script>
</head>
<body>
    <div class="container">
        <div class="left">
            <div id="board-shots">
                <div id="comp-board-ships"></div> <!-- Computer's Placement Table -->
            </div>
        </div>
        <div class="right">
            <div id="board-container">
                <div id="board-ships"></div> <!-- Player's Placement Table -->
                <div id="ship-overlay"></div> <!-- Player's Ship image on cells -->
            </div>
        </div>
    </div>
    
    <div class="controls">
        <button id="save-game">Save Game</button>
        <button id="quit-game">Quit Game</button>
    </div>
    
    <div class="ship-images" style="display: none;">
        <img src="images/Carrier_big.png" class="ship-image" alt="Carrier [5 Squares]">
        <img src="images/Battleship_big.png" class="ship-image" alt="Battleship [4 Squares]">
        <img src="images/Destroyer_big.png" class="ship-image" alt="Destroyer [3 Squares]">
        <img src="images/Sub_big.png" class="ship-image" alt="Submarine [3 Squares]">
        <img src="images/Patrol_big.png" class="ship-image" alt="Patrol Boat [2 Squares]">
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const p1 = new PlayerHuman();
            const p2 = new PlayerComp();
            let isPlayerTurn = true; // Track whose turn it is
            
            // Set up p1 (human player)
            p1.fromJSON(getCookie("p1"));
            p1.updateBoard();
            p1.renderAllPlacedShips();
            
            // Set up p2 (ai player)
            p2.getShipPlacement();

            const compBoardContainer = document.getElementById("comp-board-ships");
            p2.displayShipsAI(compBoardContainer); // see Player.js (86)
            
            // game loop
            // grabs the ai board cells and throws them into an array
            const compCells = compBoardContainer.getElementsByTagName("td");
            Array.from(compCells).forEach(cell => {
                cell.addEventListener("click", (event) => {
                    // actual game loop
                    if (isPlayerTurn) {
                        // determine row and col number of the clicked cell
                        const row = cell.parentNode.rowIndex;
                        const col = cell.cellIndex;
                        
                        /* DEBUG - ADD BELOW CODE TO HIDE ENEMY SHIPS - SEE Player.js (92) */
                        // if cell doesnt have a gif on it
                        if (!cell.style.backgroundImage) {
                            // shoot the clicked cell and end turn
                            p1.handlePlayerShot(row, col, cell, p2);
                            isPlayerTurn = false;
                            // ai turn after a delay, flips flag back to true after ai shoots
                            setTimeout(() => {
                                p2.handleAIShot(p1);
                                isPlayerTurn = true;
                            }, 2000); // delay to start ai turn in milliseconds (1000 = 1s)
                        } else {
                            alert("You have already shot this location.");
                    
                        /* DEBUG - DELETE BELOW CODE TO HIDE ENEMY SHIPS - SEE Player.js (92) */
                        /*p1.handlePlayerShot(row, col, cell, p2);
                        isPlayerTurn = false;
                        setTimeout(() => {
                            p2.handleAIShot(p1);
                            isPlayerTurn = true;
                        }, 1000);
                        } else {
                            alert("You have already shot this location."); // Add this alert*/
                        }
                    }
                });
            });
            
            // save and quit buttons
            document.getElementById("save-game").addEventListener("click", () => {
                p1.saveGameState(p2);
                alert("Game saved!");
            });

            document.getElementById("quit-game").addEventListener("click", () => {
                if (confirm("Are you sure you want to quit the game?")) {
                    p1.endGame();
                    alert("Game quit. Thanks for playing!");
                    // redirect to game menu after quitting
                    window.location.href = "gameMenu.php";
                }
            });
        });
    </script>
</body>
</html>