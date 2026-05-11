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
// VALIDASI ID
// =========================

if(!isset($data['id'])){

    echo json_encode([

        "status" => "error",

        "message" =>
            "ID tidak ditemukan"

    ]);

    exit;

}

// =========================
// AMBIL ID
// =========================

$id =
    intval(
        $data['id']
    );

// =========================
// VALIDASI EMPTY
// =========================

if($id <= 0){

    echo json_encode([

        "status" => "error",

        "message" =>
            "ID invalid"

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

        "DELETE FROM vaults
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

    "i",

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