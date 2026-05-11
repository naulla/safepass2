<?php

header("Content-Type: application/json");

include "../config/database.php";

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

    !isset($data['id']) ||

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

$id =
    intval(
        $data['id']
    );

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

    empty($id) ||

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
// CEK VAULT ADA
// =========================

$check =
    mysqli_prepare(

        $conn,

        "SELECT id
         FROM vaults
         WHERE id=?"

    );

mysqli_stmt_bind_param(

    $check,

    "i",

    $id

);

mysqli_stmt_execute(
    $check
);

$result =
    mysqli_stmt_get_result(
        $check
    );

if(
    mysqli_num_rows($result)
    <= 0
){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Vault tidak ditemukan"

    ]);

    exit;

}

// =========================
// PREPARED STATEMENT
// =========================

$stmt =
    mysqli_prepare(

        $conn,

        "UPDATE vaults

         SET

         encrypted_data=?,
         iv=?

         WHERE id=?"

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

    "ssi",

    $encrypted_data,
    $iv,
    $id

);

// =========================
// EXECUTE
// =========================

if(mysqli_stmt_execute($stmt)){

    echo json_encode([

        "status" => "success"

    ]);

}else{

    echo json_encode([

        "status" => "error",

        "message" =>
            mysqli_error($conn)

    ]);

}

// =========================
// CLOSE
// =========================

mysqli_stmt_close($stmt);

?>