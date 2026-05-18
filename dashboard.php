<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

html, body{
    width:100%;
    min-height:100vh;
    background:#0f172a;
    color:white;
    overflow-x:hidden;
}

/* FULL SCREEN CONTAINER (NO CARD EFFECT) */
.container{
    width:100%;
    min-height:100vh;
    padding:20px;
}

/* TOPBAR FULL WIDTH FLAT */
.topbar{
    width:100%;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;

    padding:10px 0;
    margin-bottom:20px;
}

.topbar h2{
    font-size:32px;
}

.topbar p{
    color:#94a3b8;
    font-size:14px;
}

/* ACTION BUTTON */
.action-group{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

/* BUTTON */
button{
    border:none;
    padding:10px 14px;
    border-radius:8px;
    cursor:pointer;
    font-size:14px;
    font-weight:bold;
    transition:0.2s;
}

button:hover{
    opacity:0.85;
}

.btn-primary{ background:#4f46e5; color:white; }
.btn-secondary{ background:#334155; color:white; }
.btn-danger{ background:#dc2626; color:white; }

/* TABLE FULL WIDTH CLEAN */
.table-container{
    width:100%;
}

table{
    width:100%;
    border-collapse:collapse;
}

/* HEADER SIMPLE (NO BOX LOOK) */
thead{
    border-bottom:2px solid #334155;
}

th{
    text-align:left;
    padding:14px 10px;
    color:#cbd5e1;
    font-size:14px;
}

/* ROW CLEAN LOOK */
td{
    padding:14px 10px;
    border-bottom:1px solid #1f2937;
    color:#e2e8f0;
}

/* hover subtle saja */
tr:hover{
    background:#111c2e;
}

/* RESPONSIVE */
@media(max-width:768px){

    .topbar{
        flex-direction:column;
        align-items:flex-start;
    }

    .action-group{
        width:100%;
    }

    button{
        width:100%;
    }
}

</style>

</head>

<body>

<div class="container">

    <div class="topbar">

        <div>
            <h2>🔐 My Vault</h2>
            <p>Kelola password dengan aman</p>
        </div>

        <div class="action-group">

            <a href="add.php">
                <button class="btn-primary">Tambah Password</button>
            </a>

            <button class="btn-secondary" onclick="exportEncryptedBackup()">
                Export Backup
            </button>

            <button class="btn-secondary"
                onclick="document.getElementById('importBackupInput').click()">
                Import Backup
            </button>

            <input type="file" id="importBackupInput" accept=".json"
                style="display:none"
                onchange="importEncryptedBackup(event)">

            <button class="btn-danger" onclick="logout()">
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