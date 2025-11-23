<?php
require_once 'koneksi.php';
require_once 'helpers.php';
require_login();

$sql = "SELECT t.*, b.nama AS nama_barang FROM transaksi t JOIN barang b ON t.barang_id = b.id ORDER BY t.tanggal DESC";
$res = $mysqli->query($sql);
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Transaksi</title>
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

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #e0e0e0;
        }

        .btn-wrapper {
            text-align: center;
            margin-bottom: 15px;
        }

        .btn-wrapper a {
            display: inline-block;
            padding: 10px 25px;
            border-radius: 10px;
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-wrapper a:hover {
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

        table tr:hover {
            background-color: #274690;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Daftar Transaksi</h2>
        <div class="btn-wrapper">
            <a href="index.php">Kembali</a>
        </div>
        <table>
            <tr>
                <th>Tanggal</th>
                <th>Barang</th>
                <th>Peminjam</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Catatan</th>
            </tr>
            <?php while ($row = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($row['peminjam']) ?></td>
                    <td><?= $row['jenis'] ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td><?= htmlspecialchars($row['catatan']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>
