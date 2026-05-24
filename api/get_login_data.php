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

if(!$data){

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

if(!mysqli_stmt_execute($stmt)){

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