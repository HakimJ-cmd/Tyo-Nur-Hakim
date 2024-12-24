<?php 
include 'database.php'; 
 
$id = $_GET['user_id']; 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $project = $_POST['project']; 
    $keterangan = $_POST['keterangan']; 
    $link_project = $_POST['link_project']; 
 
    // Cek jika ada images baru yang diupload 
    if (!empty($_FILES['images']['name'])) { 
        $images = $_FILES['images']['name']; 
        $target_dir = "assets/images/"; 
        $target_file = $target_dir . basename($images); 
        move_uploaded_file($_FILES['images']['tmp_name'], $target_file); 
    } else { 
        // Jika images tidak diubah, ambil images lama 
        $sql = "SELECT images FROM project WHERE id = '$id'"; 
        $result = $conn->query($sql); 
        $row = $result->fetch_assoc(); 
        $images = $row['images']; 
    } 
 
    $sql = "UPDATE project 
            SET project='$project', 
                keterangan='$keterangan', 
                link_project='$link_project', 
                images='$images' 
            WHERE id='$id'"; 
 
    if ($conn->query($sql) === TRUE) { 
        header('Location: index.php'); 
        exit(); 
    } else { 
        echo "Error: " . $conn->error; 
    } 
} 
 
// Ambil data untuk diedit 
$sql = "SELECT * FROM project WHERE id = '$id'"; 
$result = $conn->query($sql); 
$row = $result->fetch_assoc(); 
?> 
 
<!DOCTYPE html> 
<html lang="id"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Edit Identitas Diri</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"> 
</head> 
<body> 
    <div class="container mt-5"> 
        <h1 class="mb-4">Edit Identitas Diri</h1> 
        <form action="edit_project.php?user_id=<?= htmlspecialchars($id) ?>" method="POST" enctype="multipart/form-data"> 
            <div class="mb-3"> 

                <label for="project" class="form-label">Project</label> 
                <input type="text" class="form-control" id="project" name="project" 
                    value="<?= isset($row['project']) ? htmlspecialchars($row['project']) : '' ?>" 
                    required>
            </div>
            <div class="mb-3"> 
                <label for="keterangan" class="form-label">Keterangan</label> 
                <input type="text" class="form-control" id="keterangan" name="keterangan" required>
            </div> 
            <div class="mb-3"> 
                <label for="link_project" class="form-label">link_project</label> 
               <input type="text" class="form-control" id="link_project" name="link_project"
                value="<?= isset($row['link_project']) ? htmlspecialchars($row['link_project']) : '' ?>"
                required>
            </div> 
            <div class="mb-3"> 
                <label for="images" class="form-label">images</label> 
                <input type="file" class="form-control" id="images" name="images"> 
                <img src="assets/images/<?= htmlspecialchars($row['images']) ?>" width="100" class="mt-2"> 
            </div> 
            <button type="submit" class="btn btn-warning">Update</button> 
        </form> 
        <a href="index.php" class="btn btn-secondary mt-3">Kembali</a> 
    </div> 
</body> 
</html> 
 
<?php $conn->close(); ?>
