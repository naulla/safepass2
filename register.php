<!DOCTYPE html>
<html>
<head>

    <title>Register</title>

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>

<body>

<div class="auth-container">

    <div class="auth-card">

        <h1 class="auth-title">
            Create Account
        </h1>

        <p class="auth-subtitle">
            Buat akun vault baru
        </p>

        <form id="registerForm">

            <label>Email</label>

            <input
                type="email"
                id="email"
                placeholder="Masukkan email"
                required
            >

            <label>Master Password</label>

            <input
                type="password"
                id="password"
                placeholder="Masukkan master password"
                required
            >

            <button
                class="btn-primary"
                id="registerBtn"
            >
                Register
            </button>

        </form>

        <br>

        <div class="center">

            <a href="login.php">
                Sudah punya akun?
            </a>

        </div>

    </div>

</div>

<script src="assets/js/crypto.js"></script>
<script src="assets/js/auth.js"></script>

</body>
</html>