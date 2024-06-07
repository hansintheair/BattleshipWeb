class PlayerComp extends Player {
    constructor() {
        super();
    }

    // RANDOM AI PLACEMENT
    getShipPlacement() {
        // gets the keys from shipLengths (see Player.js constructor)
        const shipTypes = Object.keys(this.shipLengths);
        
        shipTypes.forEach(shipType => {
            let placed = false;
            // place ship until successful
            while (!placed) {
                // random direction based on RNG - 50/50
                const direction = Math.random() < 0.5 ? "Vertical" : "Horizontal";
                // get random row and column based on ship and direction
                const { row, col } = this.getRandomCoordinates(shipType, direction);
                
                if (direction === "Vertical") {
                    // if location is valid for the ship to be placed vertically
                    if (this.canPlaceVertical(row, col, this.shipLengths[shipType])) {
                        // place ship symbol (C = Carrier) on the cells based on ship length
                        for (let i = 0; i < this.shipLengths[shipType]; i++) {
                            this.ships[row + i][col] = shipType[0];
                        }
                        placed = true;
                    }
                } else {
                    // same as above but for horizontal placement
                    if (this.canPlaceHorizontal(row, col, this.shipLengths[shipType])) {
                        for (let i = 0; i < this.shipLengths[shipType]; i++) {
                            this.ships[row][col + i] = shipType[0];
                        }
                        placed = true;
                    }
                }
            }
            
            this.shipPlaced[shipType] = true;
        });
    }

    // AI RANDOM FIRE ALGORITHM
    getShot() {
        let row, col;
        // loop until ai selects a cell that hasnt been shot at
        // ("-" in a cell = not shot at -> see shots array in Player.js)
        do {
            // RNG row and column based on board size
            row = Math.floor(Math.random() * this.board_size);
            col = Math.floor(Math.random() * this.board_size);
        } while (this.shots[row][col] !== "-");
        
        return { row, col };
    }

    getRandomCoordinates(shipType, direction) {
        let maxRow;
        if (direction === "Vertical") {
            // boundary checking for vertical
            maxRow = this.board_size - this.shipLengths[shipType];
        } else {
            maxRow = this.board_size;
        }

        let maxCol;
        if (direction === "Horizontal") {
            // boundary checking for horizontal
            maxCol = this.board_size - this.shipLengths[shipType];
        } else {
            maxCol = this.board_size;
        }
        
        const row = Math.floor(Math.random() * maxRow);
        const col = Math.floor(Math.random() * maxCol);
        return { row, col };
    }

    handleAIShot(opponent) {
        const { row, col } = this.getShot();
        // check if hit or miss
        const result = opponent.receiveShot(row, col);
        // set playerCell = to the actual cell of the table being shot at
        const playerCell = document.querySelector(`#board-ships table tr:nth-child(${row + 1}) td:nth-child(${col + 1})`);
        
        // adds the gifs to the cell based on result
        if (result === "hit") {
            playerCell.style.backgroundImage = "url('images/hit.gif')";
        } else {
            playerCell.style.backgroundImage = "url('images/miss.gif')";
        }
        
        // save after each shot in case of crashes, closed tabs, etc.
        this.saveGameState(opponent);
        // DEBUG
        console.log('Player health after AI shot:', opponent.shipHealth);
        // if all player ships sunk, AI wins and game ends
        if (opponent.winCondition()) {
            alert("AI wins!");
            opponent.endGame();
        }
    }

    // save everything
    saveGameState(opponent) {
        setCookie("p1", opponent);
        setCookie("p2", this);
    }
}
