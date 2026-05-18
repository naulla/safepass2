// =========================
// dashboard.js
// =========================

let isLoadingVault = false;

// LOAD VAULT

async function loadVault(){

    if(isLoadingVault){

        return;

    }

    isLoadingVault = true;

    const vaultList =
        document.getElementById(
            "vaultList"
        );

    try{

        // LOADING

        showLoading(vaultList);

        // GET VAULT

        const vaults =
            await getVaults();

        // EMPTY

        if(vaults.length === 0){

            showEmptyState(
                vaultList
            );

            return;

        }

        // AES KEY CHECK

        const aesKey =
            sessionStorage.getItem(
                "aesKey"
            );

        if(!aesKey){

            throw new Error(
                "AES Key hilang"
            );

        }

        // CLEAR TABLE

        vaultList.innerHTML = "";

        // LOOP VAULT

        for(let vault of vaults){

            try{

                await new Promise(

                    resolve =>

                        setTimeout(
                            resolve,
                            0
                        )

                );

                await createVaultRow(

                    vault,
                    vaultList

                );

            }catch(error){

                console.log(
                    "DECRYPT ERROR:",
                    error
                );

            }

        }

        // ALL FAILED

        if(
            vaultList.innerHTML
            .trim() === ""
        ){

            showErrorState(

                vaultList,

                "Gagal decrypt vault"

            );

        }

    }catch(error){

        console.log(
            "LOAD VAULT ERROR:",
            error
        );

        showErrorState(

            vaultList,

            "Gagal memuat vault"

        );

    }finally{

        isLoadingVault = false;

    }

}

// DELETE VAULT

async function deleteVault(id){

    const konfirmasi = confirm(
        "Yakin ingin menghapus vault?"
    );

    if(!konfirmasi){

        return;

    }

    try{

        const result =
            await deleteVaultApi(id);

        if(
            result.status ===
            "success"
        ){

            alert(
                "Vault berhasil dihapus"
            );

            loadVault();

        }else{

            alert(
                "Gagal hapus vault"
            );

        }

    }catch(error){

        console.log(error);

        alert(
            "Terjadi error"
        );

    }

}

// LOGOUT

function logout(){

    clearCryptoCache();

    sessionStorage.clear();

    window.location =
        "login.php";

}

// LOAD

loadVault();