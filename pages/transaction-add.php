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
              <h1 class="m-0">Transaction</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Transaction</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row" style="justify-content: space-evenly;">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>Add</h3>

                  <p>Transaction</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="../pages/transaction-add.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>All</h3>

                  <p>Transaction</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="../pages/transaction-all.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>Manage</h3>

                  <p>Transaction</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="../pages/transaction-manage.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
          <!-- Main row -->
          <div class="content" style="min-height: 1000px;">
            <!-- Left col -->
            <!-- <section class="content"> -->


            <?php
            require '../vendor/autoload.php';

            use GuzzleHttp\Client;

            $baseUri = 'http://localhost:8091';
            $baseUriTransaction = 'http://localhost:8092'; // Ganti dengan base URL API Anda
            if (isset($_GET["fproduct"])) {
              $endpoint = '/api/product/name/' . $_GET["fproduct"];
            } else{
              $endpoint = '/api/product';
            }
            $endpointAdd = '/api/transaction/create'; // Ganti dengan endpoint untuk mengupdate data employee


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
            } catch (\GuzzleHttp\Exception\RequestException $e) {
              echo 'Error: ' . $e->getMessage();
            }


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $transactionItems = [];
              for ($i = 0; $i < count($_POST["productCheckbox"]); $i++) {
                $transactionItems[] = [
                  'id_product' => $_POST["productCheckbox"][$i],
                  'quantity' => intval($_POST["stock"][$i])
                ];
              }
              $newIncomingData = [
                'nip' => $_SESSION['nip'],
                "transactionItems" => $transactionItems,
              ];
              $client = new Client(['base_uri' => $baseUriTransaction]);

              try {
                $response = $client->post($endpointAdd, [
                  'headers' => [
                    'Authorization' => 'Bearer ' . $_SESSION['accessToken'], // Ganti dengan token akses Anda
                    'Content-Type' => 'application/json',
                  ],
                  'json' => $newIncomingData,
                ]);

                $statusCode = $response->getStatusCode();
                $responseData = json_decode($response->getBody(), true);

                // Proses response jika perlu
                if ($statusCode === 200) {

                  // Tambahan aksi jika perlu
                } else {
                  echo 'Failed to add Incoming Product: ' . $responseData['message'];
                }
              } catch (\GuzzleHttp\Exception\RequestException $e) {
                echo 'Error: ' . $e->getMessage();
              }
            }
            ?>


            <!-- Isi ne nde kene  -->
            <div class="card">
              <div class="card-header">
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <h3 class="card-title" style="margin-right: 10px;">Add Stock</h3>
                  </div>
                  <div class="form-group col-md-4">
                    <form action="" method="get">
                      <input type="search" id="fproduct" name="fproduct" style="width: 100%; height: 100%;" placeholder="Product Name">
                    </form>
                  </div>
                </div>
              </div>
              <form class="card-body p-0" method="post">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th></th> <!-- Add an empty header cell for the checkbox -->
                      <th>Quantity</th> <!-- Add a new header cell for the quantity -->
                      <th>ID Product</th>
                      <th>Product Name</th>
                      <th>Price</th>
                      <th>Product Desc</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($productData as $product) {
                      $id = $product['id'];
                      $name = $product['name'];
                      $price = $product['price'];
                      $stock = $product['stock'];
                      $product_desc = $product['product_desc'];
                    ?>
                      <tr>
                        <td><input type="checkbox" value="<?= $id ?>" name="productCheckbox[]" /></td> <!-- Add a checkbox for each row -->
                        <td><input type="number" name="stock[]" min="0" value="<?= $stock ?>" /></td>
                        <td><?= $id ?></td>
                        <td><?= $name ?></td>
                        <td><?= $price ?></td>
                        <td><?= $product_desc ?></td>
                      </tr>
                    <?php } ?>

                  </tbody>
                </table>

                <div class="fixed-block">

                  <!-- Number of checked items -->
                  <span id="checkedItems">0 items checked</span>

                  <!-- Total price -->
                  <span id="totalPrice">Total Price: 0</span>

                  <!-- Add button -->
                  <button class="small-box bg-info" style="margin-bottom: 0px; width: 8%; border: none;" type="submit">Add</button>
                </div>
            </div>

            <!-- </section> -->
            <!-- right col -->
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