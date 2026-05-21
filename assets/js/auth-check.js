if(
    sessionStorage.getItem("isLoggedIn")
    !== "true"
){

    alert("Silakan login terlebih dahulu");

    showPage(
                "loginPage"
            );

}