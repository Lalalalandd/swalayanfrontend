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
              <h1 class="m-0">Edit Employee</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="../pages/employee.php">Employee</a></li>
                <li class="breadcrumb-item active">Manage Employee</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-md-12">

              <div class="card card-warning">
                <div class="card-header">
                  <h3 class="card-title">Edit Data Employee</h3>
                </div>
                <?php
                require '../vendor/autoload.php';

                use GuzzleHttp\Client;

                $baseUri = 'http://localhost:8090'; // Ganti dengan base URL API Anda
                $employeeId = $_GET['edit']; // Ganti dengan ID employee yang akan diupdate
                $endpoint = '/api/employee/' . $employeeId; // Ganti dengan endpoint untuk mengupdate data employee

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  $updatedEmployeeData = [
                    'nip' => intval($_POST['nip']),
                    'name' => $_POST['name'],
                    'username' => trim($_POST['username']) != "" ? $_POST['username'] : null,
                    'password' => trim($_POST['password']) != "" ? $_POST['password'] : null,
                    'address' => $_POST['address'],
                    'number_phone' => $_POST['number_phone'],
                    'dept_name' => $_POST['dept_name'],
                    'position' => $_POST['position'],
                  ];

                  $client = new Client(['base_uri' => $baseUri]);

                  try {
                    $response = $client->put($endpoint, [
                      'headers' => [
                        'Authorization' => 'Bearer ' . $_SESSION['accessToken'], // Ganti dengan token akses Anda
                        'Content-Type' => 'application/json',
                      ],
                      'json' => $updatedEmployeeData,
                    ]);

                    $statusCode = $response->getStatusCode();
                    $responseData = json_decode($response->getBody(), true);

                    $endpointRoleUpdate = "/api/roles/" . $_POST['nip'] . "/update";
                    $updatedRole = [
                      "id" => $_POST["roles"]
                    ];
                    $response = $client->put($endpointRoleUpdate, [
                      'headers' => [
                        'Authorization' => 'Bearer ' . $_SESSION['accessToken'], // Ganti dengan token akses Anda
                        'Content-Type' => 'application/json',
                      ],
                      'json' => $updatedRole,
                    ]);

                    $statusCodeUpdateRole = $response->getStatusCode();
                    // $responseDataUpdateRole = json_decode($response->getBody(), true);

                    // Proses response jika perlu
                    if ($statusCode === 200 && $statusCodeUpdateRole === 200) {
                      echo `<script>
                           
                            $(document).Toasts('create', {
                              class: 'bg-success',
                              title: 'Sukses Edit',
                              subtitle: 'Subtitle',
                              body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
                            })
                           
                           </script>`;
                      // Tambahan aksi jika perlu
                    } else {
                      echo 'Failed to update employee: ' . $responseData['message'];
                    }
                  } catch (\GuzzleHttp\Exception\RequestException $e) {
                    echo 'Error: ' . $e->getMessage();
                  }
                }

                // Buat permintaan GET untuk mendapatkan data employee berdasarkan ID
                $client = new Client(['base_uri' => $baseUri]);

                try {
                  $response = $client->get($endpoint, [
                    'headers' => [
                      'Authorization' => 'Bearer ' . $_SESSION['accessToken'], // Ganti dengan token akses Anda
                      'Content-Type' => 'application/json',
                    ],
                  ]);

                  $statusCode = $response->getStatusCode();
                  $employeeData = json_decode($response->getBody(), true);

                  // Proses data yang diterima dari API untuk mengisi nilai-nilai dalam form HTML
                  $nip = $employeeData['nip'];
                  $name = $employeeData['name'];
                  $username = $employeeData['username'];
                  $password = $employeeData['password'];
                  $address = $employeeData['address'];
                  $number_phone = $employeeData['number_phone'];
                  $dept_name = $employeeData['dept_name'];
                  $position = $employeeData['position'];
                  $role = count($employeeData['roles']) > 0 ? $employeeData['roles'][0]["id"] : null;
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                  echo 'Error: ' . $e->getMessage();
                }
                ?>


                <form action="" method="post">
                  <input type="hidden" name="nip" value="<?= $nip ?>">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="name">Employee name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama" value="<?= $name ?>">
                    </div>
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" value="">
                      <label for="notesername" class="float-right">* Jika tidak mau dirubah kosongkan saja</label>
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="text" class="form-control" id="password" name="password" placeholder="Masukkan Password" value="">
                      <label for="notesername" class="float-right">* Jika tidak mau dirubah kosongkan saja</label>
                    </div>
                    <div class="form-group">
                      <label for="address">address</label>
                      <input type="text" class="form-control" id="address" name="address" placeholder="Masukkan Address" value="<?= $address ?>">
                    </div>
                    <div class="form-group">
                      <label for="number_phone">Phone Number</label>
                      <input type="text" class="form-control" id="number_phone" name="number_phone" placeholder="Masukkan No telp" value="<?= $number_phone ?>">
                    </div>
                    <div class="form-group">
                      <label for="dept_name">Department name</label>
                      <input type="text" class="form-control" id="dept_name" name="dept_name" placeholder="Masukkan Departmen name" value="<?= $dept_name ?>">
                    </div>
                    <div class="form-group">
                      <label for="position">Position</label>
                      <input type="text" class="form-control" id="position" name="position" placeholder="Masukkan Position" value="<?= $position ?>">
                    </div>
                    <div class="form-group">
                      <label for="roles">roles</label>
                      <select name="roles" id="roles" class="form-control">
                        <option <?=$role == 1 ? 'selected' : ''?> value="1">Admin</option>
                        <option <?=$role == 2 ? 'selected' : ''?> value="2">Cashier</option>
                      </select>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-warning float-right">Edit Data</button>
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