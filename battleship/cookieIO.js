

function setCookie(key, value, expiry=null, paths=null) {
    
//    console.log("IN setCookie");  //DEBUG
//    console.log("SAVING (RAW): " + obj.toJSON());  //DEBUG
    
    if (typeof(value) === "string") {
//        console.log("STRING INSTANCE");  //DEBUG
        value = encodeURIComponent(value);
    }
    else if (value instanceof Player)
    {
//        console.log("PLAYER INSTANCE!");  //DEBUG
        value = encodeURIComponent(value.toJSON());
    }
        
//    console.log(value);  //DEBUG

    document.cookie = `${key}=${value}; expires=${expiry}; path=${paths};`;

}

function setCookieFromEncodedJSON(key, value, expiry=null, paths=null) {
    document.cookie = `${key}=${value}; expires=${expiry}; path=${paths};`;
}

function getCookie(key) {
    
//    console.log("IN getCookie");  //DEBUG
    const pattern = new RegExp("(?:^| )" + key + "=([^;]*);");
    const result = document.cookie.match(pattern);
//    console.log("LOADED (RAW): " + result);  //DEBUG
    return result ? decodeURIComponent(result[1]) : null;
}    
