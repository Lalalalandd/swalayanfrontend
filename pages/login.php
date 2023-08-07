<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <style>
    .card{
      border-radius: 15px;
    }
    .card-body {
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
      border-bottom-left-radius: 15px;
      border-bottom-right-radius: 15px;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../index.html"><b>Swalayan</b>Barokah</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body ">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="username" name="username" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="password" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row" style="width: 40%; margin: 0 auto;">
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>

      </form>
      <!-- /.social-auth-links -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<?php
    // Menggunakan autoloader dari Composer
    require '../vendor/autoload.php';

    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\RequestException;

    // URL dari API Spring Boot
    $api_url = 'http://localhost:8090/auth/login';
    // $client = new Client();

    // $response = $client->get($api_url);
    // echo($response->getBody());

    // Data login dari form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            // Lakukan HTTP POST request ke API dengan data login
            $client = new Client();
            $response=$client->request('POST', $api_url, [
              'json' =>[
              "username" => $username,
              "password" => $password
              ]
            ]);

            // Cek status code respons
            if ($response->getStatusCode() === 200) {
                // Ambil data JSON dari respons
                $data = json_decode($response->getBody(), true);
                // Periksa apakah login berhasil
                if (isset($data['accessToken']) ) {
                    session_start();
                    $_SESSION['accessToken'] = $data['accessToken'];
                    $_SESSION['username'] = $data['username'];
                    $_SESSION['role'] = $data['role'];
                    $_SESSION['nip'] = $data['nip'];
                    
                    // echo $_SESSION['accessToken'];
                    header('Location:employee.php');
                } else {
                    // Jika gagal, tampilkan alert message
                    echo '<script>alert("Login gagal. Pesan: ' . $data['message'] . '");</script>';
                }
            } else {
                // Tampilkan alert message jika error pada request
                echo '<script>alert("Error: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase() . '");</script>';
            }
        } catch (GuzzleHttp\Exception\RequestException $e) {
            // Tampilkan alert message jika error pada request
            echo '<script>alert("Error saat mengakses API: ' . $e->getMessage() . '");</script>';
        }
    }
    ?>
</body>
</html>
