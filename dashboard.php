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

    <div>

        <a href="add.php">

            <button class="action-btn">
                Tambah Password
            </button>

        </a>

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
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>

        </thead>

        <tbody id="vaultList"></tbody>

    </table>

</div>

<script src="assets/js/auth-check.js"></script>
<script src="assets/js/auto-logout.js"></script>
<script src="assets/js/crypto.js"></script>
<script src="assets/js/dashboard.js"></script>

</body>
</html>