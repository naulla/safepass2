<!DOCTYPE html>
<html>
<head>
    <title>Edit Vault</title>
</head>
<body>

<h2>Edit Vault</h2>

<input type="text" id="service">

<br><br>

<input type="text" id="username">

<br><br>

<input type="password" id="password">

<button onclick="generatePassword()">
    Generate
</button>

<br><br>

<textarea id="note"></textarea>

<br><br>

<button onclick="updateVault()">
    Update
</button>

<br><br>

<a href="dashboard.php">
    Kembali
</a>

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

</body>
</html>