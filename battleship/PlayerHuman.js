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
            cell.style.backgroundImage = "url('images/hit.gif')";
            cell.style.backgroundSize = "100% 100%";
            cell.style.zIndex = "11";   // I thought changing the z-index would make the gif appear on top of the cell, but it doesn't seem to work
        } else {
            cell.style.backgroundImage = "url('images/miss.gif')";
            cell.style.backgroundSize = "100% 100%";
            cell.style.zIndex = "11";   // I thought changing the z-index would make the gif appear on top of the cell, but it doesn't seem to work
        }
        // save after each shot in case of crashes, closed tabs, etc.
        this.saveGameState(opponent);
        // DEBUG
        console.log('Opponent health after shot:', opponent.shipHealth);
        // if all enemy ships sunk, player wins and game ends
        if (opponent.winCondition()) {
            alert("You win!");
            this.endGame();
        }
    }
    
    // save everything
    saveGameState(opponent) {
        setCookie("p1", this);
        setCookie("p2", opponent);
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
