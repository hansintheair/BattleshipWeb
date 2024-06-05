

function setCookie(key, obj, expiry=null, paths=null) {
    
//    console.log("IN setCookie");  //DEBUG
//    console.log("SAVING (RAW): " + obj.toJSON());  //DEBUG
    
    const value = encodeURIComponent(obj.toJSON());

    document.cookie = `${key}=${value}; expires=${expiry}; path=${paths};`;

}
    
function getCookie(key) {
    
//    console.log("IN getCookie");  //DEBUG
    const pattern = new RegExp("(?:^| )" + key + "=([^;]*);");
    const result = document.cookie.match(pattern);
//    console.log("LOADED (RAW): " + result);  //DEBUG
    return result ? decodeURIComponent(result[1]) : null;
}    
