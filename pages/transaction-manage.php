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
        <div class="row" style="justify-content: space-evenly;" >
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



            <!-- Isi ne nde kene  -->
              <div class="card" style="justify-content: space-between;">
              <div class="card-header">
                    <div class="form-row" >

                      <div class="form-group col-md-3">
                        <h3 class="card-title" style="margin-right: 10px;">Manage Transaction</h3>
                      </div>
                      <div class="form-group col-md-8" style="margin-bottom: 0px;">
                        <form id="searchForm">
                          <div class="form-group" style="width: 100%;">
                            <select id="searchOption" class="form-control">
                              <option value="nip" id="nipOption">Find By NIP</option>
                              <option value="date" id="dateOption">Find By Date</option>
                            </select>
                          </div>

                          <!-- Fields for "Find By NIP" option -->
                          <div id="nipFields">
                            <div class="form-group" style="width: 100%;">
                              <input type="text" id="fnip" name="fnip" placeholder="NIP">
                            </div>
                          </div>

                          <!-- Fields for "Find Date" option -->
                          <div id="dateFields">
                            <div class="form-group">
                              <select id="inputYear" class="form-control">
                                <option value="">Year</option>
                                <!-- Add years dynamically, e.g., using JavaScript -->
                              </select>
                            </div>
                            <div class="form-group">
                              <select id="inputMonth" class="form-control">
                                <option value="">Month</option>
                                <!-- Add months dynamically, e.g., using JavaScript -->
                              </select>
                            </div>
                            <div class="form-group">
                              <select id="inputDate" class="form-control">
                                <option value="">Date</option>
                                <!-- Add dates dynamically, e.g., using JavaScript -->
                              </select>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="form-group col-md-1">
                        <button id="searchButton" type="submit"
                        class="small-box bg-info" style="margin-bottom: 0px; border: none; height:100%; width: 100%">
                          <i class="fa fa-search"></i>
                        </button>
                      </div>
                    </div>
                </div>
                <div class="card-body p-0">
                  <table id="view-all" class="table table-striped table-bordered" style="text-align: center;" >
                    <thead>
                      <tr>
                        <th>ID</th> <!-- Add a new header cell for the quantity -->
                        <th>NIP</th>
                        <th>Date</th>
                        <th>Month</th>
                        <th>Year</th>  
                        <th>Time</th>   
                        <th>Total Price</th>    
                        <th></th>
                      </tr>
                    </thead>
                    <tbody id="table-body">
                      <tr>
                        <td>1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>4</td>
                        <td>2023</td>   
                        <td>18:01:33</td>  
                        <td>25000</td>  
                        <td><button class="small-box bg-danger" 
                    style="margin-bottom: 0px; border: none; width: 100%;"
                    data-toggle="modal" data-target="#confirmationDeleteModalLabel">Delete</button></td>      
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>1</td>
                        <td>1</td>
                        <td>4</td>
                        <td>2023</td>   
                        <td>18:01:33</td>  
                        <td>25000</td>  
                        <td><button class="small-box bg-danger" 
                    style="margin-bottom: 0px; border: none; width: 100%;"
                    data-toggle="modal" data-target="#confirmationDeleteModalLabel">Delete</button></td>    
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>1</td>
                        <td>1</td>
                        <td>4</td>
                        <td>2023</td>   
                        <td>18:01:33</td>  
                        <td>25000</td>  
                        <td><button class="small-box bg-danger" 
                    style="margin-bottom: 0px; border: none; width: 100%;"
                    data-toggle="modal" data-target="#confirmationDeleteModalLabel">Delete</button></td>    
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>1</td>
                        <td>1</td>
                        <td>4</td>
                        <td>2023</td>   
                        <td>18:01:33</td>  
                        <td>25000</td>  
                        <td><button class="small-box bg-danger" 
                    style="margin-bottom: 0px; border: none; width: 100%;"
                    data-toggle="modal" data-target="#confirmationDeleteModalLabel">Delete</button></td>    
                      </tr>
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

   <!-- Confirmation Modal -->
  <div class="modal fade" id="confirmationDeleteModalLabel" tabindex="-1" role="dialog" aria-labelledby="confirmationDeleteModalLabel"
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
          <button type="button" class="btn btn-primary bg-danger" onclick="deleteItem()">Delete</button>
        </div>
      </div>
    </div>
  </div>

<script>
  // Get the searchOption element
  const searchOption = document.getElementById('searchOption');

  // Get the productFields and dateFields elements
  const nipFields = document.getElementById('nipFields');
  const dateFields = document.getElementById('dateFields');

  // Function to toggle the display of fields based on the selected option
  function toggleFields() {
    const selectedValue = searchOption.value;
    if (selectedValue === 'nip') {
      nipFields.style.display = 'block';
      dateFields.style.display = 'none';
    } else if (selectedValue === 'date') {
      nipFields.style.display = 'none';
      dateFields.style.display = 'block';
    }
  }

  // Add event listener to the searchOption dropdown to trigger toggleFields on change
  searchOption.addEventListener('change', toggleFields);

  // Call toggleFields initially to set the initial display based on the default selected option
  toggleFields();
</script>

<?php 
  include '../template/footer.php';
?>
</body>
</html>
