<?php
// Menyertakan file konfigurasi
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Menyiapkan query untuk menambahkan data ke tabel schedule
        $stmt = $conn->prepare('INSERT INTO schedule (subject, teacher, class, time, day) VALUES (?, ?, ?, ?, ?)');
        $stmt->bindParam(1, $_POST['subject']);
        $stmt->bindParam(2, $_POST['teacher']);
        $stmt->bindParam(3, $_POST['class']);
        $stmt->bindParam(4, $_POST['time']);
        $stmt->bindParam(5, $_POST['day']);
        $stmt->execute();

        // Redirect ke halaman utama setelah berhasil menyimpan
        header('Location: jadwal.php');
        exit;
    } catch (PDOException $e) {
        echo "Gagal menyimpan data: " . $e->getMessage();
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/edit.css">
    <title>Tambah Jadwal</title>
</head>
<body>
    <h1>Tambah Jadwal</h1>
    <form method="POST">
        <!-- Dropdown Mata Pelajaran -->
        <label for="subject">Mata Pelajaran:</label>
        <select name="subject" id="subject" required>
            <option value="" disabled selected>Pilih Mata Pelajaran</option>
            <option value="Matematika">Matematika</option>
            <option value="Bahasa Indonesia">Bahasa Indonesia</option>
            <option value="Bahasa Inggris">Bahasa Inggris</option>
            <option value="IPA">IPA</option>
            <option value="IPS">IPS</option>
        </select>

        <!-- Dropdown Kelas -->
        <label for="class">Kelas:</label>
        <select name="class" id="class" required>
            <option value="" disabled selected>Pilih Kelas</option>
            <?php
            // Contoh kelas mulai dari 1A hingga 6C
            for ($grade = 1; $grade <= 6; $grade++) {
                foreach (['A', 'B', 'C'] as $section) {
                    echo "<option value='{$grade}{$section}'>{$grade}{$section}</option>";
                }
            }
            ?>
        </select>

        <!-- Dropdown Hari -->
        <label for="day">Hari:</label>
        <select name="day" id="day" required>
            <option value="" disabled selected>Pilih Hari</option>
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
            <option value="Sabtu">Sabtu</option>
        </select>

        <!-- Dropdown Waktu -->
        <label for="time">Waktu:</label>
        <select name="time" id="time" required>
            <option value="" disabled selected>Pilih Waktu</option>
            <option value="07:00-08:00">07:00-08:00</option>
            <option value="08:00-09:00">08:00-09:00</option>
            <option value="09:00-10:00">09:00-10:00</option>
            <option value="10:00-11:00">10:00-11:00</option>
            <option value="11:00-12:00">11:00-12:00</option>
        </select>

        <!-- Dropdown Guru -->
        <label for="teacher">Guru:</label>
        <select name="teacher" id="teacher" required>
            <option value="" disabled selected>Pilih Guru</option>
            <?php
            // Contoh data guru, bisa diambil dari database
            $teachers = ['Budi', 'Ani', 'Siti', 'Citra', 'Rina'];
            foreach ($teachers as $teacher) {
                echo "<option value='{$teacher}'>{$teacher}</option>";
            }
            ?>
        </select>

        <!-- Tombol Submit -->
        <button type="submit">Simpan</button>
    </form>
</body>
</html>

