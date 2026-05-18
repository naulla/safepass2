<!DOCTYPE html>
<html>
<head>

    <title>Dashboard</title>

    <link rel="stylesheet"
    href="assets/css/style.css">

</head>
<body>

<div class="topbar">

    <h2>My Vault</h2>

    <div class="topbar-actions">

        <!-- TAMBAH -->

        <a href="add.php">

            <button class="action-btn">
                Tambah Password
            </button>

        </a>

        <!-- EXPORT -->

<button
    class="action-btn"
    onclick="exportEncryptedBackup()"
>

    Export Backup

</button>

<!-- IMPORT -->

<button
    class="action-btn"
    onclick="
        document
        .getElementById(
            'importBackupInput'
        )
        .click()
    "
>

    Import Backup

</button>

<input
    type="file"
    id="importBackupInput"
    accept=".json"
    style="display:none"
    onchange="importEncryptedBackup(event)"
>

        <!-- HIDDEN FILE INPUT -->

        <input
            type="file"
            id="importCsvInput"
            accept=".csv"
            style="display:none"
            onchange="importVaultCSV(event)"
        >

        <!-- LOGOUT -->

        <button onclick="logout()">
            Logout
        </button>

    </div>

</div>

<div class="table-container">

    <table>

        <thead>

            <tr>

                <th>Service</th>
                <th>Username</th>
                <th>Password</th>
                <th>Keamanan</th>
                <th>Catatan</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody id="vaultList"></tbody>

    </table>

</div>

<!-- AUTH -->

<script src="assets/js/auth-check.js"></script>
<script src="assets/js/auto-logout.js"></script>

<!-- CRYPTO -->

<script src="assets/js/crypto.js"></script>

<!-- VAULT -->

<script src="assets/js/vault-api.js"></script>
<script src="assets/js/vault-ui.js"></script>

<!-- Backup -->

<script src="assets/js/backup.js"></script>
<!-- Password Checker -->
<script src="assets/js/password-checker.js"></script>
<!-- DASHBOARD -->

<script src="assets/js/dashboard.js"></script>

</body>
</html>