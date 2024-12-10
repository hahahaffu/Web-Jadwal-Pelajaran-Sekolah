<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Menyertakan file konfigurasi
include 'config.php';

try {
    // Query untuk mendapatkan data dari tabel schedule
    $stmt = $conn->prepare("SELECT * FROM schedule");
    $stmt->execute();

    // Mendapatkan hasil
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Query gagal: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>SMA 1001</title>


  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- font awesome style -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" integrity="sha256-mLBIhmBvigTFWPSCtvdu6a76T+3Xyt+K571hupeFLg4=" crossorigin="anonymous" />
  <!-- datepicker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

  <link rel="stylesheet" href="css/table.css">

</head>

<body class="sub_page">

  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="header_top">
        <div class="container">
          <div class="contact_nav">
            <a href="">
              <i class="fa fa-phone" aria-hidden="true"></i>
              <span>
                Call : +01 123455678990
              </span>
            </a>
            <a href="">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <span>
                Email : sma1001bandaaceh@gmail.com
              </span>
            </a>
            <a href="">
              <i class="fa fa-map-marker" aria-hidden="true"></i>
              <span>
                Banda Aceh
              </span>
            </a>
          </div>
        </div>
      </div>
      <div class="header_bottom">
        <div class="container-fluid">
          <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="dashboard.php">
              <img src="images/logo.png" alt="">
            </a>


            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <div class="d-flex mr-auto flex-column flex-lg-row align-items-center">
                <ul class="navbar-nav  ">
                  <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Halaman Utama <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="jadwal.php">Jadwal</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="guru.html">Guru</a>
                  </li>
                </ul>
              </div>
              <div class="quote_btn-container">
                <a href="logout.php">
                  <i class="fa fa-sign-out" aria-hidden="true"></i>
                  <span>
                    Logout
                  </span>
                </a>
                <form class="form-inline">
                  <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </button>
                </form>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </header>
    <!-- end header section -->
  </div>

<style>
  .book_section h5 {
    margin-top: 25px; /* Atur jarak sesuai kebutuhan */
    font-size: 20px;     /* Opsional: Sesuaikan ukuran font untuk header kelas */
    font-weight: bold;   /* Opsional: Tambahkan gaya font bold */
    color: #333;         /* Opsional: Warna teks */
}
</style>

<section class="book_section layout_padding">
  <div class="container">
    <div class="row">
      <div class="col">
        <form>
          <h4>
            JADWAL <span>PELAJARAN</span>
          </h4>
          
          <?php 
          // Ambil role dari session
          $role = $_SESSION['role'];

          if ($role === 'admin'): ?>
            <div class="add-button-container">
              <a href="add-schedule.php" class="btn">Tambah Jadwal</a>
            </div>
          <?php endif; ?>

          <?php 
          // Kelompokkan jadwal berdasarkan kelas
          $grouped_by_class = [];
          if ($result) {
            foreach ($result as $row) {
              $grouped_by_class[$row['class']][] = $row;
            }
          }

          // Urutkan kelas (1A, 1B, 1C, ..., 6C)
          ksort($grouped_by_class); // Mengurutkan kelas secara alfabet (misalnya 1A, 1B, 1C, ...)

          // Hari-hari dalam seminggu (nilai numerik untuk urutan)
          $days_of_week = [
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6,
          ];

          // Iterasi untuk menampilkan jadwal tiap kelas
          foreach ($grouped_by_class as $class => $schedules): ?>
            <h5>Kelas <?= htmlspecialchars($class) ?></h5>
            <div class="table-responsive">
              <table class="styled-table">
                <thead>
                  <tr>
                    <th>Hari</th>
                    <th>Mata Pelajaran</th>
                    <th>Waktu</th>
                    <th>Guru</th>
                    <?php if ($role === 'admin'): ?>
                      <th>Aksi</th>  <!-- Tampilkan kolom aksi hanya untuk admin -->
                    <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  // Urutkan jadwal berdasarkan hari
                  usort($schedules, function ($a, $b) use ($days_of_week) {
                    return $days_of_week[$a['day']] - $days_of_week[$b['day']];
                  });

                  // Kelompokkan jadwal berdasarkan hari
                  $grouped_by_day = [];
                  foreach ($schedules as $row) {
                    $grouped_by_day[$row['day']][] = $row;
                  }

                  // Iterasi untuk menampilkan jadwal berdasarkan hari
                  foreach ($grouped_by_day as $day => $day_schedules): ?>
                    <tr>
                      <td rowspan="<?= count($day_schedules) ?>"><?= htmlspecialchars($day) ?></td>
                      <?php 
                      // Iterasi untuk menampilkan mata pelajaran pada hari yang sama
                      foreach ($day_schedules as $index => $row): ?>
                        <?php if ($index > 0): ?>
                          <tr>
                        <?php endif; ?>
                        <td><?= htmlspecialchars($row['subject']) ?></td>
                        <td><?= htmlspecialchars($row['time']) ?></td>
                        <td><?= htmlspecialchars($row['teacher']) ?></td>
                        <?php if ($role === 'admin'): ?>
                          <td>
                            <a href="edit-schedule.php?id=<?= $row['id'] ?>" class="btn btn-black btn-sm">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus jadwal?')">Hapus</a>
                          </td>
                        <?php endif; ?>
                        <?php if ($index > 0): ?>
                          </tr>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endforeach; ?>
        </form>
      </div>
    </div>
  </div>
</section>



  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayYear"></span> All Rights Reserved By
        <a href="https://html.design/">Free Html Templates</a>
      </p>
    </div>
  </footer>
  <!-- footer section -->

  <!-- jQery -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- bootstrap js -->
  <script src="js/bootstrap.js"></script>
  <!-- nice select -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js" integrity="sha256-Zr3vByTlMGQhvMfgkQ5BtWRSKBGa2QlspKYJnkjZTmo=" crossorigin="anonymous"></script>
  <!-- owl slider -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- datepicker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
  <!-- custom js -->
  <script src="js/custom.js"></script>


</body>

</html>