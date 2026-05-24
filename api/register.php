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

include "../config/database.php";

/** @var mysqli $conn */

if(

    !isset($_SESSION['register_attempt'])

){

    $_SESSION['register_attempt'] = 0;

}

if(

    !isset($_SESSION['register_time'])

){

    $_SESSION['register_time'] = time();

}

if(

    time() - $_SESSION['register_time']
    > 300

){

    $_SESSION['register_attempt'] = 0;

    $_SESSION['register_time'] = time();

}

if(

    $_SESSION['register_attempt']
    >= 5

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

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

$verifier =
    trim(

        $data['verifier']
        ?? ""

    );

$salt =
    trim(

        $data['salt']
        ?? ""

    );

$iterations =
    (int)(

        $data['iterations']
        ?? 0

    );

if(

    empty($email) ||

    empty($verifier) ||

    empty($salt) ||

    empty($iterations)

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

if(

    $iterations < 100000 ||

    $iterations > 1000000

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

if(

    base64_decode(
        $verifier,
        true
    ) === false ||

    base64_decode(
        $salt,
        true
    ) === false

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

if(

    strlen($verifier) > 500 ||

    strlen($salt) > 500

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

$checkStmt =
    mysqli_prepare(

        $conn,

        "SELECT id

         FROM users

         WHERE email = ?

         LIMIT 1"

    );

if(!$checkStmt){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

mysqli_stmt_bind_param(

    $checkStmt,

    "s",

    $email

);

mysqli_stmt_execute(
    $checkStmt
);

$checkResult =
    mysqli_stmt_get_result(
        $checkStmt
    );

if(

    mysqli_num_rows(
        $checkResult
    ) > 0

){

    $_SESSION['register_attempt']++;

    mysqli_stmt_close(
        $checkStmt
    );

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

mysqli_stmt_close(
    $checkStmt
);

$insertStmt =
    mysqli_prepare(

        $conn,

        "INSERT INTO users(

            email,
            verifier,
            salt,
            iterations

        )

        VALUES(

            ?, ?, ?, ?

        )"

    );

if(!$insertStmt){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

mysqli_stmt_bind_param(

    $insertStmt,

    "sssi",

    $email,
    $verifier,
    $salt,
    $iterations

);

if(

    mysqli_stmt_execute(
        $insertStmt
    )

){

    $_SESSION['register_attempt'] = 0;

    echo json_encode([

        "status" => "success"

    ]);

}else{

    echo json_encode([

        "status" => "error"

    ]);

}

mysqli_stmt_close(
    $insertStmt
);

mysqli_close($conn);

?>