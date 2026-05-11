<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

    <link rel="stylesheet"
    href="assets/css/style.css">

</head>
<body>

<div class="container">

    <h2>Login SafePass</h2>

    <form id="loginForm">

        <input type="email"
               id="email"
               placeholder="Email"
               required>

        <input type="password"
               id="password"
               placeholder="Master Password"
               required>

        <button id="loginBtn">
    Login
</button>

    </form>

    <br>

    <a href="register.php">
        Belum punya akun?
    </a>

</div>


<script src="assets/js/crypto.js"></script>
<script src="assets/js/login.js"></script>

</body>
</html>