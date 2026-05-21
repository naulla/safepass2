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

// =========================
// DATABASE
// =========================

include "../config/database.php";

/** @var mysqli $conn */

// =========================
// RATE LIMIT
// =========================

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

// RESET 5 MENIT

if(

    time() - $_SESSION['register_time']
    > 300

){

    $_SESSION['register_attempt'] = 0;

    $_SESSION['register_time'] = time();

}

// LIMIT

if(

    $_SESSION['register_attempt']
    >= 5

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

// =========================
// AMBIL JSON
// =========================

$raw =
    file_get_contents(
        "php://input"
    );

// =========================
// VALIDASI REQUEST
// =========================

if(!$raw){

    echo json_encode([

        "status" => "error"

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

// =========================
// VALIDASI JSON
// =========================

if(

    $data === null &&
    json_last_error() !== JSON_ERROR_NONE

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

// =========================
// INPUT
// =========================

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

// =========================
// VALIDASI EMPTY
// =========================

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

// =========================
// VALIDASI EMAIL
// =========================

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

// =========================
// VALIDASI ITERATIONS
// =========================

if(

    $iterations < 100000 ||

    $iterations > 1000000

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

// =========================
// VALIDASI BASE64
// =========================

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

// =========================
// LIMIT SIZE
// =========================

if(

    strlen($verifier) > 500 ||

    strlen($salt) > 500

){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

// =========================
// CHECK EMAIL
// =========================

$checkStmt =
    mysqli_prepare(

        $conn,

        "SELECT id

         FROM users

         WHERE email = ?

         LIMIT 1"

    );

// =========================
// PREPARE ERROR
// =========================

if(!$checkStmt){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

// =========================
// BIND
// =========================

mysqli_stmt_bind_param(

    $checkStmt,

    "s",

    $email

);

// =========================
// EXECUTE
// =========================

mysqli_stmt_execute(
    $checkStmt
);

// =========================
// RESULT
// =========================

$checkResult =
    mysqli_stmt_get_result(
        $checkStmt
    );

// =========================
// EMAIL EXISTS
// =========================

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

// =========================
// INSERT USER
// =========================

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

// =========================
// PREPARE ERROR
// =========================

if(!$insertStmt){

    echo json_encode([

        "status" => "error"

    ]);

    exit;

}

// =========================
// BIND PARAM
// =========================

mysqli_stmt_bind_param(

    $insertStmt,

    "sssi",

    $email,
    $verifier,
    $salt,
    $iterations

);

// =========================
// EXECUTE
// =========================

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

// =========================
// CLOSE
// =========================

mysqli_stmt_close(
    $insertStmt
);

mysqli_close($conn);

?>