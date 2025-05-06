<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "SELECT * FROM todos WHERE id = '$id' AND user_id = '$user_id'");
$todo = mysqli_fetch_assoc($result);

if (!$todo) {
    echo "Tugas tidak ditemukan.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task = mysqli_real_escape_string($conn, $_POST['task']);
    $status = $_POST['status'];
    
    mysqli_query($conn, "UPDATE todos SET task = '$task', status = '$status' WHERE id = '$id'");
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas - ToDo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-5">
            <a href="dashboard.php" class="btn btn-secondary mb-3">← Kembali</a>
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white text-center">
                    <h4 class="mb-0">Edit Tugas</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tugas</label>
                            <input type="text" name="task" class="form-control" value="<?= htmlspecialchars($todo['task']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="Belum" <?= $todo['status'] === 'Belum' ? 'selected' : '' ?>>Belum</option>
                                <option value="Selesai" <?= $todo['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
