<?php
require_once 'koneksi.php';
require_once 'helpers.php';
require_login();

// ambil list barang
$result = $mysqli->query("SELECT * FROM barang ORDER BY created_at DESC");
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Inventaris Barang</title>
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
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #1b263b;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #e0e0e0;
        }

        p.welcome {
            margin-bottom: 20px;
            font-size: 16px;
            text-align: center;
        }

        .links {
            text-align: center;
            margin-bottom: 20px;
        }

        .links a {
            display: inline-block;
            margin: 0 8px;
            padding: 10px 20px;
            border-radius: 10px;
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .links a:hover {
            background: linear-gradient(45deg, #2a5298, #1e3c72);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #415a77;
        }

        table th {
            background-color: #1e3c72;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #162447;
        }

        table a {
            color: #89c2d9;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        table a:hover {
            color: #fff;
            text-shadow: 0 0 5px #89c2d9;
        }

        table span {
            font-style: italic;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Inventaris Barang</h1>
        <p class="welcome">Selamat datang, <?= htmlspecialchars($_SESSION['user_name']) ?></p>

        <div class="links">
            <a href="barang_add.php">Tambah Barang</a>
            <a href="transaksi.php">Lihat Transaksi</a>
            <a href="logout.php">Logout</a>
        </div>

        <table>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Tersedia</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['kode']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['deskripsi'])) ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td><?= $row['tersedia'] ?></td>
                    <td><?= htmlspecialchars($row['lokasi']) ?></td>
                    <td>
                        <a href="barang_edit.php?id=<?= $row['id'] ?>">Edit</a> |
                        <a href="barang_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus barang?')">Hapus</a> |
                        <?php if ($row['tersedia'] > 0): ?>
                            <a href="pinjam.php?id=<?= $row['id'] ?>">Pinjam</a>
                        <?php else: ?>
                            <span>Kosong</span>
                        <?php endif; ?>
                        <?php if ($row['jumlah'] > $row['tersedia']): ?>
                            | <a href="kembalikan.php?id=<?= $row['id'] ?>">Kembalikan</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>
