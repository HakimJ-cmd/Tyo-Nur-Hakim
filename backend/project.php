<?php
include 'database.php';

// Cek apakah ID user ada di URL
if (!isset($_GET['user_id'])) {
    die("ID pengguna tidak ditemukan.");
}

$user_id = $_GET['user_id']; // Ambil ID user dari parameter URL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project = $_POST['project'];
    $keterangan = $_POST['keterangan'];
    $link_project = $_POST['link_project'];

    // Proses upload gambar
    $foto = $_FILES['images']['name']; // Ambil nama file
    $target_dir = "assets/images/"; // Direktori penyimpanan gambar
    $target_file = $target_dir . basename($foto); // Path lengkap file

    if (move_uploaded_file($_FILES['images']['tmp_name'], $target_file)) {
        // Jika upload berhasil, simpan data ke database
        $sql = "INSERT INTO project (user_id, project, keterangan, images, link_project) 
                VALUES ('$user_id', '$project', '$keterangan', '$foto', '$link_project')";

        if ($conn->query($sql) === TRUE) {
            header("Location: detail.php?id=" . $user_id); // Kembali ke halaman detail
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Gagal mengunggah gambar. Pastikan direktori tujuan memiliki izin tulis.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Tambah Project</h1>
        <form method="POST" enctype="multipart/form-data"> <!-- Tambahkan enctype -->
            <div class="mb-3">
                <label for="project" class="form-label">Project</label>
                <input type="text" class="form-control" id="project" name="project" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" required>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="images" name="images" required>
            </div>
            <div class="mb-3">
                <label for="link_project" class="form-label">Link</label>
                <input type="text" class="form-control" id="link_project" name="link_project" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="detail.php?id=<?= $user_id ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
