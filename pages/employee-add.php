<?php
include "../template/header.php";
?>


<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
        <img src="../dist/img/AdminLTELogo.png" alt="Swalayan Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Swalayan</span>
      </a>

      <?php
      include "../template/sidebar.php";
      ?>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Employee</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="../pages/employee.php">Employee</a></li>
                <li class="breadcrumb-item active"><a href="#">AddEmployee</a></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-md-12">

              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Tambah Data Employee</h3>
                </div>
                <?php
                require '../vendor/autoload.php';

                use GuzzleHttp\Client;

                $baseUri = 'http://103.183.74.79:8090'; // Ganti dengan base URL API Anda
                $endpoint = '/api/employee'; // Ganti dengan endpoint untuk menambahkan data employee

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  $newEmployeeData = [
                    'name' => $_POST['name'],
                    'username' => $_POST['username'],
                    'password' => $_POST['password'],
                    'address' => $_POST['address'],
                    'phone_number' => $_POST['phone_number'],
                    'dept_name' => $_POST['dept_name'],
                    'position' => $_POST['position'],
                  ];

                  $client = new Client(['base_uri' => $baseUri]);

                  try {
                    $response = $client->post($endpoint, [
                      'headers' => [
                        'Authorization' => 'Bearer ' . $_SESSION['accessToken'], // Ganti dengan token akses Anda
                        'Content-Type' => 'application/json',
                      ],
                      'json' => $newEmployeeData,
                    ]);

                    $statusCode = $response->getStatusCode();
                    $responseData = json_decode($response->getBody(), true);

                    // Proses response jika perlu
                    if ($statusCode === 200) {

                      echo '<script>
                        window.location.href = "employee-all.php";
                        </script>';
                    } else {
                      echo 'Failed to add employee: ' . $responseData['message'];
                    }
                  } catch (\GuzzleHttp\Exception\RequestException $e) {
                    echo 'Error: ' . $e->getMessage();
                  }
                }
                ?>

                <form action="" method="post">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="name">Employee name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama ">
                    </div>
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username">
                    </div>
                    <div class="form-group">
                      <label for="password">password</label>
                      <input type="text" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                    </div>
                    <div class="form-group">
                      <label for="address">address</label>
                      <input type="text" class="form-control" id="address" name="address" placeholder="Masukkan Address">
                    </div>
                    <div class="form-group">
                      <label for="phone_number">Phone Number</label>
                      <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan No telp">
                    </div>
                    <div class="form-group">
                      <label for="dept_name">Department name</label>
                      <input type="text" class="form-control" id="dept_name" name="dept_name" placeholder="Masukkan Departmen name">
                    </div>
                    <div class="form-group">
                      <label for="position">Position</label>
                      <input type="text" class="form-control" id="position" name="position" placeholder="Masukkan Position">
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right">Tambah Data</button>
                  </div>
              </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    <!-- /.row (main row) -->
  </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <?php
  include '../template/footer.php';
  ?>


</body>

</html>