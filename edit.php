<!DOCTYPE html>
<html>
<head>

    <title>Edit Vault</title>

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>

<body>

<div class="container">

    <div class="card">

        <h2>Edit Vault</h2>

        <label>Service</label>

        <input
            type="text"
            id="service"
            placeholder="Contoh: Gmail"
        >

        <label>Username / Email</label>

        <input
            type="text"
            id="username"
            placeholder="Masukkan username"
        >

        <label>Password</label>

        <input
            type="text"
            id="password"
            placeholder="Masukkan password"
        >

        <div class="generator-box">

            <h3>Password Generator</h3>

            <label>Panjang Password</label>

            <input
                type="number"
                id="passwordLength"
                value="12"
                min="4"
                max="50"
            >

            <div class="checkbox-group">

                <label>
                    <input
                        type="checkbox"
                        id="uppercase"
                        checked
                    >

                    Huruf Besar
                </label>

            </div>

            <div class="checkbox-group">

                <label>
                    <input
                        type="checkbox"
                        id="lowercase"
                        checked
                    >

                    Huruf Kecil
                </label>

            </div>

            <div class="checkbox-group">

                <label>
                    <input
                        type="checkbox"
                        id="numbers"
                        checked
                    >

                    Angka
                </label>

            </div>

            <div class="checkbox-group">

                <label>
                    <input
                        type="checkbox"
                        id="symbols"
                    >

                    Simbol
                </label>

            </div>

            <button
                class="btn-purple"
                onclick="generatePassword()"
            >
                Generate Password
            </button>

        </div>

        <label>Catatan</label>

        <textarea
            id="note"
            placeholder="Catatan tambahan"
        ></textarea>

        <button
            class="btn-success"
            onclick="updateVault()"
        >
            Update Vault
        </button>

    </div>

</div>

<script>

const vaultId =
new URLSearchParams(window.location.search)
.get("id");

</script>

<script src="assets/js/auth-check.js"></script>
<script src="assets/js/crypto.js"></script>
<script src="assets/js/edit.js"></script>
<script src="assets/js/generator.js"></script>
<script src="assets/js/auto-logout.js"></script>

</body>
</html>