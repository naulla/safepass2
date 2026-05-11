// =========================
// SAVE VAULT
// =========================

async function saveVault(){

    const btn =
        document.getElementById(
            "saveBtn"
        );

    // =========================
    // CEGAH SPAM CLICK
    // =========================

    if(btn.disabled){

        return;

    }

    btn.disabled = true;

    btn.innerText =
        "Menyimpan...";

    try{

        // =========================
        // AMBIL INPUT
        // =========================

        const service =
            document.getElementById(
                "service"
            )
            .value
            .trim();

        const username =
            document.getElementById(
                "username"
            )
            .value
            .trim();

        const passwordField =
            document.getElementById(
                "password"
            )
            .value
            .trim();

        const note =
            document.getElementById(
                "note"
            )
            .value
            .trim();

        // =========================
        // VALIDASI
        // =========================

        if(

            !service ||
            !username ||
            !passwordField

        ){

            alert(
                "Semua field wajib diisi"
            );

            return;

        }

        // =========================
        // CEK LOGIN
        // =========================

        const user_id =
            sessionStorage.getItem(
                "user_id"
            );

        const aesKey =
            sessionStorage.getItem(
                "aesKey"
            );

        if(

            !user_id ||
            !aesKey

        ){

            alert(
                "Session login habis"
            );

            window.location =
                "login.php";

            return;

        }

        // =========================
        // DATA VAULT
        // =========================

        const vaultData = {

            service:
                service,

            username:
                username,

            password:
                passwordField,

            note:
                note

        };

        // =========================
        // ENCRYPT
        // =========================

        const encrypted =
            await encryptData(
                vaultData
            );

        // =========================
        // SAVE DATABASE
        // =========================

        const response =
            await fetch(

                "api/save_vault.php",

                {

                    method:"POST",

                    headers:{
                        "Content-Type":
                            "application/json"
                    },

                    body:JSON.stringify({

                        user_id:user_id,

                        encrypted_data:
                            encrypted

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
        // SUCCESS
        // =========================

        if(
            result.status ===
            "success"
        ){

            alert(
                "Vault berhasil disimpan"
            );

            window.location =
                "dashboard.php";

        }else{

            console.log(result);

            alert(
                "Gagal menyimpan vault"
            );

        }

    }catch(error){

        console.log(
            "SAVE ERROR:",
            error
        );

        alert(
            "Terjadi error saat menyimpan vault"
        );

    }finally{

        // =========================
        // ENABLE BUTTON
        // =========================

        btn.disabled = false;

        btn.innerText =
            "Simpan";

    }

}