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
              <h1 class="m-0">Incoming Product</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">All Incoming Product Transaction</li>
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
            <div class="col-lg-5 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>Add</h3>

                  <p>Stock</p>
                </div>
                <div class="icon">
                  <i class="fas fa-cart-plus"></i>
                </div>
                <a href="../pages/incoming_product-add.php" class="small-box-footer">Tambah Stok <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-5 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>All</h3>

                  <p>Incoming Product Transaction</p>
                </div>
                <div class="icon">
                  <i class="fas fa-database"></i>
                </div>
                <a href="../pages/incoming_product-all.php" class="small-box-footer">Lihat Semua Data Transaksi <i class="fas fa-arrow-circle-right"></i></a>
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

            $baseUri = 'http://103.176.78.115:8093';
            $baseUriTransaction = 'http://103.176.78.115:8093'; // Ganti dengan base URL API Anda
            if (isset($_GET["fnip"])) {
              $endpoint = '/api/incoming-products/nip/' . $_GET["fnip"];
            } else if (isset($_GET["inputYear"]) || isset($_GET["inputMonth"]) || isset($_GET["inputDate"])) {
              $year = isset($_GET["inputYear"]) && trim($_GET["inputYear"]) != "" ? $_GET["inputYear"] : "";
              $month = isset($_GET["inputMonth"]) && trim($_GET["inputMonth"]) != "" ? "/" . $_GET["inputMonth"] : "";
              $date = isset($_GET["inputDate"]) && trim($_GET["inputDate"]) != "" ? "/" . $_GET["inputDate"] : "";
              $endpoint = '/api/incoming-products/date/' . $year . $month . $date;
            } else if (isset($_GET["fid"])) {
              $endpoint = '/api/incoming-products/' . $_GET["fid"];
            }
            
            else {
              $endpoint = '/api/incoming-products/all';
            }
            $endpointAdd = '/api/incoming-products/add'; // Ganti dengan endpoint untuk mengupdate data employee


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
            <div class="card" style="justify-content: space-between;">
              <div class="card-header">
                <div class="form-row">

                  <div class="form-group col-md-3">
                    <h3 class="card-title" style="margin-right: 10px;">All Incoming Product Transaction</h3>
                  </div>
                  <div class="form-group col-md-8" style="margin-bottom: 0px;">
                    <div id="searchForm">
                      <div class="form-group" style="width: 100%;">
                        <select id="searchOption" class="form-control" name="">
                          <option value="id" id="idOption">Find By Transaction ID</option>
                          <option value="nip" id="nipOption">Find By NIP</option>
                          <option value="date" id="dateOption">Find By Date</option>
                        </select>
                      </div>

                      <!-- Fields for "Find By NIP" option -->
                      <div id="idFields">
                        <div class="form-group" style="width: 100%;">
                          <form action="" method="get">
                          <input type="search" id="fid" name="fid" style="width: 100%;" placeholder="Transaction ID">
                          </form>
                        </div>
                      </div>

                      <div id="nipFields">
                        <div class="form-group" style="width: 100%;">
                          <form action="" method="get">
                          <input type="search" id="fnip" name="fnip" style="width: 100%;" placeholder="NIP">
                          </form>
                        </div>
                      </div>

                      <!-- Fields for "Find Date" option -->
                      <form action="" method="get">
                        <div id="dateFields">
                          <div class="form-group">
                            <select id="inputYear" name="inputYear" class="form-control">
                              <option value="">Year</option>
                              <!-- Add years dynamically, e.g., using JavaScript -->
                            </select>
                          </div>
                          <div class="form-group">
                            <select id="inputMonth" name="inputMonth" class="form-control">
                              <option value="">Month</option>
                              <!-- Add months dynamically, e.g., using JavaScript -->
                            </select>
                          </div>
                          <div class="form-group">
                            <select id="inputDate" name="inputDate" class="form-control">
                              <option value="">Date</option>
                              <!-- Add dates dynamically, e.g., using JavaScript -->
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <button id="searchButton" type="submit" class="small-box bg-info" style="margin-bottom: 0px; border: none; height:100%; width: 100%">
                            <i class="fa fa-search"></i>
                          </button>
                        </div>
                      </form>
                    </div>

                  </div>
                </div>
                <div class="card-body p-0">
                  <table id="view-all" class="table table-striped table-bordered" style="text-align: center;">
                    <thead>
                      <tr>
                        <th>ID</th> <!-- Add a new header cell for the quantity -->
                        <th>NIP</th>
                        <th>Date</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Time</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="table-body">
                      <?php
                      include 'requestApi/getIncomingProduct.php';
                      ?>
                      </td>
                    </tbody>
                  </table>
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

  <!-- Modal -->
  <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailsModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modalContent">
          <!-- The content will be populated dynamically here -->
        </div>
      </div>
    </div>
  </div>

  <!-- <div class="modal fade" id="confirmationDeleteModalLabel" tabindex="-1" role="dialog" aria-labelledby="confirmationDeleteModalLabel"
                aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure to delete this transaction?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary bg-danger" onclick="deleteItem()"><a href="?delete=<?php echo $incoming['id']; ?>">Delete</a></button>
        </div>
      </div>
    </div>
  </div> -->

  <script>
    // Get the searchOption element
    const idFields = document.getElementById('idFields');
    const nipFields = document.getElementById('nipFields');
    const dateFields = document.getElementById('dateFields');
    const searchButton = document.getElementById('searchButton');

    // Function to toggle the display of fields based on the selected option
    function toggleFields() {
      const selectedValue = searchOption.value;
      if (selectedValue === 'id') {
        idFields.style.display = 'block';
        nipFields.style.display = 'none';
        dateFields.style.display = 'none';
        searchButton.style.display = 'none';
      } else if (selectedValue === 'nip') {
        idFields.style.display = 'none';
        nipFields.style.display = 'block';
        dateFields.style.display = 'none';
        searchButton.style.display = 'none';
      }else if (selectedValue === 'date') {
        idFields.style.display = 'none';
        nipFields.style.display = 'none';
        dateFields.style.display = 'block';
        searchButton.style.display = 'block';
      }
    }

    // Add event listener to the searchOption dropdown to trigger toggleFields on change
    searchOption.addEventListener('change', toggleFields);

    // Call toggleFields initially to set the initial display based on the default selected option
    toggleFields();

    function showDetails(button) {
      let text = button.getAttribute("data").replaceAll("'", "\"")
      console.log(text)
      let detail = JSON.parse(text)
      const row = button.parentNode.parentNode; // Get the parent row of the clicked button

      // Extract data from the row
      const id = row.cells[0].innerText;
      const column1 = row.cells[1].innerText;
      const column2 = row.cells[2].innerText;
      const column3 = row.cells[3].innerText;
      const column4 = row.cells[4].innerText;
      const column5 = row.cells[5].innerText;
      button.getAttribute("data")
      // Create the content to be shown in the modal
      const detailsModalLabel = `
    Transaction ID: ${id}
  `;
      let detailProduct = ''
      for (let i = 0; i < detail.length; i++) {
        detailProduct += `
    <tr>
    
      <td>${detail[i].incoming_id}</td>
      <td>${detail[i].quantity}</td>
      <td>${detail[i].id_product}</td> 
      <td>${detail[i].name}</td>
    
    </tr>
    `
      }
      const modalContent = `
      <div style="margin-bottom:0px">
      NIP: ${column1}<br>
      Date: ${column2} - ${column3} - ${column4}<br>
      Time: ${column5}<br>
      Product Details:
      <table class="table table-striped table-bordered" style="text-align: center;">
        <tr>
          <th>ID Incoming</th>
          <th>Quantity</th>
          <th>ID Product</th>
          <th>Name</th>
        </tr>
      ${detailProduct}
      </table>
    </div>
  `;

      // Update the modal content with the generated content
      document.getElementById("modalContent").innerHTML = modalContent;
      document.getElementById("detailsModalLabel").innerHTML = detailsModalLabel;
    }
  </script>

  <?php
  include '../template/footer.php';
  ?>
</body>

</html>