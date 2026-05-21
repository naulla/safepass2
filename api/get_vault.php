<?php

include "../config/session.php";

header("Content-Type: application/json");

header(
    "Cache-Control: no-store, no-cache, must-revalidate, max-age=0"
);

header(
    "Pragma: no-cache"
);

// =========================
// DATABASE
// =========================

include "../config/database.php";

/** @var mysqli $conn */

// =========================
// CEK LOGIN
// =========================

if(

    !isset($_SESSION['user_id'])

){

    echo json_encode([

        "status" => "unauthorized"

    ]);

    exit;

}

// =========================
// USER ID DARI SESSION
// =========================

$user_id =
    intval(
        $_SESSION['user_id']
    );

// =========================
// AMBIL JSON BODY
// =========================

$raw =
    file_get_contents(
        "php://input"
    );

// =========================
// VALIDASI REQUEST
// =========================

if($raw === false){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Request gagal"

    ]);

    exit;

}

// =========================
// DECODE JSON
// =========================

$input =
    json_decode(
        $raw,
        true
    );

// =========================
// VALIDASI JSON
// =========================

if(

    $input === null &&
    json_last_error() !== JSON_ERROR_NONE

){

    echo json_encode([

        "status" => "error",

        "message" =>
            "JSON invalid"

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
            encrypted_data,
            iv

         FROM vaults

         WHERE user_id = ?

         ORDER BY id DESC"

    );

// =========================
// PREPARE ERROR
// =========================

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

if(

    !mysqli_stmt_execute($stmt)

){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Execute gagal"

    ]);

    exit;

}

// =========================
// RESULT
// =========================

$result =
    mysqli_stmt_get_result(
        $stmt
    );

// =========================
// DATA ARRAY
// =========================

$data = [];

// =========================
// FETCH DATA
// =========================

while(

    $row =
        mysqli_fetch_assoc(
            $result
        )

){

    $data[] = [

        "id" =>
            (int)$row['id'],

        "encrypted_data" =>
            $row['encrypted_data'],

        "iv" =>
            $row['iv']

    ];

}

// =========================
// CLOSE
// =========================

mysqli_stmt_close($stmt);

// =========================
// RESPONSE
// =========================

echo json_encode([

    "status" => "success",

    "data" => $data

]);

?>