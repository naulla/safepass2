<?php

header("Content-Type: application/json");

include "../config/database.php";
/** @var mysqli $conn */
// =========================
// VALIDASI PARAMETER
// =========================

if(!isset($_GET['user_id'])){

    echo json_encode([

        "status" => "error",

        "message" =>
            "user_id tidak ditemukan"

    ]);

    exit;

}

// =========================
// AMBIL USER ID
// =========================

$user_id =
    intval(
        $_GET['user_id']
    );

// =========================
// VALIDASI EMPTY
// =========================

if($user_id <= 0){

    echo json_encode([

        "status" => "error",

        "message" =>
            "user_id invalid"

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

         WHERE user_id=?

         ORDER BY id DESC"

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

    $user_id

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
// BUILD DATA
// =========================

$data = [];

while(

    $row =
        mysqli_fetch_assoc(
            $result
        )

){

    $data[] = [

        "id" =>
            $row['id'],

        "user_id" =>
            $row['user_id'],

        "encrypted_data" =>
            $row['encrypted_data'],

        "iv" =>
            $row['iv']

    ];

}

// =========================
// RESPONSE
// =========================

echo json_encode($data);

// =========================
// CLOSE
// =========================

mysqli_stmt_close($stmt);

?>