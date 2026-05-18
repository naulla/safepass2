<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SafePass</title>

    <link rel="stylesheet" href="assets/css/style.css">

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

        .container{
            width:90%;
            max-width:420px;
            background:rgba(255,255,255,0.08);
            backdrop-filter:blur(12px);
            border:1px solid rgba(255,255,255,0.15);
            border-radius:24px;
            padding:50px 35px;
            text-align:center;
            box-shadow:0 10px 30px rgba(0,0,0,0.35);
            color:white;
            animation:fadeIn 1s ease;
        }

        .logo{
            width:85px;
            height:85px;
            margin:auto;
            margin-bottom:20px;
            border-radius:50%;
            background:linear-gradient(135deg,#38bdf8,#6366f1);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:38px;
            box-shadow:0 0 20px rgba(99,102,241,0.5);
        }

        h1{
            font-size:42px;
            margin-bottom:10px;
            font-weight:700;
        }

        p{
            color:#cbd5e1;
            font-size:16px;
            line-height:1.6;
            margin-bottom:35px;
        }

        .btn-group{
            display:flex;
            gap:15px;
            justify-content:center;
            flex-wrap:wrap;
        }

        .btn{
            flex:1;
            min-width:130px;
            padding:14px 20px;
            border:none;
            border-radius:12px;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s ease;
        }

        .login-btn{
            background:#6366f1;
            color:white;
        }

        .login-btn:hover{
            background:#4f46e5;
            transform:translateY(-3px);
            box-shadow:0 8px 20px rgba(99,102,241,0.4);
        }

        .register-btn{
            background:white;
            color:#0f172a;
        }

        .register-btn:hover{
            background:#e2e8f0;
            transform:translateY(-3px);
            box-shadow:0 8px 20px rgba(255,255,255,0.25);
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

    <div class="container">

        <div class="logo">
            🔒
        </div>

        <h1>SafePass</h1>

        <p>
            Zero Knowledge Password Manager <br>
            Simpan password dengan aman, modern, dan terenkripsi.
        </p>

        <div class="btn-group">

            <a href="login.php">
                <button class="btn login-btn">
                    Login
                </button>
            </a>

            <a href="register.php">
                <button class="btn register-btn">
                    Register
                </button>
            </a>

        </div>

    </div>

</body>
</html>