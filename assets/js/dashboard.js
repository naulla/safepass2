// =========================
// LOAD VAULT
// =========================

let isLoadingVault = false;

async function loadVault(){

    // =========================
    // CEGAH DOUBLE LOAD
    // =========================

    if(isLoadingVault){

        return;

    }

    isLoadingVault = true;

    try{

        // =========================
        // SESSION
        // =========================

        const user_id =
            sessionStorage.getItem(
                "user_id"
            );

        const isLoggedIn =
            sessionStorage.getItem(
                "isLoggedIn"
            );

        // =========================
        // VALIDASI LOGIN
        // =========================

        if(
            !user_id ||
            !isLoggedIn
        ){

            window.location =
                "login.php";

            return;

        }

        // =========================
        // ELEMENT
        // =========================

        const vaultList =
            document.getElementById(
                "vaultList"
            );

        // =========================
        // LOADING STATE
        // =========================

        vaultList.innerHTML = "";

        const loadingRow =
            document.createElement("tr");

        const loadingCell =
            document.createElement("td");

        loadingCell.colSpan = 5;

        loadingCell.style.textAlign =
            "center";

        loadingCell.style.padding =
            "20px";

        loadingCell.textContent =
            "Loading vault...";

        loadingRow.appendChild(
            loadingCell
        );

        vaultList.appendChild(
            loadingRow
        );

        // =========================
        // FETCH VAULT
        // =========================

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

        // =========================
        // SERVER ERROR
        // =========================

        if(!response.ok){

            throw new Error(
                "Gagal mengambil data"
            );

        }

        // =========================
        // VALIDASI JSON
        // =========================

        let vaults = [];

        try{

            vaults =
                await response.json();

        }catch{

            throw new Error(
                "JSON invalid"
            );

        }

        // =========================
        // VALIDASI ARRAY
        // =========================

        if(!Array.isArray(vaults)){

            throw new Error(
                "Format vault invalid"
            );

        }

        // =========================
        // KOSONG
        // =========================

        if(vaults.length === 0){

            vaultList.innerHTML = "";

            const row =
                document.createElement(
                    "tr"
                );

            const cell =
                document.createElement(
                    "td"
                );

            cell.colSpan = 5;

            cell.style.textAlign =
                "center";

            cell.style.padding =
                "20px";

            cell.textContent =
                "Belum ada password tersimpan";

            row.appendChild(cell);

            vaultList.appendChild(row);

            return;

        }

        // =========================
        // CEK AES KEY
        // =========================

        const aesKey =
            sessionStorage.getItem(
                "aesKey"
            );

        if(!aesKey){

            throw new Error(
                "AES Key hilang"
            );

        }

        // =========================
        // CLEAR TABLE
        // =========================

        vaultList.innerHTML = "";

        // =========================
        // LOOP VAULT
        // =========================

        for(let vault of vaults){

            try{

                // =========================
                // YIELD UI
                // =========================

                await new Promise(

                    resolve =>

                        setTimeout(
                            resolve,
                            0
                        )

                );

                // =========================
                // ENCRYPTED OBJECT
                // =========================

                const encrypted = {

                    data:
                        vault.encrypted_data,

                    iv:
                        vault.iv

                };

                // =========================
                // DECRYPT
                // =========================

                const decrypted =
                    await decryptData(
                        encrypted
                    );

                // =========================
                // CREATE ROW
                // =========================

                const tr =
                    document.createElement(
                        "tr"
                    );

                // =========================
                // SERVICE
                // =========================

                const tdService =
                    document.createElement(
                        "td"
                    );

                const badge =
                    document.createElement(
                        "span"
                    );

                badge.className =
                    "badge";

                badge.textContent =
                    decrypted.service;

                tdService.appendChild(
                    badge
                );

                // =========================
                // USERNAME
                // =========================

                const tdUsername =
                    document.createElement(
                        "td"
                    );

                tdUsername.textContent =
                    decrypted.username;

                // =========================
                // PASSWORD
                // =========================

                const tdPassword =
                    document.createElement(
                        "td"
                    );

                const passWrapper =
                    document.createElement(
                        "div"
                    );

                passWrapper.className =
                    "password-field";

                const passInput =
                    document.createElement(
                        "input"
                    );

                passInput.type =
                    "password";

                passInput.value =
                    decrypted.password;

                passInput.id =
                    "pass" + vault.id;

                passInput.readOnly =
                    true;

                // tombol show

                const toggleBtn =
                    document.createElement(
                        "button"
                    );

                toggleBtn.className =
                    "small-btn";

                toggleBtn.textContent =
                    "👁";

                toggleBtn.addEventListener(

                    "click",

                    () => {

                        togglePassword(
                            vault.id
                        );

                    }

                );

                // tombol copy

                const copyBtn =
                    document.createElement(
                        "button"
                    );

                copyBtn.className =
                    "small-btn";

                copyBtn.textContent =
                    "Copy";

                copyBtn.addEventListener(

                    "click",

                    () => {

                        copyPassword(
                            decrypted.password
                        );

                    }

                );

                passWrapper.appendChild(
                    passInput
                );

                passWrapper.appendChild(
                    toggleBtn
                );

                passWrapper.appendChild(
                    copyBtn
                );

                tdPassword.appendChild(
                    passWrapper
                );

                // =========================
                // NOTE
                // =========================

                const tdNote =
                    document.createElement(
                        "td"
                    );

                tdNote.textContent =
                    decrypted.note || "-";

                // =========================
                // ACTION
                // =========================

                const tdAction =
                    document.createElement(
                        "td"
                    );

                const actionGroup =
                    document.createElement(
                        "div"
                    );

                actionGroup.className =
                    "action-group";

                // edit link

                const editLink =
                    document.createElement(
                        "a"
                    );

                editLink.href =
                    "edit.php?id="
                    + vault.id;

                const editBtn =
                    document.createElement(
                        "button"
                    );

                editBtn.className =
                    "small-btn";

                editBtn.textContent =
                    "Edit";

                editLink.appendChild(
                    editBtn
                );

                // delete button

                const deleteBtn =
                    document.createElement(
                        "button"
                    );

                deleteBtn.className =
                    "small-btn";

                deleteBtn.textContent =
                    "Hapus";

                deleteBtn.addEventListener(

                    "click",

                    () => {

                        deleteVault(
                            vault.id
                        );

                    }

                );

                actionGroup.appendChild(
                    editLink
                );

                actionGroup.appendChild(
                    deleteBtn
                );

                tdAction.appendChild(
                    actionGroup
                );

                // =========================
                // APPEND
                // =========================

                tr.appendChild(
                    tdService
                );

                tr.appendChild(
                    tdUsername
                );

                tr.appendChild(
                    tdPassword
                );

                tr.appendChild(
                    tdNote
                );

                tr.appendChild(
                    tdAction
                );

                vaultList.appendChild(
                    tr
                );

            }catch(err){

                console.log(
                    "DECRYPT ERROR:",
                    err
                );

            }

        }

        // =========================
        // JIKA SEMUA GAGAL
        // =========================

        if(
            vaultList.innerHTML
            .trim() === ""
        ){

            const row =
                document.createElement(
                    "tr"
                );

            const cell =
                document.createElement(
                    "td"
                );

            cell.colSpan = 5;

            cell.style.textAlign =
                "center";

            cell.style.color =
                "red";

            cell.style.padding =
                "20px";

            cell.textContent =
                "Gagal decrypt vault";

            row.appendChild(cell);

            vaultList.appendChild(
                row
            );

        }

    }catch(error){

        console.log(
            "LOAD VAULT ERROR:",
            error
        );

        const vaultList =
            document.getElementById(
                "vaultList"
            );

        vaultList.innerHTML = "";

        const row =
            document.createElement(
                "tr"
            );

        const cell =
            document.createElement(
                "td"
            );

        cell.colSpan = 5;

        cell.style.textAlign =
            "center";

        cell.style.color =
            "red";

        cell.style.padding =
            "20px";

        cell.textContent =
            "Gagal memuat vault";

        row.appendChild(cell);

        vaultList.appendChild(row);

    }finally{

        isLoadingVault = false;

    }

}


// =========================
// DELETE VAULT
// =========================

async function deleteVault(id){

    const konfirmasi = confirm(
        "Yakin ingin menghapus vault?"
    );

    if(!konfirmasi){

        return;

    }

    try{

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

        const result =
            await response.json();

        if(result.status === "success"){

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


// =========================
// TOGGLE PASSWORD
// =========================

function togglePassword(id){

    const input =
        document.getElementById(
            "pass" + id
        );

    if(!input){

        return;

    }

    if(input.type === "password"){

        input.type = "text";

    }else{

        input.type = "password";

    }

}


// =========================
// COPY PASSWORD
// =========================

async function copyPassword(password){

    try{

        await navigator.clipboard
        .writeText(password);

    }catch(error){

        console.log(error);

        alert(
            "Gagal copy password"
        );

    }

}


// =========================
// LOGOUT
// =========================

function logout(){

    clearCryptoCache();

    sessionStorage.clear();

    window.location =
        "login.php";

}


// =========================
// LOAD
// =========================

loadVault();