<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Vault</title>

<style>

/* RESET */
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
}

/* CONTAINER */
.container{
    width:100%;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* FORM BOX */
.form-box{
    width:100%;
    max-width:500px;
}

/* TITLE */
h2{
    margin-bottom:20px;
    font-size:28px;
}

/* LABEL */
label{
    display:block;
    margin-top:12px;
    margin-bottom:6px;
    color:#cbd5e1;
    font-size:14px;
}

/* INPUT */
input, textarea{
    width:100%;
    padding:10px 12px;
    border-radius:8px;
    border:1px solid #334155;
    background:#0f172a;
    color:white;
    outline:none;
}

/* PASSWORD WRAPPER */
.password-wrapper{
    position:relative;
    width:100%;
}

/* INPUT SPACE FOR ICON */
.password-wrapper input{
    padding-right:40px;
}

/* EYE ICON (POJOK KANAN) */
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

/* TEXTAREA */
textarea{
    min-height:100px;
    resize:none;
}

/* BUTTON */
button{
    width:100%;
    margin-top:12px;
    padding:10px 14px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
    transition:0.2s;
}

button:hover{
    opacity:0.85;
}

.btn-secondary{
    background:#334155;
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

/* LINK */
a{
    color:#60a5fa;
    text-decoration:none;
    font-size:14px;
}

a:hover{
    text-decoration:underline;
}

/* GENERATOR BOX */
.generator-box{
    margin-top:15px;
    padding:12px;
    border:1px solid #334155;
    border-radius:10px;
}

.checkbox-group{
    margin-top:6px;
}

</style>

</head>

<body>

<div class="container">

    <div class="form-box">

        <h2>🔐 Tambah Password</h2>

        <label>Service</label>
        <input type="text" id="service" placeholder="Contoh: Gmail">

        <label>Username</label>
        <input type="text" id="username" placeholder="Username / Email">

        <label>Password</label>

        <!-- PASSWORD FIELD + EYE -->
        <div class="password-wrapper">

            <input type="password" id="password" placeholder="Password">

            <span class="eye-icon" onclick="togglePassword()">
                👁
            </span>

        </div>

        <!-- GENERATOR -->
        <div class="generator-box">

            <h3>Password Generator</h3>

            <label>Panjang Password</label>

            <input type="number" id="passwordLength" value="12" min="4" max="50">

            <div class="checkbox-group">
                <label><input type="checkbox" id="uppercase" checked> Huruf Besar</label>
            </div>

            <div class="checkbox-group">
                <label><input type="checkbox" id="lowercase" checked> Huruf Kecil</label>
            </div>

            <div class="checkbox-group">
                <label><input type="checkbox" id="numbers" checked> Angka</label>
            </div>

            <div class="checkbox-group">
                <label><input type="checkbox" id="symbols"> Simbol</label>
            </div>

            <button class="btn-purple" onclick="generatePassword()">
                Generate Password
            </button>

        </div>

        <label>Catatan</label>
        <textarea id="note" placeholder="Catatan tambahan"></textarea>

        <button class="btn-success" onclick="saveVault()">
            Simpan
        </button>

        <div style="margin-top:15px;">
            <a href="dashboard.php">← Kembali ke Dashboard</a>
        </div>

    </div>

</div>

<script>
function togglePassword(){

    const input = document.getElementById("password");

    if(input.type === "password"){
        input.type = "text";
    }else{
        input.type = "password";
    }

}
</script>

<script src="assets/js/auth-check.js"></script>
<script src="assets/js/crypto.js"></script>
<script src="assets/js/add.js"></script>
<script src="assets/js/generator.js"></script>
<script src="assets/js/auto-logout.js"></script>

</body>
</html>