function generatePassword(){

    const chars =
"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()";

    let password = "";

    for(let i=0;i<20;i++){

        password += chars.charAt(
            Math.floor(
                Math.random() * chars.length
            )
        );

    }

    document.getElementById("password").value =
        password;

}