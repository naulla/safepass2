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
    // CEGAH SPAM KLIK
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
                "loginEmail"
            )
            .value
            .trim()
            .toLowerCase();

        const password =
            document.getElementById(
                "loginPassword"
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
        // AMBIL LOGIN DATA
        // =========================

        const response =
            await fetch(

                "api/get_login_data.php",

                {

                    method:"POST",

                    headers:{
                        "Content-Type":
                            "application/json"
                    },

                    body:JSON.stringify({

                        email:email

                    })

                }

            );

        // =========================
        // SERVER ERROR
        // =========================

        if(!response.ok){

            throw new Error(
                "Server error"
            );

        }

        const result =
            await response.json();

        // =========================
        // USER TIDAK ADA
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
        // SALT
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
        // VERIFY LOGIN
        // =========================

        const verifyResponse =
            await fetch(

                "api/verify_login.php",

                {

                    method:"POST",

                    headers:{
                        "Content-Type":
                            "application/json"
                    },

                    body:JSON.stringify({

                        email:email,

                        verifier:verifier

                    })

                }

            );

        // =========================
        // VERIFY ERROR
        // =========================

        if(!verifyResponse.ok){

            throw new Error(
                "Verify server error"
            );

        }

        const verifyResult =
            await verifyResponse.json();

        // =========================
        // PASSWORD SALAH
        // =========================

        if(
            verifyResult.status !==
            "success"
        ){

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

        setAESKey(key);

        // =========================
        // CLEAR PASSWORD
        // =========================

        document.getElementById(
            "loginPassword"
        ).value = "";

        // =========================
        // SESSION
        // =========================

        sessionStorage.setItem(

            "user_id",

            String(user.id)

        );

        sessionStorage.setItem(

            "isLoggedIn",

            "true"

        );

        // =========================
        // SHOW DASHBOARD SPA
        // =========================

        showPage(
            "dashboardPage"
        );

        // =========================
        // LOAD VAULT
        // =========================

        if(
            typeof loadVault ===
            "function"
        ){

            loadVault();

        }

    }catch(error){

        console.log(
            "LOGIN ERROR:",
            error
        );

        alert(
            "Terjadi error saat login"
        );

    }finally{

        btn.disabled = false;

        btn.innerText = "Login";

    }

});