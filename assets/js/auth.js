// =========================
// REGISTER FORM
// =========================

document.getElementById("registerForm")
.addEventListener("submit", async function(e){

    e.preventDefault();

    const btn =
        document.getElementById(
            "registerBtn"
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
                "registerEmail"
            )
            .value
            .trim()
            .toLowerCase();

        const password =
            document.getElementById(
                "registerPassword"
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
        // PASSWORD MINIMAL
        // =========================

        if(password.length < 8){

            alert(
                "Password minimal 8 karakter"
            );

            return;

        }

        // =========================
        // PBKDF2 ITERATIONS
        // =========================

        const iterations =
            PBKDF2_ITERATIONS;

        // =========================
        // GENERATE SALT
        // =========================

        const salt =
            generateSalt();

        // =========================
        // GENERATE VERIFIER
        // =========================

        const verifier =
            await generateVerifier(

                password,

                salt,

                iterations

            );

        // =========================
        // BASE64 SALT
        // =========================

        const saltBase64 =
            bufToBase64(salt);

        // =========================
        // REQUEST REGISTER
        // =========================

        const response =
            await fetch(

                "api/register.php",

                {

                    method:"POST",

                    headers:{
                        "Content-Type":
                            "application/json"
                    },

                    body:JSON.stringify({

                        email: email,

                        verifier: verifier,

                        salt: saltBase64,

                        iterations:
                            iterations

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

        // =========================
        // VALIDASI JSON
        // =========================

        let data = null;

        try{

            data =
                await response.json();

        }catch{

            throw new Error(
                "JSON invalid"
            );

        }

        // =========================
        // SUCCESS
        // =========================

        if(data.status === "success"){

            document.getElementById(
                "registerPassword"
            ).value = "";

            alert(
                "Register berhasil"
            );

            // =========================
            // PINDAH KE LOGIN SPA
            // =========================

            showPage(
                "loginPage"
            );

        }else{

            alert(
                data.message ||
                "Register gagal"
            );

        }

    }catch(error){

        console.log(
            "REGISTER ERROR:",
            error
        );

        alert(
            "Terjadi error saat register"
        );

    }finally{

        // =========================
        // ENABLE BUTTON
        // =========================

        btn.disabled = false;

        btn.innerText = "Register";

    }

});