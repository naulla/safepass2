// =========================
// CURRENT VAULT ID
// =========================

let currentVaultId = null;

// =========================
// OPEN EDIT PAGE
// =========================

async function openEdit(id){

    currentVaultId = id;

    showPage(
        "editPage"
    );

    await loadSingleVault();

}

// =========================
// LOAD SINGLE VAULT
// =========================

async function loadSingleVault(){

    try{

        if(!currentVaultId){

            alert(
                "Vault ID tidak ditemukan"
            );

            return;

        }

        const response = await fetch(

            "api/get_single_vault.php?id="
            + currentVaultId

        );

        const result =
            await response.json();

        console.log(
            "RESULT:",
            result
        );

        if(
            result.status !==
            "success"
        ){

            alert(
                result.message
            );

            return;

        }

        const vault =
            result.data;

        console.log(
            "VAULT:",
            vault
        );

        const encrypted = {

            data:
                vault.encrypted_data,

            iv:
                vault.iv

        };

        console.log(
            "ENCRYPTED:",
            encrypted
        );

        if(
            !encrypted.data ||
            !encrypted.iv
        ){

            console.log(
                "DATA ATAU IV KOSONG"
            );

            return;

        }

        const decrypted =
            await decryptData(
                encrypted
            );

        console.log(
            "DECRYPTED:",
            decrypted
        );

        // =========================
        // SET FORM
        // =========================

        document.getElementById(
            "editService"
        ).value =
            decrypted.service || "";

        document.getElementById(
            "editUsername"
        ).value =
            decrypted.username || "";

        document.getElementById(
            "editPassword"
        ).value =
            decrypted.password || "";

        document.getElementById(
            "editNote"
        ).value =
            decrypted.note || "";

    }catch(error){

        console.log(
            "LOAD ERROR:",
            error
        );

    }

}

// =========================
// UPDATE VAULT
// =========================

async function updateVault(){

    try{

        if(!currentVaultId){

            alert(
                "Vault ID tidak ditemukan"
            );

            return;

        }

        const vaultData = {

            service:
            document.getElementById(
                "editService"
            ).value,

            username:
            document.getElementById(
                "editUsername"
            ).value,

            password:
            document.getElementById(
                "editPassword"
            ).value,

            note:
            document.getElementById(
                "editNote"
            ).value

        };

        const encrypted =
            await encryptData(
                vaultData
            );

        const response =
            await fetch(

                "api/update_vault.php",

                {

                    method:"POST",

                    headers:{
                        "Content-Type":
                        "application/json"
                    },

                    body:JSON.stringify({

    id:
        currentVaultId,

    encrypted_data:{

        data:
            encrypted.data,

        iv:
            encrypted.iv

    }

})

                }

            );

        const result =
            await response.json();

        if(
            result.status ===
            "success"
        ){

            alert(
                "Vault berhasil diupdate"
            );

            showPage(
                "dashboardPage"
            );

            await loadVault();

        }else{

            alert(
                result.message
            );

        }

    }catch(error){

        console.log(
            "UPDATE ERROR:",
            error
        );

        alert(
            "Gagal update vault"
        );

    }

}