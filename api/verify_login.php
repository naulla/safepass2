<?php

include "../config/session.php";

header("Content-Type: application/json");

header(
    "Cache-Control: no-store, no-cache, must-revalidate, max-age=0"
);

header(
    "Pragma: no-cache"
);

include "../config/database.php";

/** @var mysqli $conn */

$raw =
    file_get_contents(
        "php://input"
    );

if(!$raw){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

$data =
    json_decode(
        $raw,
        true
    );

if(

    $data === null &&
    json_last_error() !== JSON_ERROR_NONE

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

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

if(

    empty($email) ||

    empty($clientVerifier)

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

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

if(!$stmt){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

mysqli_stmt_bind_param(

    $stmt,

    "s",

    $email

);

if(

    !mysqli_stmt_execute($stmt)

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

$result =
    mysqli_stmt_get_result(
        $stmt
    );

if(

    mysqli_num_rows($result)
    === 0

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

$user =
    mysqli_fetch_assoc(
        $result
    );

mysqli_stmt_close($stmt);

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

session_regenerate_id(true);

$_SESSION['user_id'] =
    (int)$user['id'];

$_SESSION['logged_in'] =
    true;

$_SESSION['last_activity'] =
    time();

echo json_encode([

    "status" => "success"

]);

?>