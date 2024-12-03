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

// Proses Simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $mata_pelajaran = $_POST['mata_pelajaran'];
    $file_name = $_FILES['file_tugas']['name'];
    $file_tmp = $_FILES['file_tugas']['tmp_name'];

    $upload_path = 'uploads/' . $file_name;

    if (move_uploaded_file($file_tmp, $upload_path)) {
        $query = "INSERT INTO tugas_sekolah (nama, kelas, mata_pelajaran, file_tugas) 
                  VALUES ('$nama', '$kelas', '$mata_pelajaran', '$file_name')";
        mysqli_query($conn, $query);
        header('Location: index.php');
    } else {
        echo "Gagal mengupload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Tugas Sekolah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<div class="container">
    <h1 class="mb-4"> Tugas Sekolah</h1>

    <!-- Form Tambah Tugas -->
    <form action="" method="post" enctype="multipart/form-data" class="mb-4">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <input type="text" name="kelas" id="kelas" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="mata_pelajaran" class="form-label">Mata Pelajaran</label>
            <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="file_tugas" class="form-label">File Tugas</label>
            <input type="file" name="file_tugas" id="file_tugas" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
    
</div>

</body>
</html>
