let timeout = null;

function logout(){

    cachedKey = null;

    sessionStorage.clear();

    clearTimeout(timeout);

    showPage(
                "loginPage"
            );

}

function resetTimer(){

    clearTimeout(timeout);

    timeout = setTimeout(() => {

        cachedKey = null;

        sessionStorage.clear();

        alert(
            "Session expired"
        );

        showPage(
                "loginPage"
            );

    }, 300000);

}

[
    "mousemove",
    "mousedown",
    "keypress",
    "touchstart",
    "scroll",
    "click"
]

.forEach(event => {

    window.addEventListener(

        event,

        resetTimer,

        {
            passive:true
        }

    );

});

resetTimer();