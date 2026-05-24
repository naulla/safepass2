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

    !isset($_SESSION['user_id']) ||

    !isset($_SESSION['logged_in'])

){

    http_response_code(401);

    echo json_encode([

        "status" => "error",

        "message" =>
            "Unauthorized"

    ]);

    exit;

}

if(

    isset($_SESSION['last_activity'])

){

    $timeout = 1800;

    if(

        time() -
        $_SESSION['last_activity']

        > $timeout

    ){

        session_unset();

        session_destroy();

        http_response_code(401);

        echo json_encode([

            "status" => "error",

            "message" =>
                "Session expired"

        ]);

        exit;

    }

}

$_SESSION['last_activity'] =
    time();

$user_id =
    (int)$_SESSION['user_id'];

$raw =
    file_get_contents(
        "php://input"
    );

if(!$raw){

    http_response_code(400);

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

if(

    $data === null &&

    json_last_error()
    !== JSON_ERROR_NONE

){

    http_response_code(400);

    echo json_encode([

        "status" => "error",

        "message" =>
            "JSON invalid"

    ]);

    exit;

}

if(

    !isset(
        $data['encrypted_data']
    ) ||

    !is_array(
        $data['encrypted_data']
    ) ||

    !isset(
        $data['encrypted_data']['data']
    ) ||

    !isset(
        $data['encrypted_data']['iv']
    )

){

    http_response_code(400);

    echo json_encode([

        "status" => "error",

        "message" =>
            "Field tidak lengkap"

    ]);

    exit;

}

$encrypted_data =
    trim(

        $data['encrypted_data']['data']

    );

$iv =
    trim(

        $data['encrypted_data']['iv']

    );

if(

    empty($encrypted_data) ||

    empty($iv)

){

    http_response_code(400);

    echo json_encode([

        "status" => "error",

        "message" =>
            "Data kosong"

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

    http_response_code(400);

    echo json_encode([

        "status" => "error",

        "message" =>
            "Format base64 invalid"

    ]);

    exit;

}

$decodedIv =
    base64_decode($iv);

if(

    strlen($decodedIv) !== 12

){

    http_response_code(400);

    echo json_encode([

        "status" => "error",

        "message" =>
            "IV invalid"

    ]);

    exit;

}

if(

    strlen($encrypted_data)
    > 50000

){

    http_response_code(400);

    echo json_encode([

        "status" => "error",

        "message" =>
            "Data terlalu besar"

    ]);

    exit;

}

$stmt =
    mysqli_prepare(

        $conn,

        "INSERT INTO vaults(

            user_id,
            encrypted_data,
            iv

        )

        VALUES(

            ?, ?, ?

        )"

    );

if(!$stmt){

    http_response_code(500);

    echo json_encode([

        "status" => "error",

        "message" =>
            "Prepare statement gagal"

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

    http_response_code(500);

    echo json_encode([

        "status" => "error",

        "message" =>
            "Insert gagal"

    ]);

}

mysqli_stmt_close($stmt);

$conn->close();

?>