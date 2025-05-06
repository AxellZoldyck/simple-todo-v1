<?php
require_once '../includes/auth.php';
require_once '../config/db.php';

$user_id = $_SESSION['user_id'];
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'Semua';
$where_clause = "user_id = '$user_id'";

if ($status_filter === 'Belum' || $status_filter === 'Selesai') {
    $where_clause .= " AND status = '$status_filter'";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task'])) {
    $task = mysqli_real_escape_string($conn, $_POST['task']);
    mysqli_query($conn, "INSERT INTO todos (user_id, task) VALUES ('$user_id', '$task')");
    header("Location: dashboard.php");
    exit;
}

$todos = mysqli_query($conn, "SELECT * FROM todos WHERE $where_clause ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ToDo App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Dashboard</h2>
        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            Tambah Tugas
        </div>
        <div class="card-body">
            <form method="POST" class="d-flex gap-2">
                <input type="text" name="task" class="form-control" placeholder="Tulis tugas..." required>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>

    <div class="mb-4">
        <form method="GET" class="d-flex align-items-center gap-2">
            <label class="fw-semibold">Filter:</label>
            <select name="status" class="form-select w-auto" onchange="this.form.submit()">
                <option value="Semua" <?= $status_filter === 'Semua' ? 'selected' : '' ?>>Semua</option>
                <option value="Belum" <?= $status_filter === 'Belum' ? 'selected' : '' ?>>Belum</option>
                <option value="Selesai" <?= $status_filter === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
            </select>
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            Daftar Tugas
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                <?php if (mysqli_num_rows($todos) === 0): ?>
                    <li class="list-group-item text-center text-muted">Tidak ada tugas.</li>
                <?php else: ?>
                    <?php while ($row = mysqli_fetch_assoc($todos)): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-semibold"><?= htmlspecialchars($row['task']) ?></span>
                                <small class="badge bg-<?= $row['status'] === 'Selesai' ? 'success' : 'warning' ?> ms-2">
                                    <?= $row['status'] ?>
                                </small>
                            </div>
                            <div>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger">Hapus</a>
                            </div>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
