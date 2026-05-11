let timeout;

function logout(){

    // hapus AES key cache

    cachedKey = null;

    // hapus session

    sessionStorage.clear();

    // redirect

    window.location =
        "login.php";

}



// reset timer

function resetTimer(){

    clearTimeout(timeout);

    timeout = setTimeout(() => {

        alert(
            "Session expired"
        );

        cachedKey = null;

        sessionStorage.clear();

        window.location =
            "login.php";

    }, 300000); // 5 menit

}

// event activity

window.onload = resetTimer;

document.onmousemove = resetTimer;

document.onkeypress = resetTimer;

document.onclick = resetTimer;

document.onscroll = resetTimer;