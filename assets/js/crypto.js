// =========================
// PBKDF2 CONFIG
// =========================

const PBKDF2_ITERATIONS =
    310000;


// =========================
// CACHE AES KEY
// =========================

let cachedKey = null;


// =========================
// WEBCRYPTO CHECK
// =========================

function checkCryptoSupport(){

    if(!window.crypto?.subtle){

        throw new Error(
            "Browser tidak support WebCrypto"
        );

    }

}


// =========================
// GENERATE SALT
// =========================

function generateSalt(){

    return crypto.getRandomValues(

        new Uint8Array(16)

    );

}


// =========================
// BASE64 HELPER
// =========================

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


// =========================
// PBKDF2 KEY MATERIAL
// =========================

async function importPasswordKey(
    password
){

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


// =========================
// GENERATE VERIFIER
// =========================

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

    // import password

    const keyMaterial =
        await importPasswordKey(
            password
        );

    // derive bits

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


// =========================
// DERIVE AES KEY
// =========================

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

    // cache RAM

    if(cachedKey){

        return cachedKey;

    }

    // import password

    const keyMaterial =
        await importPasswordKey(
            password
        );

    // derive AES key

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

            true,

            ["encrypt","decrypt"]

        );

    return cachedKey;

}


// =========================
// SAVE AES KEY
// =========================

async function saveAESKey(key){

    checkCryptoSupport();

    if(!key){

        throw new Error(
            "AES Key kosong"
        );

    }

    // export raw

    const raw =
        await crypto.subtle.exportKey(

            "raw",

            key

        );

    // base64

    const base64 =
        bufToBase64(raw);

    // simpan session

    sessionStorage.setItem(

        "aesKey",

        base64

    );

}


// =========================
// GET AES KEY
// =========================

async function getAESKey(){

    checkCryptoSupport();

    // cache RAM

    if(cachedKey){

        return cachedKey;

    }

    // session storage

    const stored =
        sessionStorage.getItem(
            "aesKey"
        );

    if(!stored){

        throw new Error(
            "AES Key tidak ditemukan"
        );

    }

    // base64 => byte

    const raw =
        base64ToBuf(stored);

    // import AES key

    cachedKey =
        await crypto.subtle.importKey(

            "raw",

            raw,

            {
                name:"AES-GCM"
            },

            false,

            ["encrypt","decrypt"]

        );

    return cachedKey;

}


// =========================
// ENCRYPT DATA
// =========================

async function encryptData(data){

    try{

        if(!data){

            throw new Error(
                "Data kosong"
            );

        }

        const key =
            await getAESKey();

        // random IV

        const iv =
            crypto.getRandomValues(

                new Uint8Array(12)

            );

        // encode JSON

        const encoded =
            new TextEncoder()
            .encode(

                JSON.stringify(data)

            );

        // encrypt

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

            iv:
                bufToBase64(iv),

            data:
                bufToBase64(
                    encrypted
                )

        };

    }catch(error){

        console.log(
            "ENCRYPT ERROR:",
            error
        );

        throw error;

    }

}


// =========================
// DECRYPT DATA
// =========================

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

        // decode IV

        const iv =
            base64ToBuf(
                data.iv
            );

        // decode encrypted

        const encrypted =
            base64ToBuf(
                data.data
            );

        // decrypt

        const decrypted =
            await crypto.subtle.decrypt(

                {

                    name:"AES-GCM",

                    iv:iv

                },

                key,

                encrypted

            );

        // parse JSON

        return JSON.parse(

            new TextDecoder()
            .decode(decrypted)

        );

    }catch(error){

        console.log(
            "DECRYPT ERROR:",
            error
        );

        throw error;

    }

}


// =========================
// CLEAR CACHE
// =========================

function clearCryptoCache(){

    cachedKey = null;

    sessionStorage.removeItem(
        "aesKey"
    );

}