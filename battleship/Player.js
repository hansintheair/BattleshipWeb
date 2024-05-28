
class Player {
    constructor() {
        
        this.board_size = 10;
        this.ships = [];
        for (let i = 0; i < this.board_size; i++) {
            this.ships[i] = new Array(this.board_size).fill("-");
        }
            
        this.shots = [];
        for (let i = 0; i < this.board_size; i++) {
            this.shots[i] = new Array(this.board_size).fill("-");
        }
        
    }
    
    displayShips(target) {
        const table = document.createElement("table");
        
        for (let row = 0; row < this.board_size; row++) {
            const tr = document.createElement("tr");
            for (let col = 0; col < this.board_size; col++) {
                const td = document.createElement("td");
                td.textContent = this.ships[row][col];
                tr.appendChild(td);
            }
            table.appendChild(tr);
        }
        target.appendChild(table);  // Inject the tabe into the target element
    }
    
    displayShots(target) {
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
    }
    
    toJSON() {
        return {
            "board-ships": JSON.stringify(this.ships),
            "board-shots": JSON.stringify(this.shots)
        };
    }
    
    fromJSON(json) {
        //NOT IMPLEMENTED
    }
    
}