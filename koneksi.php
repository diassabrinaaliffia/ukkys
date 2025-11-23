<?php
// koneksi.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; // ganti sesuai
$DB_NAME = 'inventaris';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    die("Gagal koneksi MySQL: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
