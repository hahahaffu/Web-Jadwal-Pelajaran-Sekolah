<?php
// Menyertakan file konfigurasi
include 'config.php';

if (isset($_GET['id'])) {
    try {
        // Menyiapkan query untuk menghapus data berdasarkan ID
        $stmt = $conn->prepare('DELETE FROM schedule WHERE id = ?');
        $stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();

        // Redirect ke halaman utama setelah berhasil menghapus
        header('Location: jadwal.php');
        exit;
    } catch (PDOException $e) {
        echo "Gagal menghapus data: " . $e->getMessage();
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>
