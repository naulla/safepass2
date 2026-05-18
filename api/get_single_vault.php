<?php

header("Content-Type: application/json");

include "../config/database.php";
/** @var mysqli $conn */
// =========================
// VALIDASI PARAMETER
// =========================

if(!isset($_GET['id'])){

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
        $_GET['id']
    );

// =========================
// VALIDASI ID
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
// PREPARED STATEMENT
// =========================

$stmt =
    mysqli_prepare(

        $conn,

        "SELECT
            id,
            user_id,
            encrypted_data,
            iv
        FROM vaults

         WHERE id=?

         LIMIT 1"

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

mysqli_stmt_execute(
    $stmt
);

$result =
    mysqli_stmt_get_result(
        $stmt
    );

// =========================
// VAULT TIDAK ADA
// =========================

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
// AMBIL DATA
// =========================

$data =
    mysqli_fetch_assoc(
        $result
    );

// =========================
// RESPONSE
// =========================

echo json_encode([

    "status" => "success",

    "data" => [

        "id" =>
            $data['id'],

        "user_id" =>
            $data['user_id'],

        "encrypted_data" =>
            $data['encrypted_data'],

        "iv" =>
            $data['iv']

    ]

]);

// =========================
// CLOSE
// =========================

mysqli_stmt_close($stmt);

?>