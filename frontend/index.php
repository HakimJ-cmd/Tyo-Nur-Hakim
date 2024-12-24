<?php
// Konfigurasi Database
$host = "localhost"; // Nama host
$user = "root"; // Username database
$password = ""; // Password database
$database = "cv_tyo"; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// query buat get data riwayat_pendidikan user
$sql_riwayat = "SELECT * FROM riwayat_pendidikan";
$result_riwayat = $conn->query($sql_riwayat);

// query buat get data proyek user
$sql_project = "SELECT * FROM project";
$result_project = $conn->query($sql_project);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/styles.css">
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-black">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Tyo Nur Hakim</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#"><b>HOME</b></a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><b>EDUCATION</b></a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><b>PROJECT</b></a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><b>CONTACT</b></a></li>
                    <li class="nav-item">
                        <button class="btn hire-btn"><b>Hire me</b></button>
                    </li>
                </ul>
            </div>
        </div>
    </nav> 

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Hero Text -->
                <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 hero-content">
                    <h1><span>I’m</span> <br> <?= $row['nama'] ?></h1>
                    <!-- Tampilkan Deskripsi -->
                    <p class="my-3"><?= $row['deskripsi'] ?></p>
                    <a href="#" class="btn btn-custom">Download CV</a>
                </div>
                <!-- Hero Image -->
                <div class="col-md-6 text-center hero-image">
                    <img src="../backend/assets/images/<?= $row['foto'] ?>" alt="Foto" width="100">
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pendidikan</th>
                            <th>Tahun</th>
                            <th>Nama Sekolah/Kampus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($riwayat = $result_riwayat->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($riwayat['pendidikan']) ?></td>
                            <td><?= htmlspecialchars($riwayat['tahun']) ?></td>
                            <td><?= htmlspecialchars($riwayat['nama_sekolah_kampus']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </section>

    <section class="hero-section">
        <div class="container">
            <div class="row">
                <?php $no = 1; while ($project = $result_project->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card text-center">
                        <img src="../backend/assets/images/<?= htmlspecialchars($project['images']) ?>" class="card-img-top" alt="Gambar Proyek" width="100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= htmlspecialchars($project['project']) ?>
                            </h5>
                            <p class="card-text">
                                <?= htmlspecialchars($project['keterangan']) ?>
                            </p>
                             <a href="<?= htmlspecialchars($project['link_project']) ?>" target="_blank"><?= htmlspecialchars($project['link_project']) ?></a>
                        </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <footer class="py-4 bg-dark text-white" id="contact">
        <div class="container text-center">
            <p>Contact</p>
            <address>
                Address: Cipedes, Kota Tasikmalaya <br>
                Jawa Barat, Indonesia
            </address>
            <div>
                <a href="#" class="text-white me-3"><i class="bi bi-instagram" target="_blank"></i> Instagram </a>
                <a href="#" class="text-white me-3"><i class="bi bi-whatsapp" target="_blank"></i> WhatsApp </a>
            </div>
            <p class="mt-3 mb-0">© 2024 Tyo Nur Hakim-2203010041, All right reserved</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>