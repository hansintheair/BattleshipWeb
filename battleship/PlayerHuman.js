
class PlayerHuman extends Player {
    constructor() {
        super();
    }

    handlePlayerShot(row, col, cell, opponent) {
        // prevents player from 'shooting' a cell that was already clicked
        // checks for gif
        if (cell.style.backgroundImage) {
            alert("You have already shot this location.");
            return;
        }
        
        // check if hit or miss
        const result = opponent.receiveShot(row, col);
        // add gifs to cell based on result
        if (result === "hit") {
            this.shots[row][col] = "H"; //we weren't tracking player shots
            cell.style.backgroundImage = "url('images/hit.gif')";
            cell.style.backgroundSize = "100% 100%";
            cell.style.position = "relative";   // Z-index only works on positioned elements
            cell.style.zIndex = "1";            // Make the gifs appear on z-index 1, boats on z-index 0
        } else {
            this.shots[row][col] = "M"; //we weren't tracking player shots
            cell.style.backgroundImage = "url('images/miss.gif')";
            cell.style.backgroundSize = "100% 100%";
            cell.style.position = "relative";   // Z-index only works on positioned elements
            cell.style.zIndex = "1";            // Make the gifs appear on z-index 1, boats on z-index 0    
        }
        // save after each shot in case of crashes, closed tabs, etc.
        saveGameToCookie(this, opponent);
        // DEBUG
        console.log('Opponent health after shot:', opponent.shipHealth);
        // if all enemy ships sunk, player wins and game ends
        if (opponent.winCondition()) {
            alert("You win!");
            this.endGame();
        }
    }

    // prevents cells from being shot at after the game ends by removing event listeners
    endGame() {
        const compBoardContainer = document.getElementById("comp-board-ships");
        const compCells = compBoardContainer.getElementsByTagName("td");
        Array.from(compCells).forEach(cell => {
            cell.replaceWith(cell.cloneNode(true));
        });

        const playerBoardContainer = document.getElementById("board-ships");
        const playerCells = playerBoardContainer.getElementsByTagName("td");
        Array.from(playerCells).forEach(cell => {
            cell.replaceWith(cell.cloneNode(true));
        });
    }
}
