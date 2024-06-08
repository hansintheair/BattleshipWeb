
function saveGameToCookie(p1, p2) {
    setCookie("p1", p1);
    setCookie("p2", p2);
}

function loadGameFromCookie(p1, p2) {
    p1.fromJSON(getCookie("p1"));
    p2.fromJSON(getCookie("p2"));
}

async function saveGameToDB(p1, p2) {
    await fetch("SaveGameHandler.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `p1=${encodeURIComponent(p1.toJSON())}&p2=${encodeURIComponent(p2.toJSON())}`
        }
    );
}

async function loadGameFromDB(p1, p2) {
    
}