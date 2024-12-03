<?php
include 'koneksi.php';
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

// Proses Hapus
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Hapus file di folder
    $query = "SELECT file_tugas FROM tugas_sekolah WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if (isset($row['file_tugas']) && file_exists('uploads/' . $row['file_tugas'])) {
        unlink('uploads/' . $row['file_tugas']);
    }

    // Hapus data di database
    $query = "DELETE FROM tugas_sekolah WHERE id = $id";
    mysqli_query($conn, $query);
    header('Location: index.php');
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

        <h2>Daftar Tugas</h2>
        <div class="mb-3">
            <a href="tambah.php"><span class="btn btn-success disabled">Tambahkan Tugas</span></a>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>File Tugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM tugas_sekolah";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['kelas']}</td>
                    <td>{$row['mata_pelajaran']}</td>
                    <td><a href='uploads/{$row['file_tugas']}' class='btn btn-primary btn-sm' target='_blank'>Unduh</a></td>
                    <td>
                        <a href='?hapus={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus data ini?\");'>Hapus</a>
                        <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                    </td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>