<?php

include "../config/session.php";

header("Content-Type: application/json");

include "../config/database.php";
/** @var mysqli $conn */

if(

    !isset($_SESSION['user_id'])

){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Unauthorized"

    ]);

    exit;

}

$user_id =
    intval(
        $_SESSION['user_id']
    );

if(!isset($_GET['id'])){

    echo json_encode([

        "status" => "error",

        "message" =>
            "ID tidak ditemukan"

    ]);

    exit;

}

$id =
    intval(
        $_GET['id']
    );

if($id <= 0){

    echo json_encode([

        "status" => "error",

        "message" =>
            "ID invalid"

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

         WHERE id=?
         AND user_id=?

         LIMIT 1"

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

    "ii",

    $id,
    $user_id

);

mysqli_stmt_execute(
    $stmt
);

$result =
    mysqli_stmt_get_result(
        $stmt
    );

if(
    mysqli_num_rows($result)
    <= 0
){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Vault tidak ditemukan"

    ]);

    exit;

}

$data =
    mysqli_fetch_assoc(
        $result
    );

echo json_encode([

    "status" => "success",

    "data" => [

        "id" =>
            $data['id'],

        "encrypted_data" =>
            $data['encrypted_data'],

        "iv" =>
            $data['iv']

    ]

]);

mysqli_stmt_close($stmt);

?>