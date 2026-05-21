<?php

include "../config/session.php";

header("Content-Type: application/json");

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

        "status" => "invalid_request"

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

        "status" => "invalid_json"

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

$clientVerifier =
    trim(

        $data['verifier']
        ?? ""

    );

// =========================
// VALIDASI INPUT
// =========================

if(

    empty($email) ||

    empty($clientVerifier)

){

    echo json_encode([

        "status" => "empty_field"

    ]);

    exit;

}

// =========================
// VALIDASI EMAIL
// =========================

if(

    !filter_var(

        $email,

        FILTER_VALIDATE_EMAIL

    )

){

    echo json_encode([

        "status" => "invalid_email"

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
            email,
            verifier,
            salt,
            iterations

         FROM users

         WHERE email = ?

         LIMIT 1"

    );

// =========================
// CEK PREPARE
// =========================

if(!$stmt){

    echo json_encode([

        "status" => "prepare_error"

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

        "status" => "execute_error"

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
// CLOSE STATEMENT
// =========================

mysqli_stmt_close($stmt);

// =========================
// VERIFIER CHECK
// =========================

if(

    !hash_equals(

        $user['verifier'],

        $clientVerifier

    )

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

// =========================
// REGENERATE SESSION
// =========================

session_regenerate_id(true);

// =========================
// SET SESSION
// =========================

$_SESSION['user_id'] =
    (int)$user['id'];

$_SESSION['logged_in'] =
    true;

// =========================
// SUCCESS
// =========================

echo json_encode([

    "status" => "success",

    "data" => [

        "id" =>
            $user['id'],

        "email" =>
            $user['email'],

        "salt" =>
            $user['salt'],

        "iterations" =>
            $user['iterations']

    ]

]);

?>