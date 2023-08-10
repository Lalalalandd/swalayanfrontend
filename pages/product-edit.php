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
            <h1 class="m-0">Edit Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="../pages/employee.php">Product</a></li>
              <li class="breadcrumb-item active">Manage product</li>
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
                  <h3 class="card-title">Edit Data product</h3>
                </div>
                <?php
               require '../vendor/autoload.php';
               
               use GuzzleHttp\Client;
               
               $baseUri = 'http://103.183.74.79:8091'; // Ganti dengan base URL API Anda
               $productId = $_GET['edit']; // Ganti dengan ID employee yang akan diupdate
               $endpoint = '/api/product/' . $productId; // Ganti dengan endpoint untuk mengupdate data employee
               
               if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                   $updatedProductData = [
                       'id' => intval($_POST['id']),
                       'name' => $_POST['name'],
                       'price' => $_POST['price'],
                       'stock' => $_POST['stock'],
                       'product_desc' => $_POST['product_desc'],
                   ];
               
                   $client = new Client(['base_uri' => $baseUri]);
               
                   try {
                       $response = $client->put($endpoint, [
                           'headers' => [
                               'Authorization' => 'Bearer '.$_SESSION['accessToken'], // Ganti dengan token akses Anda
                               'Content-Type' => 'application/json',
                           ],
                           'json' => $updatedProductData,
                       ]);
               
                       $statusCode = $response->getStatusCode();
                       $responseData = json_decode($response->getBody(), true);
               
                       // Proses response jika perlu
                       if ($statusCode === 200) {
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
                   $productData = json_decode($response->getBody(), true);
               
                   // Proses data yang diterima dari API untuk mengisi nilai-nilai dalam form HTML
                   $id = $productData['id'];
                   $name = $productData['name'];
                   $price = $productData['price'];
                   $stock = $productData['stock'];
                   $product_desc = $productData['product_desc'];
               
               } catch (\GuzzleHttp\Exception\RequestException $e) {
                   echo 'Error: ' . $e->getMessage();
               }
               ?>


                <form action="" method="post">
                  <input type="hidden" name="id" value="<?=$id?>">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="name">Product name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama" value="<?= $name ?>">
                    </div>
                    <div class="form-group">
                      <label for="price">price</label>
                      <input type="text" class="form-control" id="price" name="price" placeholder="Masukkan price" value="<?= $price ?>">
                    </div>
                    <div class="form-group">
                      <label for="stock">Stock</label>
                      <input type="text" class="form-control" id="stock" name="stock" placeholder="Masukkan No telp" value="<?= $stock ?>">
                    </div>
                    <div class="form-group">
                      <label for="product_desc">Product Desc</label>
                      <input type="text" class="form-control" id="product_desc" name="product_desc" placeholder="Masukkan Departmen name" value="<?= $product_desc ?>">
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
