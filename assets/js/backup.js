// =========================
// EXPORT ENCRYPTED BACKUP
// =========================

async function exportEncryptedBackup(){

    try{

        // =========================
        // GET VAULT
        // =========================

        const vaults =
            await getVaults();

        // =========================
        // VALIDASI
        // =========================

        if(vaults.length === 0){

            alert(
                "Vault kosong"
            );

            return;

        }

        // =========================
        // BACKUP OBJECT
        // =========================

        const backup = {

            type:
                "SafePass Backup",

            version:
                "1.0",

            created_at:
                new Date()
                .toISOString(),

            vaults:
                vaults.map(vault => ({

                    encrypted_data:
                        vault.encrypted_data,

                    iv:
                        vault.iv

                }))

        };

        // =========================
        // JSON
        // =========================

        const json =
            JSON.stringify(

                backup,

                null,

                2

            );

        // =========================
        // DOWNLOAD
        // =========================

        downloadBackup(

            json,

            "safepass-backup.json"

        );

    }catch(error){

        console.log(error);

        alert(
            "Gagal export backup"
        );

    }

}

// =========================
// IMPORT ENCRYPTED BACKUP
// =========================

async function importEncryptedBackup(
    event
){

    try{

        // =========================
        // FILE
        // =========================

        const file =
            event.target.files[0];

        if(!file){

            return;

        }

        // =========================
        // READ FILE
        // =========================

        const text =
            await file.text();

        // =========================
        // PARSE JSON
        // =========================

        const backup =
            JSON.parse(text);

        // =========================
        // VALIDASI TYPE
        // =========================

        if(

            backup.type !==
            "SafePass Backup"

        ){

            throw new Error(
                "File backup invalid"
            );

        }

        // =========================
        // VALIDASI VAULT
        // =========================

        if(

            !Array.isArray(
                backup.vaults
            )

        ){

            throw new Error(
                "Format vault invalid"
            );

        }

        // =========================
        // LOOP IMPORT
        // =========================

        for(

            let vault of
            backup.vaults

        ){

            // =========================
            // VALIDASI FIELD
            // =========================

            if(

                !vault.encrypted_data ||

                !vault.iv

            ){

                continue;

            }

            // =========================
            // IMPORT
            // =========================

            const response =
                await fetch(

                    "api/import_backup.php",

                    {

                        method:"POST",

                        headers:{
                            "Content-Type":
                                "application/json"
                        },

                        body:JSON.stringify({

                            encrypted_data:{

                                data:
                                    vault
                                    .encrypted_data,

                                iv:
                                    vault.iv

                            }

                        })

                    }

                );

            // =========================
            // SERVER ERROR
            // =========================

            if(!response.ok){

                throw new Error(
                    "Import gagal"
                );

            }

            // =========================
            // READ RESPONSE
            // =========================

            const textResponse =
                await response.text();

            console.log(
                "IMPORT RESPONSE:",
                textResponse
            );

            // =========================
            // PARSE JSON
            // =========================

            const result =
                JSON.parse(
                    textResponse
                );

            // =========================
            // RESULT
            // =========================

            if(

                result.status !==
                "success"

            ){

                throw new Error(
                    "Import gagal"
                );

            }

        }

        // =========================
        // SUCCESS
        // =========================

        alert(
            "Backup berhasil diimport"
        );

        await loadVault();

    }catch(error){

        console.log(error);

        alert(
            "Gagal import backup"
        );

    }

}

// =========================
// DOWNLOAD BACKUP
// =========================

function downloadBackup(

    content,
    filename

){

    const blob =
        new Blob(

            [content],

            {
                type:"application/json"
            }

        );

    const url =
        URL.createObjectURL(
            blob
        );

    const a =
        document.createElement(
            "a"
        );

    a.href = url;

    a.download =
        filename;

    document.body.appendChild(
        a
    );

    a.click();

    a.remove();

    URL.revokeObjectURL(
        url
    );

}