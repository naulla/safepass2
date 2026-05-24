const PBKDF2_ITERATIONS =
    600000;

let cachedKey = null;
// =========================
// CACHE AES KEY
// =========================

function setAESKey(key){
    cachedKey = key;

}

function checkCryptoSupport(){

    if(!window.crypto?.subtle){

        throw new Error(
            "Browser tidak support WebCrypto"
        );
        
    }

}

function generateSalt(){

    return crypto.getRandomValues(

        new Uint8Array(16)

    );

}

function bufToBase64(buf){

    return btoa(

        String.fromCharCode(
            ...new Uint8Array(buf)
        )

    );

}

function base64ToBuf(base64){

    try{

        return Uint8Array.from(

            atob(base64),

            c => c.charCodeAt(0)

        );

    }catch{

        throw new Error(
            "Base64 invalid"
        );

    }

}

async function importPasswordKey(
    password
){

    checkCryptoSupport();

    if(!password){

        throw new Error(
            "Password kosong"
        );

    }

    return await crypto.subtle.importKey(

        "raw",

        new TextEncoder()
        .encode(password),

        {
            name:"PBKDF2"
        },

        false,

        ["deriveBits","deriveKey"]

    );

}

async function generateVerifier(

    password,
    salt,
    iterations = PBKDF2_ITERATIONS

){

    checkCryptoSupport();

    if(!(salt instanceof Uint8Array)){

        throw new Error(
            "Salt invalid"
        );

    }

    const keyMaterial =
        await importPasswordKey(
            password
        );

    const bits =
        await crypto.subtle.deriveBits(

            {

                name:"PBKDF2",

                salt:salt,

                iterations:
                    Number(iterations),

                hash:"SHA-256"

            },

            keyMaterial,

            256

        );

    return bufToBase64(bits);

}

async function deriveKey(

    password,
    salt,
    iterations = PBKDF2_ITERATIONS

){

    checkCryptoSupport();

    if(!password){

        throw new Error(
            "Password kosong"
        );

    }

    if(!(salt instanceof Uint8Array)){

        throw new Error(
            "Salt invalid"
        );

    }

    if(cachedKey){

        return cachedKey;

    }

    const keyMaterial =
        await importPasswordKey(
            password
        );

    cachedKey =
        await crypto.subtle.deriveKey(

            {

                name:"PBKDF2",

                salt:salt,

                iterations:
                    Number(iterations),

                hash:"SHA-256"

            },

            keyMaterial,

            {

                name:"AES-GCM",

                length:256

            },

            false,

            ["encrypt","decrypt"]

        );

    return cachedKey;

}

async function saveAESKey(key){

    checkCryptoSupport();

    if(!key){

        throw new Error(
            "AES Key kosong"
        );

    }

    cachedKey = key;

}

async function getAESKey(){

    checkCryptoSupport();

    if(!cachedKey){

        throw new Error(
            "AES Key tidak ditemukan"
        );

    }

    return cachedKey;

}

async function encryptData(data){

    try{

        if(!data){

            throw new Error(
                "Data kosong"
            );

        }

        const key =
            await getAESKey();

        const iv =
            crypto.getRandomValues(

                new Uint8Array(12)

            );

        const encoded =
            new TextEncoder()
            .encode(

                JSON.stringify(data)

            );

        const encrypted =
            await crypto.subtle.encrypt(

                {

                    name:"AES-GCM",

                    iv:iv

                },

                key,

                encoded

            );

        return {

            version:1,

            iv:
                bufToBase64(iv),

            data:
                bufToBase64(
                    encrypted
                )

        };

    }catch(error){

        console.error(
            "Encrypt failed"
        );

        throw error;

    }

}

async function decryptData(data){

    try{

        if(

            !data ||
            !data.iv ||
            !data.data

        ){

            throw new Error(
                "Encrypted data invalid"
            );

        }

        const key =
            await getAESKey();

        const iv =
            base64ToBuf(
                data.iv
            );

        const encrypted =
            base64ToBuf(
                data.data
            );

        const decrypted =
            await crypto.subtle.decrypt(

                {

                    name:"AES-GCM",

                    iv:iv

                },

                key,

                encrypted

            );

        return JSON.parse(

            new TextDecoder()
            .decode(decrypted)

        );

    }catch(error){

        console.error(
            "Decrypt failed"
        );

        throw error;

    }

}

function clearCryptoCache(){

    cachedKey = null;

}