<!DOCTYPE html>
<html>
<head>
    <title>Edit Vault</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">

<h2>Edit Vault</h2>

<label>Service</label>
<br>
<input type="text" id="service" placeholder="Contoh: Gmail">

<br><br>

<label>Username / Email</label>
<br>
<input type="text" id="username" placeholder="Masukkan username">

<br><br>

<label>Panjang Password</label>
<br>

<input
    type="number"
    id="passwordLength"
    value="12"
    min="4"
    max="50"
>

<br><br>

<label>Password</label>
<br>


<input type="text" id="password" placeholder="Masukkan password">

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
            <input type="checkbox" id="uppercase" checked>
            Huruf Besar
        </label>
    </div>

    <div class="checkbox-group">
        <label>
            <input type="checkbox" id="lowercase" checked>
            Huruf Kecil
        </label>
    </div>

    <div class="checkbox-group">
        <label>
            <input type="checkbox" id="numbers" checked>
            Angka
        </label>
    </div>

    <div class="checkbox-group">
        <label>
            <input type="checkbox" id="symbols">
            Simbol
        </label>
    </div>

    <button
    class="generate-btn"
    onclick="generatePassword()"
>
    Generate
</button>


</div>

<br><br>

<label>Catatan</label>
<br>
<textarea id="note" placeholder="Catatan tambahan"></textarea>
<br><br>

<button onclick="updateVault()">
    Update
</button>

<script>

const vaultId =
new URLSearchParams(window.location.search)
.get("id");

</script>
<script src="https://cdn.jsdelivr.net/npm/argon2-browser/dist/argon2-bundled.min.js"></script>
<script src="assets/js/auth-check.js"></script>
<script src="assets/js/crypto.js"></script>
<script src="assets/js/edit.js"></script>
<script src="assets/js/generator.js"></script>
<script src="assets/js/auto-logout.js"></script>

</div>
</body>
</html>