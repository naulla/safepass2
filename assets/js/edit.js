async function loadSingleVault(){

    try{

        const response = await fetch(
            "api/get_single_vault.php?id=" + vaultId
        );

        const result = await response.json();

        console.log("RESULT:", result);

        if(result.status !== "success"){

            alert(result.message);
            return;

        }

        const vault = result.data;

        console.log("VAULT:", vault);

        const encrypted = {

            data: vault.encrypted_data,
            iv: vault.iv

        };

        console.log("ENCRYPTED:", encrypted);

        // CEK SEBELUM DECRYPT

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
            await decryptData(encrypted);

        console.log(
            "DECRYPTED:",
            decrypted
        );

        document.getElementById("service").value =
            decrypted.service || "";

        document.getElementById("username").value =
            decrypted.username || "";

        document.getElementById("password").value =
            decrypted.password || "";

        document.getElementById("note").value =
            decrypted.note || "";

    }catch(error){

        console.log(
            "LOAD ERROR:",
            error
        );

    }

}

async function updateVault(){

    const vaultData = {

        service:
        document.getElementById("service").value,

        username:
        document.getElementById("username").value,

        password:
        document.getElementById("password").value,

        note:
        document.getElementById("note").value

    };

    const encrypted =
        await encryptData(
            vaultData,
            sessionStorage.getItem("masterKey")
        );

    fetch("api/update_vault.php",{

        method:"POST",

        headers:{
            "Content-Type":"application/json"
        },

        body:JSON.stringify({

            id:vaultId,
            encrypted_data:encrypted

        })

    })
    .then(res=>res.json())
    .then(data=>{

        if(data.status === "success"){

            alert("Vault berhasil diupdate");

            window.location = "dashboard.php";

        }else{

            alert(data.message);

        }

    });

}

loadSingleVault();