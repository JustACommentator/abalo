if(cookieIsEnabled() == "true") {
    hideBanner();
}

function acceptedCookies() {
    enableCookies();
    hideBanner();
} //accepts cookies if user accepts

function hideBanner() {
    document.m("cookieBanner").style.display = "none";
} //hides banner

function setCookie(cookieName, cookieValue, expiresInDays) {
    const date = new Date();
    date.setTime(date.getTime() + (expiresInDays*86400000));
    let expires = "expires="+ date.toUTCString();
    document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
}

function getCookie(cookieName) {
    let name = cookieName + "=";
    let decodedCookie = decodeURIComponent(document.cookie.replace(/\s/g, '')); //remove spaces
    let cookieArray = decodedCookie.split(';'); //split cookiestring into array
    for(let i = 0; i <cookieArray.length; i++) { //if target cookie is in array, remove everything up to and including "=" and return the remaining string
        if(cookieArray[i].indexOf(name) != -1) {
            return cookieArray[i].replace(name, '');
        }
    }
    return "";
} //splits cookie string at semicolon and checks for value of specified cookie

function deleteCookie(cookieName) {
    document.cookie = cookieName + "=;expires=Thu, 01 Jan 1970 00:00:01 GMT;path=/";
}

function enableCookies() {
    console.log("Cookies enabled");
    setCookie("cookiesEnabled", true, 7);
}

function disableCookies() {
    console.log("Cookies disabled");
    deleteCookie("cookiesEnabled");
}

function cookieIsEnabled() {
    return getCookie("cookiesEnabled");
}
