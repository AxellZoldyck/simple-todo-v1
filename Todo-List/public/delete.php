<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Ambil data tugas yang akan dihapus
$result = mysqli_query($conn, "SELECT * FROM todos WHERE id = '$id' AND user_id = '$user_id'");
$todo = mysqli_fetch_assoc($result);

if (!$todo) {
    echo "Tugas tidak ditemukan.";
    exit;
}

// Hapus tugas jika konfirmasi sudah diterima
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_query($conn, "DELETE FROM todos WHERE id = '$id' AND user_id = '$user_id'");
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Tugas - ToDo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white text-center">
                    <h5 class="mb-0">Konfirmasi Penghapusan</h5>
                </div>
                <div class="card-body">
                    <p class="text-center mb-4">Anda yakin ingin menghapus tugas berikut?</p>
                    <div class="mb-3 text-center">
                        <h6><?= htmlspecialchars($todo['task']) ?></h6>
                        <small class="badge bg-warning"><?= $todo['status'] ?></small>
                    </div>
                    <form method="POST" class="text-center">
                        <button type="submit" class="btn btn-danger w-100">Hapus</button>
                    </form>
                    <p class="text-center mt-3 mb-0">
                        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
