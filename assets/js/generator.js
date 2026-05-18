function generatePassword(){

    const length =
        parseInt(
            document.getElementById(
                "passwordLength"
            ).value
        );

    const useUpper =
        document.getElementById(
            "uppercase"
        ).checked;

    const useLower =
        document.getElementById(
            "lowercase"
        ).checked;

    const useNumbers =
        document.getElementById(
            "numbers"
        ).checked;

    const useSymbols =
        document.getElementById(
            "symbols"
        ).checked;

    let chars = "";

    if(useUpper){

        chars += "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    }

    if(useLower){

        chars += "abcdefghijklmnopqrstuvwxyz";

    }

    if(useNumbers){

        chars += "0123456789";

    }

    if(useSymbols){

        chars += "!@#$%^&*()_+-=[]{}";

    }

    if(chars === ""){

        alert(
            "Pilih minimal 1 tipe karakter"
        );

        return;

    }

    let password = "";

    for(let i = 0; i < length; i++){

        const randomIndex =
            Math.floor(
                Math.random() * chars.length
            );

        password += chars[randomIndex];

    }

    console.log(
        "PASSWORD BARU:",
        password
    );

    document.getElementById(
        "password"
    ).value = password;

}