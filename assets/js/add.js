async function saveVault(){

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

    if(btn.disabled){

        return;

    }

    btn.disabled = true;

    btn.innerText =
        "Menyimpan...";

    try{

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

        try{

            await getAESKey();

        }catch{

            alert(
                "AES Key hilang, silakan login ulang"
            );

            logout();

            return;

        }

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

        const encrypted =
            await encryptData(
                vaultData
            );

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

        if(!response.ok){

            throw new Error(
                "Server error"
            );

        }

        const result =
            await response.json();

        if(
            result.status ===
            "success"
        ){

            alert(
                "Vault berhasil disimpan"
            );

            serviceInput.value = "";

            usernameInput.value = "";

            passwordInput.value = "";

            noteInput.value = "";

            showPage(
                "dashboardPage"
            );

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

        btn.disabled = false;

        btn.innerText =
            "Simpan";

    }

}