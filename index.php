<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>SafePass</title>

<link
    rel="stylesheet"
    href="assets/css/style.css?v=999"
>

<style>

/* ========================= */
/* RESET */
/* ========================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

html,
body{
    width:100%;
    min-height:100vh;
    background:#0f172a;
    color:white;
    overflow-x:hidden;
}

/* ========================= */
/* PAGE */
/* ========================= */

.page{
    width:100%;
    min-height:100vh;
}

/* ========================= */
/* CONTAINER */
/* ========================= */

.container{
    width:100%;
    min-height:100vh;
    padding:20px;
}

/* ========================= */
/* TOPBAR */
/* ========================= */

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

/* ========================= */
/* ACTION GROUP */
/* ========================= */

.action-group{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

/* ========================= */
/* BUTTON */
/* ========================= */

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

.btn-primary{
    background:#4f46e5;
    color:white;
}

.btn-secondary{
    background:#334155;
    color:white;
}

.btn-danger{
    background:#dc2626;
    color:white;
}

.btn-success{
    background:#22c55e;
    color:white;
}

.btn-purple{
    background:#7c3aed;
    color:white;
}

/* ========================= */
/* TABLE */
/* ========================= */

.table-container{
    width:100%;
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    border-bottom:2px solid #334155;
}

th{
    text-align:left;
    padding:14px 10px;
    color:#cbd5e1;
    font-size:14px;
}

td{
    padding:14px 10px;
    border-bottom:1px solid #1f2937;
    color:#e2e8f0;
}

tr:hover{
    background:#111c2e;
}

/* ========================= */
/* FORM */
/* ========================= */

.form-wrapper{
    width:100%;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.form-box{
    width:100%;
    max-width:500px;
}

.form-box h2{
    margin-bottom:20px;
    font-size:28px;
}

label{
    display:block;
    margin-top:12px;
    margin-bottom:6px;
    color:#cbd5e1;
    font-size:14px;
}

input,
textarea{
    width:100%;
    padding:10px 12px;
    border-radius:8px;
    border:1px solid #334155;
    background:#0f172a;
    color:white;
    outline:none;
}

textarea{
    min-height:100px;
    resize:none;
}

/* ========================= */
/* PASSWORD WRAPPER */
/* ========================= */

.password-wrapper{
    position:relative;
    width:100%;
}

.password-wrapper input{
    padding-right:40px;
}

.eye-icon{
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#94a3b8;
    font-size:18px;
    user-select:none;
}

.eye-icon:hover{
    color:white;
}

/* ========================= */
/* GENERATOR */
/* ========================= */

.generator-box{
    margin-top:15px;
    padding:12px;
    border:1px solid #334155;
    border-radius:10px;
}

.checkbox-group{
    margin-top:6px;
}

/* ========================= */
/* AUTH PAGE */
/* ========================= */

.auth-container{
    width:100%;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.auth-card{
    width:100%;
    max-width:420px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(14px);
    border:1px solid rgba(255,255,255,0.12);
    border-radius:24px;
    padding:40px 35px;
    box-shadow:0 10px 30px rgba(0,0,0,0.35);
    color:white;
    animation:fadeIn 0.8s ease;
}

.logo{
    width:80px;
    height:80px;
    margin:auto;
    margin-bottom:20px;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:34px;
}

.login-logo{
    background:linear-gradient(
        135deg,
        #38bdf8,
        #6366f1
    );

    box-shadow:0 0 20px
    rgba(99,102,241,0.5);
}

.register-logo{
    background:linear-gradient(
        135deg,
        #22c55e,
        #06b6d4
    );

    box-shadow:0 0 20px
    rgba(34,197,94,0.4);
}

.auth-title{
    text-align:center;
    font-size:34px;
    margin-bottom:8px;
    font-weight:700;
}

.auth-subtitle{
    text-align:center;
    color:#cbd5e1;
    margin-bottom:30px;
    font-size:15px;
}

.center{
    text-align:center;
}

.center a{
    color:#93c5fd;
    text-decoration:none;
    font-size:14px;
}

.center a:hover{
    color:white;
    text-decoration:underline;
}

@keyframes fadeIn{

    from{
        opacity:0;
        transform:translateY(20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}

/* ========================= */
/* RESPONSIVE */
/* ========================= */

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
.password-field{
    display:flex;
    align-items:center;
    gap:6px;
}

.password-field input{
    width:140px;
    padding:8px;
    border-radius:6px;
    border:1px solid #334155;
    background:#0f172a;
    color:white;
}

.small-btn{
    padding:6px 10px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    background:#334155;
    color:white;
    font-size:12px;
}

.status-badge{
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}

.strength-weak{
    background:#dc2626;
    color:white;
}

.strength-medium{
    background:#f59e0b;
    color:white;
}

.strength-strong{
    background:#22c55e;
    color:white;
}

.strength-pwned{
    background:#7f1d1d;
    color:white;
}
</style>

</head>

<body>

<!-- ========================= -->
<!-- DASHBOARD PAGE -->
<!-- ========================= -->

<section
    id="dashboardPage"
    class="page"
>

    <div class="container">

        <div class="topbar">

            <div>

                <h2>
                    My Vault
                </h2>

                <p>
                    Kelola password dengan aman
                </p>

            </div>

            <div class="action-group">

                <button
                    class="btn-primary"
                    onclick="
                        showPage(
                            'addPage'
                        )
                    "
                >
                    Tambah Password
                </button>

                <button
                    class="btn-secondary"
                    onclick="
                        exportEncryptedBackup()
                    "
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
                    onchange="
                        importEncryptedBackup(event)
                    "
                >

                <button
                    class="btn-danger"
                    onclick="logout()"
                >
                    Logout
                </button>

            </div>

        </div>

        <!-- SEARCH & FILTER -->

        <div class="vault-tools">

            <input
                type="text"
                id="searchVault"
                placeholder="Cari service / username..."
            >

            <select id="filterService">

                <option value="all">
                    Semua Service
                </option>

            </select>

        </div>

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            Service
                        </th>

                        <th>
                            Username
                        </th>

                        <th>
                            Password
                        </th>

                        <th>
                            Keamanan
                        </th>

                        <th>
                            Catatan
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody id="vaultList"></tbody>

            </table>

        </div>

    </div>

</section>

<!-- ========================= -->
<!-- ADD PAGE -->
<!-- ========================= -->

<section
    id="addPage"
    class="page"
    style="display:none;"
>

    <div class="form-wrapper">

        <div class="form-box">

            <h2>
                Tambah Password
            </h2>

            <label>
                Service
            </label>

            <input
                type="text"
                id="service"
                placeholder="Contoh: Gmail"
            >

            <label>
                Username
            </label>

            <input
                type="text"
                id="username"
                placeholder="Username / Email"
            >

            <label>
                Password
            </label>

            <div class="password-wrapper">

                <input
                    type="password"
                    id="password"
                    placeholder="Password"
                >

                <span
                    class="eye-icon"
                    onclick="
                        togglePassword(
                            'password'
                        )
                    "
                >
                    👁
                </span>

            </div>

            <!-- GENERATOR -->

            <div class="generator-box">

                <h3>
                    Password Generator
                </h3>

                <label>
                    Panjang Password
                </label>

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
                    onclick="
                        generatePassword()
                    "
                >
                    Generate Password
                </button>

            </div>

            <label>
                Catatan
            </label>

            <textarea
                id="note"
                placeholder="Catatan tambahan"
            ></textarea>

            <!-- BUTTON -->

            <div class="action-group">

                <button
                    id="saveBtn"
                    class="btn-success"
                    onclick="saveVault()"
                >
                    Simpan
                </button>

                <button
                    class="btn-secondary"
                    onclick="
                        showPage(
                            'dashboardPage'
                        )
                    "
                >
                    Kembali
                </button>

            </div>

        </div>

    </div>

</section>

<!-- ========================= -->
<!-- EDIT PAGE -->
<!-- ========================= -->

<section
    id="editPage"
    class="page"
    style="display:none;"
>

    <div class="form-wrapper">

        <div class="form-box">

            <h2>
                Edit Vault
            </h2>

            <label>
                Service
            </label>

            <input
                type="text"
                id="editService"
                placeholder="Contoh: Gmail"
            >

            <label>
                Username / Email
            </label>

            <input
                type="text"
                id="editUsername"
                placeholder="Masukkan username"
            >

            <label>
                Password
            </label>

            <div class="password-wrapper">

                <input
                    type="password"
                    id="editPassword"
                    placeholder="Masukkan password"
                >

                <span
                    class="eye-icon"
                    onclick="
                        togglePassword(
                            'editPassword'
                        )
                    "
                >
                    👁
                </span>

            </div>

            <!-- GENERATOR -->

            <div class="generator-box">

                <h3>
                    Password Generator
                </h3>

                <label>
                    Panjang Password
                </label>

                <input
                    type="number"
                    id="editPasswordLength"
                    value="12"
                    min="4"
                    max="50"
                >

                <div class="checkbox-group">

                    <label>

                        <input
                            type="checkbox"
                            id="editUppercase"
                            checked
                        >

                        Huruf Besar

                    </label>

                </div>

                <div class="checkbox-group">

                    <label>

                        <input
                            type="checkbox"
                            id="editLowercase"
                            checked
                        >

                        Huruf Kecil

                    </label>

                </div>

                <div class="checkbox-group">

                    <label>

                        <input
                            type="checkbox"
                            id="editNumbers"
                            checked
                        >

                        Angka

                    </label>

                </div>

                <div class="checkbox-group">

                    <label>

                        <input
                            type="checkbox"
                            id="editSymbols"
                        >

                        Simbol

                    </label>

                </div>

                <button
                    class="btn-purple"
                    onclick="
                        generatePassword(true)
                    "
                >
                    Generate Password
                </button>

            </div>

            <label>
                Catatan
            </label>

            <textarea
                id="editNote"
                placeholder="Catatan tambahan"
            ></textarea>

            <!-- BUTTON -->

            <div class="action-group">

                <button
                    id="updateBtn"
                    class="btn-success"
                    onclick="updateVault()"
                >
                    Update Vault
                </button>

                <button
                    class="btn-secondary"
                    onclick="
                        showPage(
                            'dashboardPage'
                        )
                    "
                >
                    Kembali
                </button>

            </div>

        </div>

    </div>

</section>

<!-- ========================= -->
<!-- LOGIN PAGE -->
<!-- ========================= -->

<section
    id="loginPage"
    class="page"
>

    <div class="auth-container">

        <div class="auth-card">

            <h1 class="auth-title">
                ReKey
            </h1>

            <p class="auth-subtitle">
                Simpan password dengan aman dan terenkripsi
            </p>

            <form id="loginForm">

                <div>

                    <label>
                        Email
                    </label>

                    <input
                        type="email"
                        id="loginEmail"
                        placeholder="Masukkan email"
                        required
                    >

                </div>

                <div>

                    <label>
                        Master Password
                    </label>

                    <input
                        type="password"
                        id="loginPassword"
                        placeholder="Masukkan master password"
                        required
                    >

                </div>

                <button
                    type="submit"
                    class="btn-primary"
                    id="loginBtn"
                >
                    Login
                </button>

            </form>

            <br>

            <div class="center">

                <a
                    href="#"
                    onclick="
                        showPage(
                            'registerPage'
                        )
                    "
                >
                    Belum punya akun? Register
                </a>

            </div>

        </div>

    </div>

</section>

<!-- ========================= -->
<!-- REGISTER PAGE -->
<!-- ========================= -->

<section
    id="registerPage"
    class="page"
    style="display:none;"
>

    <div class="auth-container">

        <div class="auth-card">

            <h1 class="auth-title">
                Create Account
            </h1>

            <p class="auth-subtitle">
                Buat akun vault baru dengan keamanan maksimal
            </p>

            <form id="registerForm">

                <div>

                    <label>
                        Email
                    </label>

                    <input
                        type="email"
                        id="registerEmail"
                        placeholder="Masukkan email"
                        required
                    >

                </div>

                <div>

                    <label>
                        Master Password
                    </label>

                    <input
                        type="password"
                        id="registerPassword"
                        placeholder="Masukkan master password"
                        required
                    >

                </div>

                <button
                    type="submit"
                    class="btn-primary"
                    id="registerBtn"
                >
                    Register
                </button>

            </form>

            <br>

            <div class="center">

                <a
                    href="#"
                    onclick="
                        showPage(
                            'loginPage'
                        )
                    "
                >
                    Sudah punya akun? Login
                </a>

            </div>

        </div>

    </div>

</section>

<!-- ========================= -->
<!-- ROUTER -->
<!-- ========================= -->

<script>

function showPage(pageId){

    document
    .querySelectorAll(".page")
    .forEach(function(page){

        page.style.display =
            "none";

    });

    document
    .getElementById(pageId)
    .style.display =
        "block";

}

</script>

<!-- ========================= -->
<!-- TOGGLE PASSWORD -->
<!-- ========================= -->

<script>

function togglePassword(id){

    const input =
        document.getElementById(id);

    if(
        input.type ===
        "password"
    ){

        input.type = "text";

    }else{

        input.type = "password";

    }

}

</script>


<!-- ========================= -->
<!-- SCRIPT -->
<!-- ========================= -->



<script src="assets/js/auto-logout.js"></script>

<script src="assets/js/crypto.js"></script>

<script src="assets/js/vault-api.js"></script>

<script src="assets/js/vault-ui.js"></script>

<script src="assets/js/backup.js"></script>

<script src="assets/js/password-checker.js"></script>

<script src="assets/js/dashboard.js"></script>

<script src="assets/js/add.js"></script>

<script src="assets/js/edit.js"></script>

<script src="assets/js/generator.js"></script>

<script src="assets/js/login.js"></script>

<script src="assets/js/auth.js"></script>

<!-- ========================= -->
<!-- LOAD VAULT -->
<!-- ========================= -->

<script>

if(

    sessionStorage.getItem(
        "isLoggedIn"
    )

){

    showPage(
        "dashboardPage"
    );

    if(
        typeof loadVault ===
        "function"
    ){

        loadVault();

    }

}else{

    showPage(
        "loginPage"
    );

}

</script>

</body>
</html>