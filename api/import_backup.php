<?php

include "../config/session.php";

header(
    "Content-Type: application/json"
);

header(
    "Cache-Control: no-store, no-cache, must-revalidate, max-age=0"
);

header(
    "Pragma: no-cache"
);

require "../config/database.php";
/** @var mysqli $conn */

if(

    !isset($_SESSION['user_id'])

){

    echo json_encode([

        "status" => "unauthorized"

    ]);

    exit;

}

$user_id =
    (int)$_SESSION['user_id'];

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

if(

    !isset(
        $data["encrypted_data"]
    )

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

$encrypted =
    $data["encrypted_data"];

if(

    !is_array($encrypted) ||

    !isset($encrypted["data"]) ||

    !isset($encrypted["iv"])

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

$encrypted_data =
    trim(
        $encrypted["data"]
    );

$iv =
    trim(
        $encrypted["iv"]
    );

if(

    empty($encrypted_data) ||

    empty($iv)

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

if(

    base64_decode(
        $encrypted_data,
        true
    ) === false ||

    base64_decode(
        $iv,
        true
    ) === false

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

if(

    strlen($encrypted_data)
    > 50000

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

$stmt =
    mysqli_prepare(

        $conn,

        "INSERT INTO vaults

        (

            user_id,
            encrypted_data,
            iv

        )

        VALUES

        (

            ?, ?, ?

        )"

    );

if(!$stmt){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

mysqli_stmt_bind_param(

    $stmt,

    "iss",

    $user_id,
    $encrypted_data,
    $iv

);

if(

    mysqli_stmt_execute($stmt)

){

    echo json_encode([

        "status" => "success"

    ]);

}else{

    echo json_encode([

        "status" => "error"

    ]);

}

mysqli_stmt_close($stmt);

mysqli_close($conn);

?>