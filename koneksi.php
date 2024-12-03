<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'tugas_sekolah_db';

$conn = mysqli_connect($host, $user, $password, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>