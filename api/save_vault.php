<?php

session_start();

header("Content-Type: application/json");

include "../config/database.php";

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
// AMBIL JSON INPUT
// =========================

$raw =
    file_get_contents(
        "php://input"
    );

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

    !isset($data['encrypted_data']) ||

    !isset($data['encrypted_data']['data']) ||

    !isset($data['encrypted_data']['iv'])

){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Field tidak lengkap"

    ]);

    exit;

}

// =========================
// AMBIL DATA
// =========================

$encrypted_data =
    trim(
        $data['encrypted_data']['data']
    );

$iv =
    trim(
        $data['encrypted_data']['iv']
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
// PREPARED STATEMENT
// =========================

$stmt =
    mysqli_prepare(

        $conn,

        "INSERT INTO vaults(

            user_id,
            encrypted_data,
            iv

        )

        VALUES(

            ?, ?, ?

        )"

    );

if(!$stmt){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Prepare statement gagal"

    ]);

    exit;

}

// =========================
// BIND PARAM
// =========================

mysqli_stmt_bind_param(

    $stmt,

    "iss",

    $user_id,
    $encrypted_data,
    $iv

);

// =========================
// EXECUTE
// =========================

if(

    mysqli_stmt_execute($stmt)

){

    echo json_encode([

        "status" => "success"

    ]);

}else{

    echo json_encode([

        "status" => "error"

    ]);

}

// =========================
// CLOSE
// =========================

mysqli_stmt_close($stmt);

?>