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

      <?php
      include "../template/sidebar.php";
      ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Product</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="../pages/product.php">Product</a></li>
                <li class="breadcrumb-item active"><a href="#">Add Product</a></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
     
      <!-- Main row -->
      <div class="content" >
        <div class="container-fluid">
          <div class="row">

            <div class="col-md-12">

              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Tambah Data Product</h3>
                </div>
                <?php
                require '../vendor/autoload.php';

                use GuzzleHttp\Client;

                $baseUri = 'http://103.183.74.79:8091'; // Ganti dengan base URL API Anda
                $endpoint = '/api/product'; // Ganti dengan endpoint untuk menambahkan data employee

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  $newProductData = [
                    'name' => $_POST['name'],
                    'price' => $_POST['price'],
                    'stock' => $_POST['stock'],
                    'product_desc' => $_POST['product_desc'],
                  ];

                  $client = new Client(['base_uri' => $baseUri]);

                  try {
                    $response = $client->post($endpoint, [
                      'headers' => [
                        'Authorization' => 'Bearer ' . $_SESSION['accessToken'], // Ganti dengan token akses Anda
                        'Content-Type' => 'application/json',
                      ],
                      'json' => $newProductData,
                    ]);

                    $statusCode = $response->getStatusCode();
                    $responseData = json_decode($response->getBody(), true);

                    // Proses response jika perlu
                    if ($statusCode === 200) {

                      // Tambahan aksi jika perlu
                    } else {
                      echo 'Failed to add employee: ' . $responseData['message'];
                    }
                  } catch (\GuzzleHttp\Exception\RequestException $e) {
                    echo 'Error: ' . $e->getMessage();
                  }
                }
                ?>



                <!-- Isi ne nde kene  -->
                <form action="" method="post">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="name">Product name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Produk ">
                    </div>
                    <div class="form-group">
                      <label for="price">Price</label>
                      <input type="text" class="form-control" id="price" name="price" placeholder="Masukkan price">
                    </div>
                    <div class="form-group">
                      <label for="stock">Stock</label>
                      <input type="text" class="form-control" id="stock" name="stock" placeholder="Masukkan stock">
                    </div>
                    <div class="form-group">
                      <label for="product_desc">Product Description</label>
                      <input type="text" class="form-control" id="product_desc" name="product_desc" placeholder="Masukkan product_desc">
                    </div>

                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right">Tambah Data</button>
                  </div>
              </div>
              </form>

              <!-- </section> -->
              <!-- right col -->
            </div>
            <!-- /.row (main row) -->
          </div><!-- /.container-fluid -->
          </section>
          <!-- /.content -->
        </div>

        <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->
      <?php
      include '../template/footer.php';
      ?>
</body>

</html>