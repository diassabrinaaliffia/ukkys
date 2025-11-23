<?php
require_once 'koneksi.php';
require_once 'helpers.php';
require_login();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $jumlah = (int)$_POST['jumlah'];
    $lokasi = trim($_POST['lokasi']);
    $kode = trim($_POST['kode']);

    if ($nama === '' || $jumlah < 0) $error = 'Nama dan jumlah harus diisi dengan benar.';
    else {
        $tersedia = $jumlah;
        $stmt = $mysqli->prepare("INSERT INTO barang (nama, deskripsi, jumlah, tersedia, lokasi, kode) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssiiss', $nama, $deskripsi, $jumlah, $tersedia, $lokasi, $kode);
        if ($stmt->execute()) {
            header('Location: index.php');
            exit;
        } else {
            $error = "Gagal menyimpan: " . $mysqli->error;
        }
    }
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tambah Barang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0d1b2a, #1b263b);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background-color: #1b263b;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            width: 450px;
        }

        h2 {
            margin-bottom: 25px;
            color: #e0e0e0;
            text-align: center;
            font-size: 28px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #c0c0c0;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            background-color: #0d1b2a;
            color: #fff;
            font-size: 15px;
            transition: 0.3s;
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: none;
            box-shadow: 0 0 8px #415a77;
        }

        .error {
            background-color: #ff4d4f;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            color: #fff;
            font-weight: 500;
            text-align: center;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            background: linear-gradient(45deg, #2a5298, #1e3c72);
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Tambah Barang</h2>
        <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <form method="post">
            <label>Nama Barang</label>
            <input type="text" name="nama" required>

            <label>Kode (unik)</label>
            <input type="text" name="kode">

            <label>Deskripsi</label>
            <textarea name="deskripsi"></textarea>

            <label>Jumlah</label>
            <input type="number" name="jumlah" value="1" min="0" required>

            <label>Lokasi</label>
            <input type="text" name="lokasi">

            <div class="btn-group">
                <button type="submit">Simpan</button>
                <button type="button" onclick="window.location.href='index.php'">Kembali</button>
            </div>
        </form>
    </div>
</body>

</html>
