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

if(

    !isset($_SESSION['user_id'])

){

    echo json_encode([

        "status" => "unauthorized"

    ]);

    exit;

}

$user_id =
    intval(
        $_SESSION['user_id']
    );

$raw =
    file_get_contents(
        "php://input"
    );

if($raw === false){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Request gagal"

    ]);

    exit;

}

$input =
    json_decode(
        $raw,
        true
    );

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

if(!$stmt){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Prepare statement gagal"

    ]);

    exit;

}

mysqli_stmt_bind_param(

    $stmt,

    "i",

    $user_id

);

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

$result =
    mysqli_stmt_get_result(
        $stmt
    );

$data = [];

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

mysqli_stmt_close($stmt);

echo json_encode([

    "status" => "success",

    "data" => $data

]);

?>