if(
    sessionStorage.getItem("isLoggedIn")
    !== "true"
){

    alert("Silakan login terlebih dahulu");

    window.location = "login.php";

}