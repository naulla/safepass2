<?php

session_start();

header(
    "Content-Type: application/json"
);

require "../config/database.php";
/** @var mysqli $conn */

// =========================
// CEK LOGIN
// =========================

if(

    !isset($_SESSION['user_id'])

){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Unauthorized"

    ]);

    exit;

}

// =========================
// USER SESSION
// =========================

$user_id =
    (int)$_SESSION['user_id'];

// =========================
// AMBIL JSON
// =========================

$raw =
    file_get_contents(
        "php://input"
    );

// =========================
// VALIDASI REQUEST
// =========================

if(!$raw){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Request kosong"

    ]);

    exit;

}

// =========================
// DECODE JSON
// =========================

$data =
    json_decode(

        $raw,

        true

    );

// =========================
// VALIDASI JSON
// =========================

if(!$data){

    echo json_encode([

        "status" => "error",

        "message" =>
            "JSON invalid"

    ]);

    exit;

}

// =========================
// VALIDASI FIELD
// =========================

if(

    !isset(
        $data["encrypted_data"]
    ) ||

    !isset(
        $data["iv"]
    )

){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Field tidak lengkap"

    ]);

    exit;

}

// =========================
// DATA
// =========================

$encrypted_data =
    trim(

        $data[
            "encrypted_data"
        ]

    );

$iv =
    trim(

        $data["iv"]

    );

// =========================
// VALIDASI EMPTY
// =========================

if(

    empty($encrypted_data) ||

    empty($iv)

){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Data kosong"

    ]);

    exit;

}

// =========================
// VALIDASI BASE64
// =========================

if(

    base64_decode(
        $encrypted_data,
        true
    ) === false ||

    base64_decode(
        $iv,
        true
    ) === false

){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Format base64 invalid"

    ]);

    exit;

}

// =========================
// PREPARE
// =========================

$stmt =
    $conn->prepare(

        "INSERT INTO vaults

        (

            user_id,
            encrypted_data,
            iv

        )

        VALUES

        (

            ?, ?, ?

        )"

    );

// =========================
// VALIDASI PREPARE
// =========================

if(!$stmt){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Prepare gagal"

    ]);

    exit;

}

// =========================
// BIND PARAM
// =========================

$stmt->bind_param(

    "iss",

    $user_id,
    $encrypted_data,
    $iv

);

// =========================
// EXECUTE
// =========================

if($stmt->execute()){

    echo json_encode([

        "status" => "success"

    ]);

}else{

    echo json_encode([

        "status" => "error",

        "message" =>
            "Insert gagal"

    ]);

}

// =========================
// CLOSE
// =========================

$stmt->close();

$conn->close();

?>