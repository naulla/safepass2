<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SafePass</title>

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#0f172a,#1e293b,#334155);
            overflow:hidden;
        }

        .auth-container{
            width:100%;
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
            background:linear-gradient(135deg,#38bdf8,#6366f1);
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:34px;
            box-shadow:0 0 20px rgba(99,102,241,0.5);
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

        form{
            display:flex;
            flex-direction:column;
            gap:18px;
        }

        label{
            font-size:14px;
            margin-bottom:6px;
            color:#e2e8f0;
        }

        input{
            width:100%;
            padding:14px;
            border:none;
            border-radius:12px;
            background:rgba(255,255,255,0.1);
            color:white;
            font-size:15px;
            outline:none;
            transition:0.3s;
            border:1px solid transparent;
        }

        input::placeholder{
            color:#cbd5e1;
        }

        input:focus{
            border:1px solid #6366f1;
            background:rgba(255,255,255,0.15);
            box-shadow:0 0 10px rgba(99,102,241,0.35);
        }

        .btn-primary{
            margin-top:10px;
            padding:14px;
            border:none;
            border-radius:12px;
            background:linear-gradient(135deg,#6366f1,#4f46e5);
            color:white;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s ease;
        }

        .btn-primary:hover{
            transform:translateY(-3px);
            box-shadow:0 10px 20px rgba(99,102,241,0.4);
        }

        .center{
            text-align:center;
        }

        .center a{
            color:#93c5fd;
            text-decoration:none;
            font-size:14px;
            transition:0.3s;
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

    </style>

</head>

<body>

<div class="auth-container">

    <div class="auth-card">

        <div class="logo">
            🔐
        </div>

        <h1 class="auth-title">
            SafePass
        </h1>

        <p class="auth-subtitle">
            Simpan password dengan aman dan terenkripsi
        </p>

        <form id="loginForm">

            <div>

                <label>Email</label>

                <input
                    type="email"
                    id="email"
                    placeholder="Masukkan email"
                    required
                >

            </div>

            <div>

                <label>Master Password</label>

                <input
                    type="password"
                    id="password"
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

            <a href="register.php">
                Belum punya akun? Register
            </a>

        </div>

    </div>

</div>

<script src="assets/js/crypto.js"></script>
<script src="assets/js/login.js"></script>

</body>
</html>