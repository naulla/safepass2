// =========================
// LOGIN FORM
// =========================

document.getElementById("loginForm")
.addEventListener("submit", async function(e){

    e.preventDefault();

    const btn =
        document.getElementById(
            "loginBtn"
        );

    // =========================
    // CEGAH DOUBLE CLICK
    // =========================

    if(btn.disabled){

        return;

    }

    btn.disabled = true;

    btn.innerText = "Loading...";

    try{

        // =========================
        // INPUT
        // =========================

        const email =
            document.getElementById(
                "email"
            )
            .value
            .trim()
            .toLowerCase();

        const password =
            document.getElementById(
                "password"
            )
            .value;

        // =========================
        // VALIDASI
        // =========================

        if(!email || !password){

            alert(
                "Email dan password wajib diisi"
            );

            return;

        }

        // =========================
        // VALIDASI EMAIL
        // =========================

        const emailRegex =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if(!emailRegex.test(email)){

            alert(
                "Format email tidak valid"
            );

            return;

        }

        // =========================
        // FETCH TIMEOUT
        // =========================

        const controller =
            new AbortController();

        const timeout =
            setTimeout(() => {

                controller.abort();

            },10000);

        // =========================
        // FETCH USER
        // =========================

        const response =
            await fetch(

                "api/login.php",

                {

                    method:"POST",

                    headers:{
                        "Content-Type":
                            "application/json"
                    },

                    body:JSON.stringify({

                        email:email

                    }),

                    signal:
                        controller.signal

                }

            );

        clearTimeout(timeout);

        // =========================
        // SERVER ERROR
        // =========================

        if(!response.ok){

            throw new Error(
                "Server error"
            );

        }

        // =========================
        // VALIDASI JSON
        // =========================

        let result = null;

        try{

            result =
                await response.json();

        }catch{

            throw new Error(
                "JSON invalid"
            );

        }

        // =========================
        // STATUS ERROR
        // =========================

        if(
            result.status !==
            "success"
        ){

            alert(
                "Email atau password salah"
            );

            return;

        }

        // =========================
        // USER DATA
        // =========================

        const user =
            result.data;

        // =========================
        // VALIDASI USER
        // =========================

        if(
            !user ||
            !user.id ||
            !user.salt ||
            !user.verifier
        ){

            alert(
                "Email atau password salah"
            );

            return;

        }

        // =========================
        // DECODE SALT
        // =========================

        const salt =
            base64ToBuf(
                user.salt
            );

        // =========================
        // GENERATE VERIFIER
        // =========================

        const verifier =
            await generateVerifier(

                password,

                salt,

                user.iterations

            );

        // =========================
        // PASSWORD SALAH
        // =========================

        if(verifier !== user.verifier){

            alert(
                "Email atau password salah"
            );

            return;

        }

        // =========================
        // DERIVE AES KEY
        // =========================

        const key =
            await deriveKey(

                password,

                salt,

                user.iterations

            );

        // =========================
        // SAVE AES KEY
        // =========================

        await saveAESKey(key);

        // =========================
        // SESSION
        // =========================

        sessionStorage.setItem(

            "user_id",

            String(user.id)

        );

        sessionStorage.setItem(

            "salt",

            user.salt

        );

        sessionStorage.setItem(

            "iterations",

            String(user.iterations)

        );

        sessionStorage.setItem(

            "isLoggedIn",

            "true"

        );

        // =========================
        // REDIRECT
        // =========================

        window.location.replace(
            "dashboard.php"
        );

    }catch(error){

        console.log(
            "LOGIN ERROR:",
            error
        );

        // =========================
        // NETWORK TIMEOUT
        // =========================

        if(
            error.name ===
            "AbortError"
        ){

            alert(
                "Request timeout"
            );

        }else{

            alert(
                "Terjadi error saat login"
            );

        }

    }finally{

        // =========================
        // ENABLE BUTTON
        // =========================

        btn.disabled = false;

        btn.innerText = "Login";

    }

});