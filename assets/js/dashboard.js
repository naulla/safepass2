// =========================
// dashboard.js
// =========================

let isLoadingVault = false;

// =========================
// GET VAULTS
// =========================

async function getVaults(){

    const user_id =
        sessionStorage.getItem(
            "user_id"
        );

    if(!user_id){

        throw new Error(
            "Session login habis"
        );

    }

    const response =
        await fetch(
            "api/get_vault.php",
            {
                method:"POST",

                headers:{
                    "Content-Type":
                        "application/json"
                },

                body:JSON.stringify({
                    user_id:user_id
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

        throw new Error(
            "Load vault gagal"
        );

    }

    return result.data || [];

}

// =========================
// DELETE VAULT API
// =========================

async function deleteVaultApi(id){

    const response =
        await fetch(
            "api/delete_vault.php",
            {
                method:"POST",

                headers:{
                    "Content-Type":
                        "application/json"
                },

                body:JSON.stringify({
                    id:id
                })
            }
        );

    if(!response.ok){

        throw new Error(
            "Server error"
        );

    }

    return await response.json();

}

// =========================
// LOAD VAULT
// =========================

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

        if(!vaultList){

            console.log(
                "vaultList tidak ditemukan"
            );

            return;

        }

        // =========================
        // SHOW LOADING
        // =========================

        showLoading(
            vaultList
        );

        // =========================
        // LOAD AES KEY
        // =========================

        try{

            await getAESKey();

        }catch(error){

            console.log(
                "AES KEY ERROR:",
                error
            );

            showErrorState(
                vaultList,
                "Silakan login ulang"
            );

            return;

        }

        // =========================
        // GET DATA
        // =========================

        const vaults =
            await getVaults();

        // =========================
        // EMPTY STATE
        // =========================

        if(vaults.length === 0){

            showEmptyState(
                vaultList
            );

            return;

        }

        // =========================
        // CLEAR TABLE
        // =========================

        vaultList.innerHTML = "";

        // =========================
        // RENDER ROW
        // =========================

        for(
            const vault
            of vaults
        ){

            try{

                await createVaultRow(
                    vault,
                    vaultList
                );

            }catch(error){

                console.log(
                    "CREATE ROW ERROR:",
                    error
                );

            }

        }

        // =========================
        // CHECK IF FAILED
        // =========================

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

// =========================
// DELETE VAULT
// =========================

async function deleteVault(id){

    const konfirmasi =
        confirm(
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

            await loadVault();

        }else{

            alert(
                "Gagal hapus vault"
            );

        }

    }catch(error){

        console.log(
            "DELETE ERROR:",
            error
        );

        alert(
            "Terjadi error"
        );

    }

}

// =========================
// OPEN EDIT PAGE
// =========================

function openEdit(id){

    sessionStorage.setItem(
        "editVaultId",
        id
    );

    showPage(
        "editPage"
    );

    if(
        typeof loadEditVault ===
        "function"
    ){

        loadEditVault(id);

    }

}

// =========================
// LOGOUT
// =========================

function logout(){

    clearCryptoCache();

    sessionStorage.clear();

    showPage(
        "loginPage"
    );

}

// =========================
// AUTO LOAD
// =========================

window.addEventListener(

    "DOMContentLoaded",

    async () => {

        if(
            sessionStorage.getItem(
                "isLoggedIn"
            )
        ){

            showPage(
                "dashboardPage"
            );

            await loadVault();

        }else{

            showPage(
                "loginPage"
            );

        }

    }

);