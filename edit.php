<?php
include 'koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Query untuk mengambil data berdasarkan ID
$query = "SELECT * FROM tugas_sekolah WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan!");
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $mata_pelajaran = $_POST['mata_pelajaran'];

    // Proses file baru jika ada
    if ($_FILES['file_tugas']['name']) {
        $file_name = $_FILES['file_tugas']['name'];
        $file_tmp = $_FILES['file_tugas']['tmp_name'];
        $upload_path = 'uploads/' . $file_name;

        // Hapus file lama
        if (file_exists('uploads/' . $data['file_tugas'])) {
            unlink('uploads/' . $data['file_tugas']);
        }

        // Upload file baru
        move_uploaded_file($file_tmp, $upload_path);
    } else {
        $file_name = $data['file_tugas']; // Gunakan file lama
    }

    // Update data di database
    $update_query = "UPDATE tugas_sekolah 
                     SET nama = '$nama', kelas = '$kelas', mata_pelajaran = '$mata_pelajaran', file_tugas = '$file_name' 
                     WHERE id = $id";
    mysqli_query($conn, $update_query);

    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<div class="container">
    <h1 class="mb-4">Edit Tugas</h1>

    <!-- Form Edit Tugas -->
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['nama']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <input type="text" name="kelas" id="kelas" class="form-control" value="<?= $data['kelas']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="mata_pelajaran" class="form-label">Mata Pelajaran</label>
            <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control" value="<?= $data['mata_pelajaran']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="file_tugas" class="form-label">File Tugas (Kosongkan jika tidak ingin mengganti)</label>
            <input type="file" name="file_tugas" id="file_tugas" class="form-control">
            <?php if ($data['file_tugas']): ?>
                <p>File saat ini: <a href="uploads/<?= $data['file_tugas'] ?>"><?= $data['file_tugas'] ?></a></p>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

</body>
</html>
