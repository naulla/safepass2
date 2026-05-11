<!DOCTYPE html>
<html>
<head>

    <title>Register</title>

    <link rel="stylesheet"
    href="assets/css/style.css">

</head>
<body>

<div class="container">

    <h2>Register SafePass</h2>

    <form id="registerForm">

        <input type="email"
               id="email"
               placeholder="Email"
               required>

        <input type="password"
               id="password"
               placeholder="Master Password"
               required>

        <button id="registerBtn">
    Register
</button>

    </form>

    <br>

    <a href="login.php">
        Sudah punya akun?
    </a>

</div>

<script src="https://cdn.jsdelivr.net/npm/argon2-browser/dist/argon2-bundled.min.js"></script>

<script src="assets/js/crypto.js"></script>
<script src="assets/js/auth.js"></script>

</body>
</html>