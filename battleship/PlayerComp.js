class PlayerComp extends Player {
    constructor(isSmart = true) {
        super();
        this.isSmart = isSmart; // Determines the AI mode (smart or dumb)
        this.randomShot = true; // Determines if the next shot should be random
        this.targetQueue = []; // Queue for targeted shots
        this.hitDirections = ['right', 'up', 'left', 'down']; // Directions to search around a hit cell
        this.currentDirection = 0; // Index for the current search direction
        this.firstHit = null; // Coordinates of the first hit in a sequence
        this.hitCells = new Set(); // Tracks all hit cells
        this.sunkShips = new Set(); // Tracks sunk ships
        this.checkerboardCells = this.generateCheckerboardCells(); // Cells in the checkerboard pattern
    }

    // Places ships on the board randomly
    getShipPlacement() {
        const shipTypes = Object.keys(this.shipLengths);

        shipTypes.forEach(shipType => {
            let placed = false;
            let attempts = 0;
            const maxAttempts = 100;

            while (!placed && attempts < maxAttempts) {
                const direction = Math.random() < 0.5 ? "Vertical" : "Horizontal";
                const { row, col } = this.getRandomCoordinates(shipType, direction);

                if (direction === "Vertical") {
                    placed = this.placeShipVertical(row, col, shipType);
                } else {
                    placed = this.placeShipHorizontal(row, col, shipType);
                }

                attempts++;
            }

            if (!placed) {
                console.error(`Failed to place ship: ${shipType}`);
            } else {
                console.log(`Successfully placed ship: ${shipType}`);
            }

            this.shipPlaced[shipType] = placed;
        });
    }
    
    // Places a ship vertically if possible
    placeShipVertical(row, col, shipType) {
        const shipLength = this.shipLengths[shipType];
        if (this.canPlaceVertical(row, col, shipLength)) {
            for (let i = 0; i < shipLength; i++) {
                this.ships[row + i][col] = shipType[0];
            }
            return true;
        }
        return false;
    }

    // Places a ship horizontally if possible
    placeShipHorizontal(row, col, shipType) {
        const shipLength = this.shipLengths[shipType];
        if (this.canPlaceHorizontal(row, col, shipLength)) {
            for (let i = 0; i < shipLength; i++) {
                this.ships[row][col + i] = shipType[0];
            }
            return true;
        }
        return false;
    }

    // Generates the cells for the checkerboard pattern
    generateCheckerboardCells() {
        const cells = [];
        for (let row = 0; row < this.board_size; row++) {
            for (let col = (row % 2); col < this.board_size; col += 2) {
                cells.push({ row, col });
            }
        }
        return cells;
    }

    // Determines the next shot location
    getShot() {
        let row;
        let col;

        if (this.randomShot) {
            if (this.isSmart) {
                // Smart mode: Use checkerboard pattern
                do {
                    const index = Math.floor(Math.random() * this.checkerboardCells.length);
                    const cell = this.checkerboardCells[index];
                    row = cell.row;
                    col = cell.col;
                    this.checkerboardCells.splice(index, 1); // Remove the cell to avoid re-selection
                } while (this.shots[row][col] !== "-");
            } else {
                // Dumb mode: Select random cells
                do {
                    row = Math.floor(Math.random() * this.board_size);
                    col = Math.floor(Math.random() * this.board_size);
                } while (this.shots[row][col] !== "-");
            }
        } else {
            const nextTarget = this.targetQueue.shift();
            if (nextTarget && this.isValidCell(nextTarget.row, nextTarget.col)) {
                row = nextTarget.row;
                col = nextTarget.col;
            } else {
                this.randomShot = true;
                return this.getShot();
            }
        }

        console.log(`AI shooting at: (${row}, ${col})`);
        return { row, col };
    }

    // Generates random coordinates for ship placement
    getRandomCoordinates(shipType, direction) {
        let maxRow;
        if (direction === "Vertical") {
            maxRow = this.board_size - this.shipLengths[shipType];
        } else {
            maxRow = this.board_size;
        }

        let maxCol;
        if (direction === "Horizontal") {
            maxCol = this.board_size - this.shipLengths[shipType];
        } else {
            maxCol = this.board_size;
        }
        
        const row = Math.floor(Math.random() * maxRow);
        const col = Math.floor(Math.random() * maxCol);
        return { row, col };
    }

    // Handles the AI's shot logic
    handleAIShot(opponent) {
        const { row, col } = this.getShot();
        const result = opponent.receiveShot(row, col);
        const playerCell = document.querySelector(`#board-ships table tr:nth-child(${row + 1}) td:nth-child(${col + 1})`);

        if (result === "hit") {
            playerCell.style.backgroundImage = "url('images/hit.gif')";
            playerCell.style.backgroundSize = "100% 100%";
            playerCell.style.position = "relative"; 
            playerCell.style.zIndex = "1"; 
            this.shots[row][col] = "H";
            this.hitCells.add(`${row},${col}`);
            console.log(`Hit at: (${row}, ${col})`);

            if (this.isShipSunk(row, col, opponent)) {
                console.log(`Ship sunk at: (${row}, ${col})`);
                this.processSunkShip(row, col, opponent);
            } else {
                this.cardinalSearch(row, col);
                this.randomShot = false;
            }
        } else {
            playerCell.style.backgroundImage = "url('images/miss.gif')";
            playerCell.style.backgroundSize = "100% 100%";
            playerCell.style.position = "relative"; 
            playerCell.style.zIndex = "1"; 
            this.shots[row][col] = "M";
            console.log(`Miss at: (${row}, ${col})`);
            if (this.targetQueue.length === 0 && !this.randomShot) {
                this.switchDirection();
            }
        }

        if (this.areAllShipsSunk(opponent)) {
            alert("AI wins!");
            opponent.endGame();
            return;
        }

        console.log('Player health after AI shot:', opponent.shipHealth);
        saveGameToCookie(this, opponent);
    }

    // Checks if all ships of the opponent are sunk
    areAllShipsSunk(opponent) {
        return Object.values(opponent.shipHealth).every(health => health === 0);
    }

    // Processes the logic after a ship is sunk
    processSunkShip(row, col, opponent) {
        const cardenalHits = this.getAllCardenalHits();
        if (cardenalHits.length > 0) {
            console.log(`Continuing to target cardenal hits: ${JSON.stringify(cardenalHits)}`);
            this.targetQueue.push(...cardenalHits);
            this.randomShot = false;
        } else {
            this.firstHit = null;
            this.randomShot = true;
        }
    }

    // Retrieves all cardinal hits around the sunk ship
    getAllCardenalHits() {
        const cardenalHits = [];
        for (let hitCell of this.hitCells) {
            const [row, col] = hitCell.split(',').map(Number);
            const hits = this.getCardenalHits(row, col);
            cardenalHits.push(...hits);
            // Check diagonal cells only if there are hits on two sides forming a corner
            const diagonalHits = this.getValidDiagonalHits(row, col);
            cardenalHits.push(...diagonalHits);
        }
        // Remove duplicates and already known misses
        return cardenalHits.filter((v, i, a) => a.findIndex(t => (t.row === v.row && t.col === v.col)) === i)
                           .filter(coord => this.shots[coord.row][coord.col] === "-");
    }

    // Retrieves cardinal hits around a given cell
    getCardenalHits(row, col) {
        const directions = [
            { row: 0, col: 1 }, 
            { row: -1, col: 0 }, 
            { row: 0, col: -1 }, 
            { row: 1, col: 0 }
        ];
        const cardenalHits = [];

        directions.forEach(direction => {
            const newRow = row + direction.row;
            const newCol = col + direction.col;
            if (this.isValidCell(newRow, newCol) && this.shots[newRow][newCol] === "-") {
                cardenalHits.push({ row: newRow, col: newCol });
            }
        });

        return cardenalHits;
    }

    // Retrieves valid diagonal hits based on hits forming a corner
    getValidDiagonalHits(row, col) {
        const diagonals = [
            { row: -1, col: -1, sides: [{ row: -1, col: 0 }, { row: 0, col: -1 }] },
            { row: -1, col: 1, sides: [{ row: -1, col: 0 }, { row: 0, col: 1 }] },
            { row: 1, col: -1, sides: [{ row: 1, col: 0 }, { row: 0, col: -1 }] },
            { row: 1, col: 1, sides: [{ row: 1, col: 0 }, { row: 0, col: 1 }] }
        ];
        const diagonalHits = [];

        diagonals.forEach(diagonal => {
            const newRow = row + diagonal.row;
            const newCol = col + diagonal.col;
            const side1 = { row: row + diagonal.sides[0].row, col: col + diagonal.sides[0].col };
            const side2 = { row: row + diagonal.sides[1].row, col: col + diagonal.sides[1].col };

            if (this.isValidCell(newRow, newCol) && this.shots[newRow][newCol] === "-" &&
                this.isValidCell(side1.row, side1.col) && this.shots[side1.row][side1.col] === "H" &&
                this.isValidCell(side2.row, side2.col) && this.shots[side2.row][side2.col] === "H") {
                diagonalHits.push({ row: newRow, col: newCol });
            }
        });

        return diagonalHits;
    }

    // Checks if a ship is completely sunk
    isShipSunk(row, col, opponent) {
        const shipType = opponent.getShipTypeAt(row, col);
        if (!shipType) return false;

        const shipCoordinates = opponent.getShipCoordinates(shipType);
        const isSunk = shipCoordinates.every(coord => this.shots[coord.row][coord.col] === "H");

        if (isSunk) {
            this.sunkShips.add(shipType); // Track sunk ships
        }

        return isSunk;
    }

    // Searches around a hit cell in the current direction
    cardinalSearch(row, col) {
        if (!this.firstHit) {
            this.firstHit = { row, col };
        }
        console.log(`Searching around: (${row}, ${col})`);
        this.addTargetsInCurrentDirection(row, col);
    }

    // Adds new target cells in the current search direction
    addTargetsInCurrentDirection(row, col) {
        let newTargets = [];
        const direction = this.hitDirections[this.currentDirection];
        console.log(`Current direction: ${direction}`);

        switch (direction) {
            case 'right':
                newTargets.push({ row: row, col: col + 1 });
                break;
            case 'up':
                newTargets.push({ row: row - 1, col: col });
                break;
            case 'left':
                newTargets.push({ row: row, col: col - 1 });
                break;
            case 'down':
                newTargets.push({ row: row + 1, col: col });
                break;
        }

        newTargets.forEach(target => {
            if (this.isValidCell(target.row, target.col) && this.shots[target.row][target.col] === "-") {
                this.targetQueue.push(target);
                console.log(`Adding target: (${target.row}, ${target.col})`);
            }
        });

        if (this.targetQueue.length === 0) {
            this.switchDirection();
        }
    }

    // Switches the search direction after exhausting current direction
    switchDirection() {
        this.currentDirection = (this.currentDirection + 1) % this.hitDirections.length;

        if (this.currentDirection === 0) {
            this.randomShot = true;
            this.firstHit = null;
            console.log(`Switching back to random shots`);
        } else {
            console.log(`Switching direction to: ${this.hitDirections[this.currentDirection]}`);
            if (this.firstHit) {
                this.addTargetsInCurrentDirection(this.firstHit.row, this.firstHit.col);
            }
        }
    } 
    
    // Checks if a cell is valid and not already hit or missed
    isValidCell(row, col) {
        return row >= 0 && row < this.board_size && col >= 0 && col < this.board_size && this.shots[row][col] === "-";
    }

    // Saves the game state
    saveGameState(opponent) {
        setCookie("p1", opponent);
        setCookie("p2", this);
    }
}
