<?php

include "../config/session.php";

header("Content-Type: application/json");

include "../config/database.php";

/** @var mysqli $conn */

// =========================
// CEK LOGIN
// =========================

if(

    !isset($_SESSION['user_id'])

){

    http_response_code(401);

    echo json_encode([

        "status" => "error",

        "message" =>
            "Unauthorized"

    ]);

    exit;

}

// =========================
// USER LOGIN
// =========================

$user_id =
    (int)$_SESSION['user_id'];

// =========================
// AMBIL JSON INPUT
// =========================

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

// =========================
// DECODE JSON
// =========================

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

        "status" => "error",

        "message" =>
            "JSON invalid"

    ]);

    exit;

}

// =========================
// VALIDASI FIELD
// =========================

if(

    !isset($data['id']) ||

    !isset($data['encrypted_data']) ||

    !isset($data['encrypted_data']['data']) ||

    !isset($data['encrypted_data']['iv'])

){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Field tidak lengkap"

    ]);

    exit;

}

// =========================
// AMBIL DATA
// =========================

$id =
    (int)$data['id'];

$encrypted_data =
    trim(
        $data['encrypted_data']['data']
    );

$iv =
    trim(
        $data['encrypted_data']['iv']
    );

// =========================
// VALIDASI EMPTY
// =========================

if(

    $id <= 0 ||

    empty($encrypted_data) ||

    empty($iv)

){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Data kosong"

    ]);

    exit;

}

// =========================
// VALIDASI BASE64
// =========================

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

        "status" => "error",

        "message" =>
            "Format base64 invalid"

    ]);

    exit;

}

// =========================
// CEK VAULT & OWNER
// =========================

$check =
    mysqli_prepare(

        $conn,

        "SELECT id

         FROM vaults

         WHERE id=?
         AND user_id=?

         LIMIT 1"

    );

if(!$check){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Prepare gagal"

    ]);

    exit;

}

// =========================
// BIND PARAM
// =========================

mysqli_stmt_bind_param(

    $check,

    "ii",

    $id,
    $user_id

);

// =========================
// EXECUTE
// =========================

mysqli_stmt_execute(
    $check
);

$result =
    mysqli_stmt_get_result(
        $check
    );

// =========================
// VALIDASI OWNER
// =========================

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

mysqli_stmt_close(
    $check
);

// =========================
// UPDATE VAULT
// =========================

$stmt =
    mysqli_prepare(

        $conn,

        "UPDATE vaults

         SET

            encrypted_data=?,
            iv=?

         WHERE

            id=?
            AND user_id=?"

    );

if(!$stmt){

    echo json_encode([

        "status" => "error",

        "message" =>
            "Prepare statement gagal"

    ]);

    exit;

}

// =========================
// BIND UPDATE
// =========================

mysqli_stmt_bind_param(

    $stmt,

    "ssii",

    $encrypted_data,
    $iv,
    $id,
    $user_id

);

// =========================
// EXECUTE UPDATE
// =========================

if(

    mysqli_stmt_execute($stmt)

){

    echo json_encode([

        "status" => "success"

    ]);

}else{

    echo json_encode([

        "status" => "error",

        "message" =>
            "Update gagal"

    ]);

}

// =========================
// CLOSE
// =========================

mysqli_stmt_close($stmt);

?>