<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Inter, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background:
                radial-gradient(circle at top, #1e3a5f, #0f172a 60%);
            color: white;
        }

        .container {
            text-align: center;
            max-width: 600px;
            padding: 40px;
        }

        .badge {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 999px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 120px;
            line-height: 1;
            font-weight: 800;
            background: linear-gradient(135deg, #60a5fa, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        h2 {
            margin-top: 10px;
            font-size: 32px;
        }

        p {
            margin-top: 15px;
            color: #cbd5e1;
            line-height: 1.7;
        }

        .actions {
            margin-top: 35px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            text-decoration: none;
            padding: 14px 24px;
            border-radius: 14px;
            font-weight: 600;
            transition: .3s;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .1);
            color: white;
        }

        .glow {
            position: absolute;
            width: 400px;
            height: 400px;
            background: #2563eb;
            filter: blur(180px);
            opacity: .2;
            z-index: -1;
        }

        @media(max-width:768px) {
            h1 {
                font-size: 80px;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <div class="glow"></div>

    <div class="container">
        <span class="badge">404 Error</span>

        <h1>404</h1>

        <h2>Halaman Tidak Ditemukan</h2>

        <p>
            Maaf, halaman yang kamu cari mungkin sudah dipindahkan,
            dihapus, atau URL yang dimasukkan tidak valid.
        </p>

        <div class="actions">
            <a href="/" class="btn btn-primary">
                Kembali ke Beranda
            </a>

            <a href="javascript:history.back()" class="btn btn-secondary">
                Halaman Sebelumnya
            </a>
        </div>
    </div>

</body>

</html>
