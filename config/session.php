<?php

// =========================
// SESSION COOKIE SECURITY
// =========================

session_set_cookie_params([

    "lifetime" => 0,

    "path" => "/",

    "secure" => false,

    "httponly" => true,

    "samesite" => "Strict"

]);

// =========================
// START SESSION
// =========================

if(session_status() === PHP_SESSION_NONE){

    session_start();

}

// =========================
// SECURITY HEADERS
// =========================

header("X-Frame-Options: DENY");

header("X-Content-Type-Options: nosniff");

header("Referrer-Policy: no-referrer");

header(
    "Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';"
);

?>