// =========================
// SAVE VAULT
// =========================

async function saveVault(){

    // =========================
    // BUTTON
    // =========================

    const btn =
        document.getElementById(
            "saveBtn"
        );

    if(!btn){

        console.log(
            "saveBtn tidak ditemukan"
        );

        return;

    }

    // =========================
    // CEGAH DOUBLE CLICK
    // =========================

    if(btn.disabled){

        return;

    }

    btn.disabled = true;

    btn.innerText =
        "Menyimpan...";

    try{

        // =========================
        // INPUT ELEMENT
        // =========================

        const serviceInput =
            document.getElementById(
                "service"
            );

        const usernameInput =
            document.getElementById(
                "username"
            );

        const passwordInput =
            document.getElementById(
                "password"
            );

        const noteInput =
            document.getElementById(
                "note"
            );

        // =========================
        // VALIDASI ELEMENT
        // =========================

        if(

            !serviceInput ||
            !usernameInput ||
            !passwordInput ||
            !noteInput

        ){

            throw new Error(
                "Form element tidak ditemukan"
            );

        }

        // =========================
        // AMBIL VALUE
        // =========================

        const service =
            serviceInput.value
            .trim();

        const username =
            usernameInput.value     
            .trim();

        const passwordField =
            passwordInput.value;

        const note =
            noteInput.value
            .trim();

        // =========================
        // VALIDASI INPUT
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
        // VALIDASI LOGIN
        // =========================

        const user_id =
            sessionStorage.getItem(
                "user_id"
            );

        if(!user_id){

            alert(
                "Session login habis"
            );

            showPage(
                "loginPage"
            );

            return;

        }

        // =========================
        // VALIDASI AES KEY
        // =========================

        try{

            await getAESKey();

        }catch{

            alert(
                "AES Key hilang, silakan login ulang"
            );

            logout();

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
        // ENCRYPT DATA
        // =========================

        const encrypted =
            await encryptData(
                vaultData
            );

        // =========================
        // REQUEST SAVE
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

                        user_id:
                            user_id,

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

        // =========================
        // JSON RESPONSE
        // =========================

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

            // =========================
            // RESET FORM
            // =========================

            serviceInput.value = "";

            usernameInput.value = "";

            passwordInput.value = "";

            noteInput.value = "";

            // =========================
            // KEMBALI DASHBOARD
            // =========================

            showPage(
                "dashboardPage"
            );

            // =========================
            // RELOAD VAULT
            // =========================

            if(
                typeof loadVault ===
                "function"
            ){

                loadVault();

            }

        }else{

            console.log(
                result
            );

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