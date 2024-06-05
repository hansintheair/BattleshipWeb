
class Player {
    constructor() {
        
        this.board_size = 10;
        this.ships = [];
        for (let i = 0; i < this.board_size; i++) {
            this.ships[i] = new Array(this.board_size).fill("");
        }
        
        // Not implemented/used yet
        this.shots = [];
        for (let i = 0; i < this.board_size; i++) {
            this.shots[i] = new Array(this.board_size).fill("-");
        }
        
        // Reflects no ship selected once loaded
        this.selectedShip = null;
        
        
        this.shipLengths = {
            "Carrier [5 Squares]": 5,
            "Battleship [4 Squares]": 4,
            "Destroyer [3 Squares]": 3,
            "Submarine [3 Squares]": 3,
            "Patrol Boat [2 Squares]": 2
        };
        
        // Default to vertical placement mode
        this.placementMode = "Vertical";
        
        // Used to prevent placing multiple of the same ship
        // Can use to detect state of "placement phase"
        this.shipPlaced = {
            "Carrier [5 Squares]": false,
            "Battleship [4 Squares]": false,
            "Destroyer [3 Squares]": false,
            "Submarine [3 Squares]": false,
            "Patrol Boat [2 Squares]": false
        };
        
        this.placedShips = [];
    }
    
    // Creates table for placement and adds click listeners to each cell
    displayShips(target) {
        const table = document.createElement("table");
        
        for (let row = 0; row < this.board_size; row++) {
            const tr = document.createElement("tr");
            for (let col = 0; col < this.board_size; col++) {
                const td = document.createElement("td");
                td.textContent = this.ships[row][col];
                td.addEventListener("click", () => this.placeShip(row, col));
                tr.appendChild(td);
            }
            table.appendChild(tr);
        }
        target.innerHTML = "";
        target.appendChild(table);  // Inject the tabe into the target element
    }
    
    // Not implemented/used yet
    /*displayShots(target) {
        const table = document.createElement("table");
        
        for (let row = 0; row < this.board_size; row++) {
            const tr = document.createElement("tr");
            for (let col = 0; col < this.board_size; col++) {
                const td = document.createElement("td");
                td.textContent = this.shots[row][col];
                tr.appendChild(td);
            }
            table.appendChild(tr);
        }
        target.appendChild(table);  // Inject the tabe into the target element
    }*/
    
    selectShip() {
        // Store ship images in shipImages
        const shipImages = document.querySelectorAll(".ship-image");
        const messageElement = document.getElementById("message");

        // Loop through each image
        shipImages.forEach((image) => {
            image.addEventListener("click", () => {
                shipImages.forEach((img) => img.classList.remove("selected-ship")); // Remove the border from all images
                image.classList.add("selected-ship"); // Add the border to the clicked image

                // Display a message based on the clicked ship
                const shipType = image.alt;
                if (shipType) {
                    this.selectedShip = shipType;
                    messageElement.textContent = `Placing ${shipType}`;
                    this.renderAllPlacedShips();
                } else {
                    messageElement.textContent = "Ship type is not defined.";
                }
            });
        });
    }
    
    // Called by displayShips after clicking a cell
    placeShip(row, col) {
        // Operates on the selected ship, if one is selected
        if (this.selectedShip) {
            // Checks if selected ship is "true" in the shipPlaced object
            if (this.shipPlaced[this.selectedShip]) {
                document.getElementById("message").textContent = `${this.selectedShip} has already been placed.`;
                return;
            }
            
            // Sets new shipLength object to the selected ships length
            const shipLength = this.shipLengths[this.selectedShip];
            
            if (this.placementMode === "Vertical") {
                
                // Execute if ship can be placed vertically
                if (this.canPlaceVertical(row, col, shipLength)) {
                    for (let i = 0; i < shipLength; i++) {
                        this.ships[row + i][col] = this.selectedShip[0]; // Place the ship vertically
                    }
                    
                    // Refresh the board display after placing the ship
                    this.updateBoard();
                    
                    // Store placement data into the placedShips array
                    this.placedShips.push({ ship: this.selectedShip, row, col, length: shipLength, orientation: "Vertical" });
                    
                    this.renderAllPlacedShips(); // Render all placed ships
                    document.getElementById("message").textContent = `${this.selectedShip} placed vertically.`;
                    
                    // true = ship can no longer be placed (prevent duplicates)
                    this.shipPlaced[this.selectedShip] = true;
                    // Check after placing a ship for confirm button functionality
                    this.checkAllShipsPlaced();
                } else {
                    document.getElementById("message").textContent = "Cannot place ship here.";
                }
                
            } else if (this.placementMode === "Horizontal") {
                
                // Execute if ship can be placed horizontally
                if (this.canPlaceHorizontal(row, col, shipLength)) {
                    for (let i = 0; i < shipLength; i++) {
                        this.ships[row][col + i] = this.selectedShip[0]; // Place the ship horizontally
                    }
                    
                    // Refresh the board display after placing the ship
                    this.updateBoard();
                    
                    // Store placement data into the placedShips array
                    this.placedShips.push({ ship: this.selectedShip, row, col, length: shipLength, orientation: "Horizontal" });
                    
                    this.renderAllPlacedShips(); // Render all placed ships
                    document.getElementById("message").textContent = `${this.selectedShip} placed horizontally.`;
                    
                    // true = ship can no longer be placed (prevent duplicates)
                    this.shipPlaced[this.selectedShip] = true;
                    // Check after placing a ship for confirm button functionality
                    this.checkAllShipsPlaced();
                } else {
                    document.getElementById("message").textContent = "Cannot place ship here.";
                }
            }
        } else {
            document.getElementById("message").textContent = "No ship selected.";
        }
    }

    // Validate vertical placement
    canPlaceVertical(row, col, length) {
        
        if (row + length > this.board_size) {
            return false;
        }
        
        for (let i = 0; i < length; i++) {
            if (this.ships[row + i][col] !== "") {
                return false;
            }
        }
        
        return true;
    }
    
    // Validate horizontal placement
    canPlaceHorizontal(row, col, length) {
        
        if (col + length > this.board_size) {
            return false;
        }
        
        for (let i = 0; i < length; i++) {
            if (this.ships[row][col + i] !== "") {
                return false;
            }
        }
        
        return true;
    }

    // Refresh board function to make sure visuals match internal game state
    updateBoard() {
        const shipsContainer = document.getElementById("board-ships");
        this.displayShips(shipsContainer);
    }
    
    // Completely resets the board when button is clicked
    resetBoard() {
        
        for (let i = 0; i < this.board_size; i++) {
            this.ships[i] = new Array(this.board_size).fill("");
        }
        
        this.updateBoard();
        document.getElementById("message").textContent = "Board reset.";
        document.getElementById("confirm-button").style.display = "none";
        
        // Set shipPlaced to false since ships are no longer placed
        for (let ship in this.shipPlaced) {
            this.shipPlaced[ship] = false;
        }
        
        this.placedShips = []; // Clear the placed ships list
        this.renderAllPlacedShips(); // Clear the overlay
        this.checkAllShipsPlaced();
    }
    
    // Swaps placement mode each time button is clicked
    togglePlacementMode() {
        if (this.placementMode === "Vertical") {
            this.placementMode = "Horizontal";
        } else {
            this.placementMode = "Vertical";
        }
    }
    
    resetSelectedShip() {
        // Executes if a ship is selected
        if (this.selectedShip) {
            // shipSymbol = C for Carrier
            const shipSymbol = this.selectedShip[0];
            
            // If ships[row][col] contains C and Carrier is selected, sets
            //  ships[row][col] to ""
            for (let row = 0; row < this.board_size; row++) {
                for (let col = 0; col < this.board_size; col++) {
                    if (this.ships[row][col] === shipSymbol) {
                        this.ships[row][col] = "";
                    }
                }
            }
            // Mark the ship as not placed
            this.shipPlaced[this.selectedShip] = false;
            // Remove the ship from placed ships list
            this.placedShips = this.placedShips.filter(ship => ship.ship !== this.selectedShip);
            this.updateBoard();
            // Re-render remaining placed ships
            this.renderAllPlacedShips();
            
            document.getElementById("message").textContent = `${this.selectedShip} has been reset.`;
        } else {
            document.getElementById("message").textContent = "No ship selected.";
        }
    }
    
    // Helper function to position a ship image on cells
    positionShip(row, col, length, orientation, shipType) {
        // Selects appropriate cell that the ship needs to cover
        const cell = document.querySelector(`#board-ships table tr:nth-child(${row + 1}) td:nth-child(${col + 1})`);
        // Gets the size and position of the cell
        const cellRect = cell.getBoundingClientRect();
        const boardRect = document.getElementById('board-ships').getBoundingClientRect();
        const shipOverlay = document.getElementById("ship-overlay");
        // New image to separate it from the images used for ship selection
        const shipImage = new Image();
        shipImage.src = document.querySelector(`.ship-image[alt="${shipType}"]`).src;
        shipImage.style.position = "absolute";

        // Executes when image is loaded
        shipImage.onload = () => {
            // Places the ship on the cells - can adjust things such as width
            if (orientation === "Vertical") {
                shipImage.style.width = `${cellRect.width}px`;
                shipImage.style.height = `${cellRect.height * length}px`;
                shipImage.style.top = `${cellRect.top - boardRect.top + window.scrollY}px`;
                shipImage.style.left = `${cellRect.left - boardRect.left + window.scrollX}px`;
                shipImage.style.transform = "none";
            } else {
                // Use cell height for width after rotation
                shipImage.style.width = `${cellRect.height}px`;
                 // Use cell width times length for height after rotation
                shipImage.style.height = `${cellRect.width * length}px`;
                 // Adjust top position since it is rotated
                shipImage.style.top = `${cellRect.top - boardRect.top + window.scrollY + cellRect.height}px`;
                shipImage.style.left = `${cellRect.left - boardRect.left + window.scrollX}px`;
                shipImage.style.transform = "rotate(-90deg)";
                // Adjust origin to rotate correctly
                shipImage.style.transformOrigin = `top left`;
            }
        };

        shipOverlay.appendChild(shipImage);
    }
    
    // Removes "outdated" images - prevents overlapping and duplication
    // Rerendering ships after changes makes it "sync" with internal game state
    renderAllPlacedShips() {
        const shipOverlay = document.getElementById("ship-overlay");
        // Clear the overlay container
        shipOverlay.innerHTML = "";

        // Places current ships to "sync" the board
        this.placedShips.forEach(({ ship, row, col, length, orientation }) => {
            this.positionShip(row, col, length, orientation, ship);
        });
    }
    
    checkAllShipsPlaced() {
        
        const allPlaced = Object.values(this.shipPlaced).every(placed => placed === true);
        
        const confirmButton = document.getElementById("confirm-button");
        if (allPlaced) {
            confirmButton.style.display = "block";
        } else {
            confirmButton.style.display = "none";
        }
    }

    toJSON() {
        return JSON.stringify(
            {
            "ships": this.ships,
            "shots": this.shots,
            "placedShips": this.placedShips
            }
        );
    }
    
  
    fromJSON(json) {
        const data = JSON.parse(json);
        this.ships = data.ships;
        this.shots = data.shots;
        this.placedShips = data.placedShips;        
    }
    
}