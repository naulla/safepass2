<?php

header("Content-Type: application/json");

include "../config/database.php";

// =========================
// AMBIL JSON
// =========================

$raw =
    file_get_contents(
        "php://input"
    );

$data =
    json_decode(
        $raw,
        true
    );

// =========================
// VALIDASI JSON
// =========================

if(!$data){

    echo json_encode([

        "status"=>"invalid_json"

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
// VALIDASI
// =========================

if(

    empty($email) ||

    empty($verifier) ||

    empty($salt) ||

    empty($iterations)

){

    echo json_encode([

        "status"=>"empty_field"

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

        "status"=>"invalid_email"

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

        "status"=>"invalid_iterations"

    ]);

    exit;

}

// =========================
// PREPARED CHECK EMAIL
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

        "status"=>"prepare_error"

    ]);

    exit;

}

// =========================
// BIND EMAIL
// =========================

mysqli_stmt_bind_param(

    $checkStmt,

    "s",

    $email

);

// =========================
// EXECUTE CHECK
// =========================

mysqli_stmt_execute(
    $checkStmt
);

// =========================
// RESULT CHECK
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

    mysqli_stmt_close(
        $checkStmt
    );

    echo json_encode([

        "status"=>"email_exists"

    ]);

    exit;

}

mysqli_stmt_close(
    $checkStmt
);

// =========================
// PREPARED INSERT
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

        "status"=>"prepare_error"

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
// EXECUTE INSERT
// =========================

if(

    mysqli_stmt_execute(
        $insertStmt
    )

){

    echo json_encode([

        "status"=>"success"

    ]);

}else{

    echo json_encode([

        "status"=>"error"

    ]);

}

// =========================
// CLOSE
// =========================

mysqli_stmt_close(
    $insertStmt
);

?>