// =========================
// AUTO LOGOUT
// =========================

let timeout = null;

// =========================
// LOGOUT
// =========================

function logout(){

    // hapus AES key RAM

    cachedKey = null;

    // clear session

    sessionStorage.clear();

    // stop timer

    clearTimeout(timeout);

    // redirect

    showPage(
                "loginPage"
            );

}

// =========================
// RESET TIMER
// =========================

function resetTimer(){

    // clear timer lama

    clearTimeout(timeout);

    // buat timer baru

    timeout = setTimeout(() => {

        // =========================
        // CLEAR CRYPTO
        // =========================

        cachedKey = null;

        // =========================
        // CLEAR SESSION
        // =========================

        sessionStorage.clear();

        // =========================
        // ALERT
        // =========================

        alert(
            "Session expired"
        );

        // =========================
        // REDIRECT
        // =========================

        showPage(
                "loginPage"
            );

    }, 300000); // 5 menit

}

// =========================
// USER ACTIVITY
// =========================

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

// =========================
// START TIMER
// =========================

resetTimer();