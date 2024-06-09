
function saveGameToCookie(p1, p2) {
    setCookie("p1", p1);
    setCookie("p2", p2);

}

function loadGameFromCookie(p1, p2) {
    p1.fromJSON(getCookie("p1"));
    p2.fromJSON(getCookie("p2"));
}

async function saveGameToDB(p1, p2) {
    console.log("IN saveGameToDB");
    const p1_encoded = p1.toJSON();
    console.log(p1_encoded);
    const p2_encoded = p2.toJSON(); 
    console.log(p2_encoded);
    
    await fetch("SaveGameHandler.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/JSON"
            },
            body: JSON.stringify({p1: p1_encoded, p2: p2_encoded})
        }
    );
}

async function loadGameFromDB() {
    return await fetch("LoadGameHandler.php").then(response => response.json());
}