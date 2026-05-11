<!DOCTYPE html>
<html>
<head>
    <title>Tambah Vault</title>
</head>
<body>

<h2>Tambah Password</h2>

<input type="text"
       id="service"
       placeholder="Service">

<br><br>

<input type="text"
       id="username"
       placeholder="Username">

<br><br>

<input type="password"
       id="password"
       placeholder="Password">

<button onclick="generatePassword()">
    Generate
</button>

<br><br>

<textarea id="note"
placeholder="Catatan"></textarea>

<br><br>

<button id="saveBtn" onclick="saveVault()">
    Simpan
</button>
<br><br>

<a href="dashboard.php">
    Kembali
</a>


<script src="assets/js/auth-check.js"></script>
<script src="assets/js/crypto.js"></script>
<script src="assets/js/add.js"></script>
<script src="assets/js/generator.js"></script>
<script src="assets/js/auto-logout.js"></script>

</body>
</html>