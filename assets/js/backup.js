async function exportEncryptedBackup(){

    try{

        const vaults =
            await getVaults();

        if(vaults.length === 0){

            alert(
                "Vault kosong"
            );

            return;

        }

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

        const json =
            JSON.stringify(

                backup,

                null,

                2

            );

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

async function importEncryptedBackup(
    event
){

    try{

        const file =
            event.target.files[0];

        if(!file){

            return;

        }

        const text =
            await file.text();

        const backup =
            JSON.parse(text);

        if(

            backup.type !==
            "SafePass Backup"

        ){

            throw new Error(
                "File backup invalid"
            );

        }

        if(

            !Array.isArray(
                backup.vaults
            )

        ){

            throw new Error(
                "Format vault invalid"
            );

        }

        for(

            let vault of
            backup.vaults

        ){

            if(

                !vault.encrypted_data ||

                !vault.iv

            ){

                continue;

            }

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

                            encrypted_data:
                                vault
                                .encrypted_data,

                            iv:
                                vault.iv

                        })

                    }

                );

            if(!response.ok){

                throw new Error(
                    "Import gagal"
                );

            }

            const result =
                await response.json();

            if(

                result.status !==
                "success"

            ){

                throw new Error(
                    "Import gagal"
                );

            }

        }

        alert(
            "Backup berhasil diimport"
        );

        loadVault();

    }catch(error){

        console.log(error);

        alert(
            "Gagal import backup"
        );

    }

}

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