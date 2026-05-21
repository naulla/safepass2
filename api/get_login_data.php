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

        "status" => "error"

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

        "status" => "error"

    ]);

    exit;

}

// =========================
// INPUT
// =========================

$email =
    strtolower(

        trim(

            $data['email']
            ?? ""

        )

    );

// =========================
// VALIDASI EMAIL
// =========================

if(

    empty($email) ||

    !filter_var(

        $email,

        FILTER_VALIDATE_EMAIL

    )

){

    echo json_encode([

        "status" => "error"

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

            salt,
            iterations

         FROM users

         WHERE email = ?

         LIMIT 1"

    );

// =========================
// PREPARE ERROR
// =========================

if(!$stmt){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

// =========================
// BIND PARAM
// =========================

mysqli_stmt_bind_param(

    $stmt,

    "s",

    $email

);

// =========================
// EXECUTE
// =========================

if(!mysqli_stmt_execute($stmt)){

    echo json_encode([

        "status" => "error"

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
// USER TIDAK ADA
// =========================

if(

    mysqli_num_rows($result)
    === 0

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

// =========================
// USER DATA
// =========================

$user =
    mysqli_fetch_assoc(
        $result
    );

// =========================
// CLOSE
// =========================

mysqli_stmt_close($stmt);

// =========================
// SUCCESS
// =========================

echo json_encode([

    "status" => "success",

    "data" => [

        "salt" =>
            $user['salt'],

        "iterations" =>
            (int)$user['iterations']

    ]

]);

?>