class PlayerComp extends Player {
    constructor() {
        super();
        this.randomShot = true;
        this.targetQueue = [];
        this.hitDirections = ['right', 'up', 'left', 'down'];
        this.currentDirectionIndex = 0;
        this.firstHit = null; // first hit position
    }

    // RANDOM AI PLACEMENT
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

    // AI RANDOM FIRE ALGORITHM
    getShot() {
        let row;
        let col;

        if (this.randomShot) {
            do {
                row = Math.floor(Math.random() * this.board_size);
                col = Math.floor(Math.random() * this.board_size);
            } while (this.shots[row][col] !== "-");
        } else {
            const nextTarget = this.targetQueue.shift();
            if (nextTarget) {
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

    handleAIShot(opponent) {
        const { row, col } = this.getShot();
        const result = opponent.receiveShot(row, col);
        const playerCell = document.querySelector(`#board-ships table tr:nth-child(${row + 1}) td:nth-child(${col + 1})`);

        if (result === "hit") {
            playerCell.style.backgroundImage = "url('images/hit.gif')";
            playerCell.style.backgroundSize = "100% 100%";
            playerCell.style.position = "relative";     // Z-index only works on positioned elements
            playerCell.style.zIndex = "1";              // Make the gifs appear on z-index 1, boats on z-index 0
            this.shots[row][col] = "H";
            console.log(`Hit at: (${row}, ${col})`);
            this.cardinalSearch(row, col);
            this.randomShot = false; // Switch to targeted shots
        } else {
            playerCell.style.backgroundImage = "url('images/miss.gif')";
            playerCell.style.backgroundSize = "100% 100%";
            playerCell.style.position = "relative";     // Z-index only works on positioned elements
            playerCell.style.zIndex = "1";              // Make the gifs appear on z-index 1, boats on z-index 0
            this.shots[row][col] = "M";
            console.log(`Miss at: (${row}, ${col})`);
            if (this.targetQueue.length === 0 && !this.randomShot) {
                this.switchDirection();
            }
        }

        this.saveGameState(opponent);

        if (opponent.winCondition()) {
            alert("AI wins!");
            opponent.endGame();
        }
    }

    cardinalSearch(row, col) {
        if (!this.firstHit) {
            this.firstHit = { row, col };
        }
        console.log(`Searching around: (${row}, ${col})`);
        this.addTargetsInCurrentDirection(row, col);
    }

    addTargetsInCurrentDirection(row, col) {
        let newTargets = [];
        const direction = this.hitDirections[this.currentDirectionIndex];
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
            if (this.isValidCell(target.row, target.col)) {
                this.targetQueue.push(target);
                console.log(`Adding target: (${target.row}, ${target.col})`);
            }
        });

        if (this.targetQueue.length === 0) {
            this.switchDirection();
        }
    }

    switchDirection() {
        this.currentDirectionIndex = (this.currentDirectionIndex + 1) % this.hitDirections.length;

        if (this.currentDirectionIndex === 0) {
            this.randomShot = true;
            this.firstHit = null;
            console.log(`Switching back to random shots`);
        } else {
            console.log(`Switching direction to: ${this.hitDirections[this.currentDirectionIndex]}`);
            if (this.firstHit) {
                this.addTargetsInCurrentDirection(this.firstHit.row, this.firstHit.col);
            }
        }
    } 
    
    isValidCell(row, col) {
        return row >= 0 && row < this.board_size && col >= 0 && col < this.board_size && this.shots[row][col] === "-";
    }

    // save everything
    saveGameState(opponent) {
        setCookie("p1", opponent);
        setCookie("p2", this);
    }
}
