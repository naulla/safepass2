document.getElementById("registerForm")
.addEventListener("submit", async function(e){

    e.preventDefault();

    const btn =
        document.getElementById(
            "registerBtn"
        );

    if(btn.disabled){

        return;

    }

    btn.disabled = true;

    btn.innerText = "Loading...";

    try{

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

        if(!email || !password){

            alert(
                "Email dan password wajib diisi"
            );

            return;

        }

        const emailRegex =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if(!emailRegex.test(email)){

            alert(
                "Format email tidak valid"
            );

            return;

        }

        if(password.length < 8){

            alert(
                "Password minimal 8 karakter"
            );

            return;

        }

        const iterations =
            PBKDF2_ITERATIONS;

        const salt =
            generateSalt();

        const verifier =
            await generateVerifier(

                password,

                salt,

                iterations

            );

        const saltBase64 =
            bufToBase64(salt);

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

        if(!response.ok){

            throw new Error(
                "Server error"
            );

        }

        let data = null;

        try{

            data =
                await response.json();

        }catch{

            throw new Error(
                "JSON invalid"
            );

        }

        if(data.status === "success"){

            document.getElementById(
                "registerPassword"
            ).value = "";

            alert(
                "Register berhasil"
            );

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

        btn.disabled = false;

        btn.innerText = "Register";

    }

});