<?php
$host = 'localhost';
$user = 'root';        // sesuaikan dengan username MySQL kamu
$pass = '';            // sesuaikan dengan password MySQL kamu
$db   = 'todo_app';    // nama database

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
