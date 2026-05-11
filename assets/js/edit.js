async function loadSingleVault(){

    const response = await fetch(
        "api/get_single_vault.php?id=" + vaultId
    );

    const vault = await response.json();

    const encrypted = {

    data:vault.encrypted_data,

    salt:vault.salt,

    iv:vault.iv

};

    const decrypted =
        await decryptData(
            encrypted,
            sessionStorage.getItem("masterKey")
        );

    document.getElementById("service").value =
        decrypted.service;

    document.getElementById("username").value =
        decrypted.username;

    document.getElementById("password").value =
        decrypted.password;

    document.getElementById("note").value =
        decrypted.note;

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

        alert("Vault berhasil diupdate");

        window.location = "dashboard.php";

    });

}

loadSingleVault();