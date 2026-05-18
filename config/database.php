<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "safepass2"
);
/** @var mysqli $conn */
if(!$conn){
    die("Koneksi database gagal");
}

?>