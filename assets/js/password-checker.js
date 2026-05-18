// =========================
// PASSWORD SCORE
// =========================

function getPasswordStrength(
    password
){

    let score = 0;

    // panjang

    if(password.length >= 8){

        score++;

    }

    if(password.length >= 12){

        score++;

    }

    // huruf kecil

    if(/[a-z]/.test(password)){

        score++;

    }

    // huruf besar

    if(/[A-Z]/.test(password)){

        score++;

    }

    // angka

    if(/\d/.test(password)){

        score++;

    }

    // simbol

    if(/[^A-Za-z0-9]/.test(password)){

        score++;

    }

    // =========================
    // RESULT
    // =========================

    if(score <= 2){

        return {

            label:"Lemah",

            className:
                "strength-weak"

        };

    }

    if(score <= 4){

        return {

            label:"Sedang",

            className:
                "strength-medium"

        };

    }

    return {

        label:"Kuat",

        className:
            "strength-strong"

    };

}

// =========================
// SHA-1
// =========================

async function sha1(text){

    const encoded =
        new TextEncoder()
        .encode(text);

    const hash =
        await crypto.subtle.digest(

            "SHA-1",

            encoded

        );

    return Array
    .from(
        new Uint8Array(hash)
    )
    .map(b =>

        b.toString(16)
        .padStart(2,"0")

    )
    .join("")
    .toUpperCase();

}

// =========================
// HIBP CHECK
// =========================

async function checkPwnedPassword(
    password
){

    try{

        // =========================
        // HASH SHA1
        // =========================

        const hash =
            await sha1(password);

        // =========================
        // PREFIX
        // =========================

        const prefix =
            hash.substring(0,5);

        const suffix =
            hash.substring(5);

        // =========================
        // REQUEST
        // =========================

        const response =
            await fetch(

                "https://api.pwnedpasswords.com/range/"
                + prefix

            );

        if(!response.ok){

            throw new Error(
                "HIBP Error"
            );

        }

        const text =
            await response.text();

        const lines =
            text.split("\n");

        // =========================
        // MATCH
        // =========================

        for(let line of lines){

            const parts =
                line.trim()
                .split(":");

            if(parts[0] === suffix){

                return true;

            }

        }

        return false;

    }catch(error){

        console.log(error);

        return false;

    }

}