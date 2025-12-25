<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koneksi Terputus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-card {
            max-width: 500px;
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .icon-box {
            font-size: 80px;
            color: #dc3545;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="error-card">
        <div class="icon-box">🔌</div>
        <h2 class="fw-bold text-danger mb-3">Gagal Terhubung ke Database</h2>
        <p class="text-muted mb-4">
            Sistem tidak bisa menghubungi server database. <br>
            Biasanya ini terjadi karena <strong>XAMPP / MySQL belum dinyalakan</strong>.
        </p>
        <div class="alert alert-warning text-start small">
            <strong>Tips Perbaikan:</strong><br>
            1. Buka XAMPP Control Panel.<br>
            2. Klik tombol <strong>Start</strong> pada bagian MySQL.<br>
            3. Refresh halaman ini.
        </div>
        <a href="{{ url('/') }}" class="btn btn-primary px-4 mt-3">Coba Refresh Halaman</a>
    </div>
</body>

</html>
