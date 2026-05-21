// =========================
// vault-api.js
// =========================

// GET VAULTS

async function getVaults(){

    const user_id =
        sessionStorage.getItem(
            "user_id"
        );

    const isLoggedIn =
        sessionStorage.getItem(
            "isLoggedIn"
        );

    if(
        !user_id ||
        !isLoggedIn
    ){

        showPage(
                "loginPage"
            );

        return [];

    }

    const response =
        await fetch(

            "api/get_vault.php?user_id="
            + encodeURIComponent(
                user_id
            ),

            {
                method:"GET"
            }

        );

    if(!response.ok){

        throw new Error(
            "Gagal mengambil data"
        );

    }

    let vaults = [];

    try{

        vaults =
            await response.json();

    }catch{

        throw new Error(
            "JSON invalid"
        );

    }

    if(!Array.isArray(vaults)){

        throw new Error(
            "Format vault invalid"
        );

    }

    return vaults;

}

// DELETE VAULT

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