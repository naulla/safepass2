// =========================
// vault-ui.js
// =========================

// LOADING

function showLoading(vaultList){

    vaultList.innerHTML = "";

    const row =
        document.createElement(
            "tr"
        );

    const cell =
        document.createElement(
            "td"
        );

    cell.colSpan = 6;

    cell.style.textAlign =
        "center";

    cell.style.padding =
        "20px";

    cell.textContent =
        "Loading vault...";

    row.appendChild(cell);

    vaultList.appendChild(row);

}

// EMPTY STATE

function showEmptyState(vaultList){

    vaultList.innerHTML = "";

    const row =
        document.createElement(
            "tr"
        );

    const cell =
        document.createElement(
            "td"
        );

    cell.colSpan = 6;

    cell.style.textAlign =
        "center";

    cell.style.padding =
        "20px";

    cell.textContent =
        "Belum ada password tersimpan";

    row.appendChild(cell);

    vaultList.appendChild(row);

}

// ERROR STATE

function showErrorState(
    vaultList,
    message
){

    vaultList.innerHTML = "";

    const row =
        document.createElement(
            "tr"
        );

    const cell =
        document.createElement(
            "td"
        );

    cell.colSpan = 6;

    cell.style.textAlign =
        "center";

    cell.style.padding =
        "20px";

    cell.style.color =
        "red";

    cell.textContent =
        message;

    row.appendChild(cell);

    vaultList.appendChild(row);

}

// CREATE VAULT ROW

async function createVaultRow(
    vault,
    vaultList
){

    const encrypted = {

        data:
            vault.encrypted_data,

        iv:
            vault.iv

    };

    const decrypted =
        await decryptData(
            encrypted
        );

    const tr =
        document.createElement(
            "tr"
        );

    // SERVICE

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

    // USERNAME

    const tdUsername =
        document.createElement(
            "td"
        );

    tdUsername.textContent =
        decrypted.username;

    // PASSWORD

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

    // TOGGLE BUTTON

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

    // COPY BUTTON

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
    // PASSWORD STATUS
    // =========================

    const tdStatus =
        document.createElement(
            "td"
        );

    const strength =
        getPasswordStrength(
            decrypted.password
        );

    const statusBadge =
        document.createElement(
            "span"
        );

    statusBadge.className =
        "status-badge "
        + strength.className;

    statusBadge.textContent =
        strength.label;

    // =========================
    // HIBP CHECK
    // =========================

    checkPwnedPassword(

        decrypted.password

    ).then(isPwned => {

        if(isPwned){

            statusBadge.textContent =
                "Pernah Bocor";

            statusBadge.className =
                "status-badge strength-pwned";

        }

    });

    tdStatus.appendChild(
        statusBadge
    );

    // NOTE

    const tdNote =
        document.createElement(
            "td"
        );

    tdNote.textContent =
        decrypted.note || "-";

    // ACTION

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

    // EDIT

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

    // DELETE

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

    // APPEND

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
        tdStatus
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

}

// TOGGLE PASSWORD

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

// COPY PASSWORD

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