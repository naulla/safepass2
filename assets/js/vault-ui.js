function showLoading(vaultList){

    vaultList.innerHTML = "";

    const row =
        document.createElement("tr");

    const cell =
        document.createElement("td");

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

function showEmptyState(vaultList){

    vaultList.innerHTML = "";

    const row =
        document.createElement("tr");

    const cell =
        document.createElement("td");

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

function showErrorState(
    vaultList,
    message
){

    vaultList.innerHTML = "";

    const row =
        document.createElement("tr");

    const cell =
        document.createElement("td");

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
        document.createElement("tr");

    const tdService =
        document.createElement("td");

    const badge =
        document.createElement("span");

    badge.className =
        "badge";

    badge.textContent =
        decrypted.service;

    tdService.appendChild(badge);

    const tdUsername =
        document.createElement("td");

    tdUsername.textContent =
        decrypted.username;

    const tdPassword =
        document.createElement("td");

    const passWrapper =
        document.createElement("div");

    passWrapper.className =
        "password-field";

    const passInput =
        document.createElement("input");

    passInput.type =
        "password";

    passInput.value =
        decrypted.password;

    passInput.id =
        "vaultPass" + vault.id;

    passInput.readOnly =
        true;

    const toggleBtn =
        document.createElement("button");

    toggleBtn.className =
        "small-btn";

    toggleBtn.innerHTML =
        "👁";

    toggleBtn.addEventListener(
        "click",
        () => {

            toggleVaultPassword(
                vault.id
            );

        }
    );

    const copyBtn =
        document.createElement("button");

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

    const tdStatus =
        document.createElement("td");

    const strength =
        getPasswordStrength(
            decrypted.password
        );

    const statusBadge =
        document.createElement("span");

    statusBadge.className =
        "status-badge "
        + strength.className;

    statusBadge.textContent =
        strength.label;

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

    const tdNote =
        document.createElement("td");

    tdNote.textContent =
        decrypted.note || "-";

    const tdAction =
        document.createElement("td");

    const actionGroup =
        document.createElement("div");

    actionGroup.className =
        "action-group";

    const editBtn =
        document.createElement("button");

    editBtn.className =
        "small-btn";

    editBtn.textContent =
        "Edit";

    editBtn.addEventListener(
        "click",
        () => {

            openEdit(vault.id);

        }
    );

    const deleteBtn =
        document.createElement("button");

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
        editBtn
    );

    actionGroup.appendChild(
        deleteBtn
    );

    tdAction.appendChild(
        actionGroup
    );

    tr.appendChild(tdService);

    tr.appendChild(tdUsername);

    tr.appendChild(tdPassword);

    tr.appendChild(tdStatus);

    tr.appendChild(tdNote);

    tr.appendChild(tdAction);

    vaultList.appendChild(tr);

}

function toggleVaultPassword(id){

    const input =
        document.getElementById(
            "vaultPass" + id
        );

    if(!input){

        return;

    }

    if(
        input.type ===
        "password"
    ){

        input.type =
            "text";

    }else{

        input.type =
            "password";

    }

}

async function copyPassword(password){

    try{

        await navigator.clipboard
        .writeText(password);

        alert(
            "Password berhasil dicopy"
        );

    }catch(error){

        console.log(error);

        alert(
            "Gagal copy password"
        );

    }

}