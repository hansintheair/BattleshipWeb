
function saveGameToCookie(p1, p2) {
    setCookie("p1", p1);
    setCookie("p2", p2);
}

function loadGameFromCookie(p1, p2) {
    p1.fromJSON(getCookie("p1"));
    p2.fromJSON(getCookie("p2"));
}