<?php
require_once 'koneksi.php';
require_once 'helpers.php';
require_login();

$id = (int)($_GET['id'] ?? 0);
$stmt = $mysqli->prepare("SELECT * FROM barang WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
if (!$data = $res->fetch_assoc()) {
    die("Barang tidak ditemukan.");
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $deskripsi = trim($_POST['deskripsi']);
    $jumlah = (int)$_POST['jumlah'];
    $lokasi = trim($_POST['lokasi']);
    $kode = trim($_POST['kode']);

    // adjust 'tersedia' bila total jumlah berubah
    $selisih = $jumlah - $data['jumlah'];
    $tersedia = $data['tersedia'] + $selisih;
    if ($tersedia < 0) $tersedia = 0;

    $stmt = $mysqli->prepare("UPDATE barang SET nama=?, deskripsi=?, jumlah=?, tersedia=?, lokasi=?, kode=? WHERE id=?");
    $stmt->bind_param('ssiissi', $nama, $deskripsi, $jumlah, $tersedia, $lokasi, $kode, $id);
    if ($stmt->execute()) {
        header('Location: index.php');
        exit;
    } else {
        $error = "Gagal update: " . $mysqli->error;
    }
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Edit Barang</title>
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

        button {
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 10px;
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            margin-bottom: 10px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            background: linear-gradient(45deg, #2a5298, #1e3c72);
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

        .btn-wrapper {
            text-align: center;
        }

        .btn-wrapper a {
            display: inline-block;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 10px;
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: #fff;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-wrapper a:hover {
            background: linear-gradient(45deg, #2a5298, #1e3c72);
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Barang</h2>
        <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <form method="post">
            <label>Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

            <label>Kode</label>
            <input type="text" name="kode" value="<?= htmlspecialchars($data['kode']) ?>">

            <label>Deskripsi</label>
            <textarea name="deskripsi"><?= htmlspecialchars($data['deskripsi']) ?></textarea>

            <label>Jumlah (total)</label>
            <input type="number" name="jumlah" value="<?= $data['jumlah'] ?>" min="0" required>

            <label>Lokasi</label>
            <input type="text" name="lokasi" value="<?= htmlspecialchars($data['lokasi']) ?>">

            <button type="submit">Update</button>
        </form>
        <div class="btn-wrapper">
            <a href="index.php">Kembali</a>
        </div>
    </div>
</body>

</html>
