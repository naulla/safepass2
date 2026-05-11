<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "safepass2"
);

if(!$conn){
    die("Koneksi database gagal");
}

?>