<?php

include "../config/session.php";

header("Content-Type: application/json");

include "../config/database.php";

/** @var mysqli $conn */

$raw =
    file_get_contents(
        "php://input"
    );

if(!$raw){

    echo json_encode([

        "status" => "invalid_request"

    ]);

    exit;

}

$data =
    json_decode(
        $raw,
        true
    );

if(!$data){

    echo json_encode([

        "status" => "invalid_json"

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

        "status" => "empty_field"

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

        "status" => "invalid_email"

    ]);

    exit;

}

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

if(!$stmt){

    echo json_encode([

        "status" => "prepare_error"

    ]);

    exit;

}

mysqli_stmt_bind_param(

    $stmt,

    "s",

    $email

);

if(!mysqli_stmt_execute($stmt)){

    echo json_encode([

        "status" => "execute_error"

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