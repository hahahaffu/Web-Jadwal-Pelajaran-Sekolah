<?php
// Menyertakan file konfigurasi
include 'config.php';

// Cek apakah data dikirim via POST (update data)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Ambil data dari form
        $id = $_POST['id'];
        $subject = $_POST['subject'];
        $teacher = $_POST['teacher'];
        $class = $_POST['class'];
        $time = $_POST['time'];
        $day = $_POST['day'];

        // Query untuk update data
        $stmt = $conn->prepare("UPDATE schedule SET 
                                    subject = ?, 
                                    teacher = ?, 
                                    class = ?, 
                                    time = ?, 
                                    day = ? 
                                WHERE id = ?");
        $stmt->bindParam(1, $subject);
        $stmt->bindParam(2, $teacher);
        $stmt->bindParam(3, $class);
        $stmt->bindParam(4, $time);
        $stmt->bindParam(5, $day);
        $stmt->bindParam(6, $id, PDO::PARAM_INT);

        $stmt->execute();

        // Redirect dengan pesan sukses
        header("Location: jadwal.php?message=success_update");
        exit;
    } catch (PDOException $e) {
        // Redirect dengan pesan error
        header("Location: jadwal.php?message=error_update");
        exit;
    }
}

// Cek apakah ada ID yang dikirim melalui GET (menampilkan data untuk diedit)
if (isset($_GET['id'])) {
    try {
        $id = $_GET['id'];

        // Query untuk mendapatkan data berdasarkan ID
        $stmt = $conn->prepare("SELECT * FROM schedule WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $schedule = $stmt->fetch(PDO::FETCH_ASSOC);

        // Jika data tidak ditemukan, redirect ke index
        if (!$schedule) {
            header("Location: jadwal.php?message=not_found");
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    // Redirect jika ID tidak disediakan
    header("Location: jadwal.php?message=invalid_request");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/edit.css">
    <title>Edit Jadwal</title>
</head>
<body>
    <h1>Edit Jadwal</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($schedule['id']) ?>">

        <label for="subject">Mata Pelajaran:</label>
        <select name="subject" id="subject" required>
            <option value="" disabled>Pilih Mata Pelajaran</option>
            <option value="Matematika" <?= $schedule['subject'] === 'Matematika' ? 'selected' : '' ?>>Matematika</option>
            <option value="Bahasa Indonesia" <?= $schedule['subject'] === 'Bahasa Indonesia' ? 'selected' : '' ?>>Bahasa Indonesia</option>
            <option value="IPA" <?= $schedule['subject'] === 'IPA' ? 'selected' : '' ?>>IPA</option>
            <option value="IPS" <?= $schedule['subject'] === 'IPS' ? 'selected' : '' ?>>IPS</option>
            <option value="PKN" <?= $schedule['subject'] === 'PKN' ? 'selected' : '' ?>>PKN</option>
            <option value="Bahasa Inggris" <?= $schedule['subject'] === 'Bahasa Inggris' ? 'selected' : '' ?>>Bahasa Inggris</option>
        </select>

        <label for="day">Hari:</label>
        <select name="day" id="day" required>
            <option value="" disabled>Pilih Hari</option>
            <option value="Senin" <?= $schedule['day'] === 'Senin' ? 'selected' : '' ?>>Senin</option>
            <option value="Selasa" <?= $schedule['day'] === 'Selasa' ? 'selected' : '' ?>>Selasa</option>
            <option value="Rabu" <?= $schedule['day'] === 'Rabu' ? 'selected' : '' ?>>Rabu</option>
            <option value="Kamis" <?= $schedule['day'] === 'Kamis' ? 'selected' : '' ?>>Kamis</option>
            <option value="Jumat" <?= $schedule['day'] === 'Jumat' ? 'selected' : '' ?>>Jumat</option>
            <option value="Sabtu" <?= $schedule['day'] === 'Sabtu' ? 'selected' : '' ?>>Sabtu</option>
        </select>

        <label for="teacher">Guru:</label>
        <select name="teacher" id="teacher" required>
            <option value="" disabled>Pilih Guru</option>
            <option value="Budi" <?= $schedule['teacher'] === 'Budi' ? 'selected' : '' ?>>Budi</option>
            <option value="Ani" <?= $schedule['teacher'] === 'Ani' ? 'selected' : '' ?>>Ani</option>
            <option value="Citra" <?= $schedule['teacher'] === 'Citra' ? 'selected' : '' ?>>Citra</option>
            <option value="Siti" <?= $schedule['teacher'] === 'Siti' ? 'selected' : '' ?>>Siti</option>
            <option value="Rina" <?= $schedule['teacher'] === 'Rina' ? 'selected' : '' ?>>Rina</option>
        </select>

        <label for="class">Kelas:</label>
        <select name="class" id="class" required>
            <option value="" disabled>Pilih Kelas</option>
            <option value="1A" <?= $schedule['class'] === '1A' ? 'selected' : '' ?>>1A</option>
            <option value="1B" <?= $schedule['class'] === '1B' ? 'selected' : '' ?>>1B</option>
            <option value="1C" <?= $schedule['class'] === '1C' ? 'selected' : '' ?>>1C</option>
            <option value="2A" <?= $schedule['class'] === '2A' ? 'selected' : '' ?>>2A</option>
            <option value="2B" <?= $schedule['class'] === '2B' ? 'selected' : '' ?>>2B</option>
            <option value="2C" <?= $schedule['class'] === '2C' ? 'selected' : '' ?>>2C</option>
            <option value="3A" <?= $schedule['class'] === '3A' ? 'selected' : '' ?>>3A</option>
            <option value="3B" <?= $schedule['class'] === '3B' ? 'selected' : '' ?>>3B</option>
            <option value="3C" <?= $schedule['class'] === '3C' ? 'selected' : '' ?>>3C</option>
            <option value="4A" <?= $schedule['class'] === '4A' ? 'selected' : '' ?>>4A</option>
            <option value="4B" <?= $schedule['class'] === '4B' ? 'selected' : '' ?>>4B</option>
            <option value="4C" <?= $schedule['class'] === '4C' ? 'selected' : '' ?>>4C</option>
            <option value="5A" <?= $schedule['class'] === '5A' ? 'selected' : '' ?>>5A</option>
            <option value="5B" <?= $schedule['class'] === '5B' ? 'selected' : '' ?>>5B</option>
            <option value="5C" <?= $schedule['class'] === '5C' ? 'selected' : '' ?>>5C</option>
            <option value="6A" <?= $schedule['class'] === '6A' ? 'selected' : '' ?>>6A</option>
            <option value="6B" <?= $schedule['class'] === '6B' ? 'selected' : '' ?>>6B</option>
            <option value="6C" <?= $schedule['class'] === '6C' ? 'selected' : '' ?>>6C</option>
        </select>


        <label for="time">Waktu:</label>
        <select name="time" id="time" required>
            <option value="" disabled>Pilih Waktu</option>
            <option value="07:00-08:00" <?= $schedule['time'] === '07:00-08:00' ? 'selected' : '' ?>>07:00-08:00</option>
            <option value="08:00-09:00" <?= $schedule['time'] === '08:00-09:00' ? 'selected' : '' ?>>08:00-09:00</option>
            <option value="09:00-10:00" <?= $schedule['time'] === '09:00-10:00' ? 'selected' : '' ?>>09:00-10:00</option>
            <option value="10:00-11:00" <?= $schedule['time'] === '10:00-11:00' ? 'selected' : '' ?>>10:00-11:00</option>
            <option value="11:00-12:00" <?= $schedule['time'] === '11:00-12:00' ? 'selected' : '' ?>>11:00-12:00</option>
        </select>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>

