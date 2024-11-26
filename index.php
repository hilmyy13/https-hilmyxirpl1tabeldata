<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_siswa");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tambah data siswa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tambah"])) {
    $nis = $_POST["nis"];
    $nama = $_POST["nama"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $jurusan = $_POST["jurusan"];
    $kelas = $_POST["kelas"];
    $alamat = $_POST["alamat"];

    $sql = "INSERT INTO siswa (nis, nama, jenis_kelamin, jurusan, kelas, alamat) 
            VALUES ('$nis', '$nama', '$jenis_kelamin', '$jurusan', '$kelas', '$alamat')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil ditambahkan!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Hapus data siswa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hapus"])) {
    $nis = $_POST["nis_hapus"];

    $sql = "DELETE FROM siswa WHERE nis = '$nis'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil dihapus!');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil data siswa
$result = $conn->query("SELECT * FROM siswa");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>TABEL SISWA</h1>
        <form method="POST">
            <input type="hidden" name="tambah" value="1">
            <input type="text" name="nis" placeholder="NIS" required>
            <input type="text" name="nama" placeholder="Nama" required>
            <select name="jenis_kelamin" required>
                <option value="">Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            <input type="text" name="jurusan" placeholder="Jurusan" required>
            <input type="text" name="kelas" placeholder="Kelas" required>
            <textarea name="alamat" placeholder="Alamat" required></textarea>
            <button type="submit">Tambah</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row["nis"] ?></td>
                            <td><?= $row["nama"] ?></td>
                            <td><?= $row["jenis_kelamin"] ?></td>
                            <td><?= $row["jurusan"] ?></td>
                            <td><?= $row["kelas"] ?></td>
                            <td><?= $row["alamat"] ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="hapus" value="1">
                                    <input type="hidden" name="nis_hapus" value="<?= $row['nis'] ?>">
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Tidak ada data siswa.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
