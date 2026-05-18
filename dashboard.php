<!DOCTYPE html>
<html>
<head>

    <title>Dashboard</title>

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>

<body>

<div class="container">

    <div class="topbar">

        <div>

            <h2>My Vault</h2>

            <p>
                Kelola password dengan aman
            </p>

        </div>

        <div class="action-group">

            <a href="add.php">

                <button class="btn-primary">
                    Tambah Password
                </button>

            </a>

            <button
                class="btn-secondary"
                onclick="exportEncryptedBackup()"
            >
                Export Backup
            </button>

            <button
                class="btn-secondary"
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

            <button
                class="btn-danger"
                onclick="logout()"
            >
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

</div>

<script src="assets/js/auth-check.js"></script>
<script src="assets/js/auto-logout.js"></script>
<script src="assets/js/crypto.js"></script>
<script src="assets/js/vault-api.js"></script>
<script src="assets/js/vault-ui.js"></script>
<script src="assets/js/backup.js"></script>
<script src="assets/js/password-checker.js"></script>
<script src="assets/js/dashboard.js"></script>

</body>
</html>