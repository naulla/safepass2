<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>

<body>

<div class="auth-container">

    <div class="auth-card">

        <h1 class="auth-title">
            Secure Vault
        </h1>

        <p class="auth-subtitle">
            Simpan password dengan aman
        </p>

        <form id="loginForm">

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
                id="loginBtn"
            >
                Login
            </button>

        </form>

        <br>

        <div class="center">

            <a href="register.php">
                Belum punya akun?
            </a>

        </div>

    </div>

</div>

<script src="assets/js/crypto.js"></script>
<script src="assets/js/login.js"></script>

</body>
</html>