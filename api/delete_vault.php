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
    (int) $_SESSION['user_id'];

$raw =
    file_get_contents(
        "php://input"
    );

if(!$raw){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Request kosong"

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

        "status" => "error",

        "message" =>
            "JSON invalid"

    ]);

    exit;

}

if(!isset($data['id'])){

    echo json_encode([

        "status" => "error",

        "message" =>
            "ID tidak ditemukan"

    ]);

    exit;

}

$id =
    intval(
        $data['id']
    );

if($id <= 0){

    echo json_encode([

        "status" => "error",

        "message" =>
            "ID invalid"

    ]);

    exit;

}

$check =
    mysqli_prepare(

        $conn,

        "SELECT id
         FROM vaults
         WHERE id = ?
         AND user_id = ?"

    );

if(!$check){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Prepare gagal"

    ]);

    exit;

}

mysqli_stmt_bind_param(

    $check,

    "ii",

    $id,
    $user_id

);

mysqli_stmt_execute(
    $check
);

$result =
    mysqli_stmt_get_result(
        $check
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

mysqli_stmt_close($check);

$stmt =
    mysqli_prepare(

        $conn,

        "DELETE FROM vaults
         WHERE id = ?
         AND user_id = ?"

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

if(mysqli_stmt_execute($stmt)){

    echo json_encode([

        "status" => "success"

    ]);

}else{

    echo json_encode([

        "status" => "error",

        "message" =>
            "Delete gagal"

    ]);

}

mysqli_stmt_close($stmt);

?>