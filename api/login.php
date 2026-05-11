<?php

header("Content-Type: application/json");

include "../config/database.php";

// =========================
// AMBIL JSON
// =========================

$raw =
    file_get_contents(
        "php://input"
    );

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

        "status"=>"invalid_json"

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
// VALIDASI
// =========================

if(empty($email)){

    echo json_encode([

        "status"=>"empty_email"

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
// CEK PREPARE ERROR
// =========================

if(!$stmt){

    echo json_encode([

        "status"=>"prepare_error"

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

        "status"=>"execute_error"

    ]);

    exit;

}

// =========================
// GET RESULT
// =========================

$result =
    mysqli_stmt_get_result(
        $stmt
    );

// =========================
// USER TIDAK ADA
// =========================

if(mysqli_num_rows($result) === 0){

    echo json_encode([

        "status"=>"error"

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
// SUCCESS
// =========================

echo json_encode([

    "status"=>"success",

    "data"=>[

        "id" =>
            $user['id'],

        "email" =>
            $user['email'],

        "verifier" =>
            $user['verifier'],

        "salt" =>
            $user['salt'],

        "iterations" =>
            $user['iterations']

    ]

]);
?>