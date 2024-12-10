<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Menggunakan prepared statement untuk mencegah SQL Injection
        $stmt = $conn->prepare("SELECT * FROM login WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['password'] === $password) {
            // Login berhasil, simpan data user dalam session
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Menyimpan role (admin/siswa)

            // Arahkan berdasarkan role
            if ($user['role'] === 'admin') {
                header("Location: dashboard.php");  // Halaman untuk admin
            } elseif ($user['role'] === 'siswa') {
                header("Location: dashboard.php");  // Halaman untuk siswa
            } else {
                echo "<script>alert('Role tidak valid!'); window.location.href = 'index.php';</script>";
            }
            exit();
        } else {
            // Login gagal
            echo "<script>alert('Username atau password salah!'); window.location.href = 'index.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Gagal: " . $e->getMessage();
    }
}
?>
