<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Page</title>
  <link href='css/login.css' rel='stylesheet'>
  <link rel="preconnect" href="https://fonts.googleapis.com">
        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Rubik&display=swap" rel="stylesheet"> 

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
        <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="container-right">
    </div>
    <div class="container-left">
      <div>  
      <div class="logo">
        </div>
        <img src="" alt="" class="logo">
        <h1 style= "color: #00c6a9; font-size: 50px">SMA 1001</h1>
        <p style= "color: #00c6a9">BANDA ACEH</p>
        <form method="post" action="autentication.php" >
          <div class="style-input">
            <label for="username">
              <input type="text" name="username" autocomplete="new-email">
              <p style="margin-bottom: 5px">Nama Pengguna</p>
              <span></span>
            </label>
          </div>
          <div class="style-input">
            <label for="password">
              <p style="margin-bottom: 5px">Password</p>
              <input type="password" name="password" autocomplete="new-password">
              <span></span>
            </label>
          </div>
          <div class="after-input">
            <div class="rememberme-style">
              <input type="checkbox" name="rememberme" value="">
              <span>Ingatkan saya</span>
            </div>
            <div class="forget-style">
              <a href="#">Lupa password?</a>
            </div>
          </div>
          <button type="submit" class="submit-button">Log In</button>
        </form>
      </div>
      <p class="sign-up">Tidak punya akun? <a href="">Daftar</a></p>
    </div>
  </div>
  <script defer type="text/javascript" src="script.js"></script>
</body>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.style-input label input');
  
    inputs.forEach(input => {
      input.addEventListener('input', () => {
        const label = input.parentNode;
        if (input.value) {
          label.classList.add('has-value');
        } else {
          label.classList.remove('has-value');
        }
      });
    });
  });
</script>

</html>
