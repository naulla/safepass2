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

if(

    $data === null &&
    json_last_error() !== JSON_ERROR_NONE

){

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

        "status" => "error"

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

            id,
            verifier

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

if(

    !mysqli_stmt_execute($stmt)

){

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

$_SESSION['last_activity'] =
    time();

// =========================
// SUCCESS
// =========================

echo json_encode([

    "status" => "success"

]);

?>