document.getElementById("loginForm")
.addEventListener("submit", async function(e){

    e.preventDefault();

    const btn =
        document.getElementById(
            "loginBtn"
        );

    if(btn.disabled){

        return;

    }

    btn.disabled = true;

    btn.innerText = "Loading...";

    try{

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

        if(!email || !password){

            alert(
                "Email dan password wajib diisi"
            );

            return;

        }

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

        if(!response.ok){

            throw new Error(
                "Server error"
            );

        }

        const result =
            await response.json();

        if(
            result.status !==
            "success"
        ){

            alert(
                "Email atau password salah"
            );

            return;

        }

        const user =
            result.data;

        const salt =
            base64ToBuf(
                user.salt
            );

        const verifier =
            await generateVerifier(

                password,

                salt,

                user.iterations

            );

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

        if(!verifyResponse.ok){

            throw new Error(
                "Verify server error"
            );

        }

        const verifyResult =
            await verifyResponse.json();

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

        setAESKey(key);

        document.getElementById(
            "loginPassword"
        ).value = "";

        sessionStorage.setItem(

            "user_id",

            String(user.id)

        );

        sessionStorage.setItem(

            "isLoggedIn",

            "true"

        );

        showPage(
            "dashboardPage"
        );

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