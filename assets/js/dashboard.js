let isLoadingVault = false;

let allVaults = [];

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

        showLoading(
            vaultList
        );

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

        const vaults =
            await getVaults();

        allVaults = vaults;

        populateServiceFilter(vaults);

        if(vaults.length === 0){

            showEmptyState(
                vaultList
            );

            return;

        }

        vaultList.innerHTML = "";

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

function logout(){

    clearCryptoCache();

    sessionStorage.clear();

    showPage(
        "loginPage"
    );

}

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

async function filterVaults(){

    const vaultList =
        document.getElementById(
            "vaultList"
        );

    const search =
        document
        .getElementById(
            "searchVault"
        )
        .value
        .toLowerCase();

    const filter =
        document
        .getElementById(
            "filterService"
        )
        .value;

    vaultList.innerHTML = "";

    for(
        const vault
        of allVaults
    ){

        try{

            const decrypted =
                await decryptData({

                    data:
                        vault.encrypted_data,

                    iv:
                        vault.iv

                });

            const strength =
                getPasswordStrength(
                    decrypted.password
                );

            const matchSearch =

            decrypted.service
            .toLowerCase()
            .includes(search)

            ||

            decrypted.username
            .toLowerCase()
            .includes(search)

            ||

            (
                decrypted.note || ""
            )
            .toLowerCase()
            .includes(search);

            let matchFilter =
                true;

            if(
                filter !== "all"
            ){

                matchFilter =

                    decrypted.service ===
                    filter;

            }

            if(
                matchSearch &&
                matchFilter
            ){

                await createVaultRow(
                    vault,
                    vaultList
                );

            }

        }catch(error){

            console.log(error);

        }

    }

    if(
        vaultList.innerHTML
        .trim() === ""
    ){

        showErrorState(
            vaultList,
            "Data tidak ditemukan"
        );

    }

}

async function populateServiceFilter(vaults){

    const select =
        document.getElementById(
            "filterService"
        );

    if(!select){

        return;

    }

    select.innerHTML = `

        <option value="all">
            Semua Service
        </option>

    `;

    const services =
        new Set();

    for(
        const vault
        of vaults
    ){

        try{

            const decrypted =
                await decryptData({

                    data:
                        vault.encrypted_data,

                    iv:
                        vault.iv

                });

            if(
                decrypted.service
            ){

                services.add(
                    decrypted.service
                );

            }

        }catch(error){

            console.log(error);

        }

    }

    services.forEach(service => {

        const option =
            document.createElement(
                "option"
            );

        option.value =
            service;

        option.textContent =
            service;

        select.appendChild(
            option
        );

    });

}

window.addEventListener(

    "DOMContentLoaded",

    () => {

        const searchInput =
            document.getElementById(
                "searchVault"
            );

        const filterSelect =
            document.getElementById(
                "filterService"
            );

        if(searchInput){

            searchInput
            .addEventListener(
                "input",
                filterVaults
            );

        }

        if(filterSelect){

            filterSelect
            .addEventListener(
                "change",
                filterVaults
            );

        }

    }

);