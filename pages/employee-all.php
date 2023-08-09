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
              <h1 class="m-0">Employee</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="../pages/employee.php">Employee</a></li>
                <li class="breadcrumb-item active"><a href="#">AllEmployee</a></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="form-row">
                    <div id="nipFields">
                      <div class="form-group" style="width: 100%;">
                        <form action="" method="get">
                          <input type="search" id="fnip" name="fnip" style="width: 100%;" placeholder="NIP">
                        </form>
                      </div>
                    </div>
                    <div class="form-group col-md-1">
                      <button id="searchButton" type="submit" class="btn btn-info">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                    <div class="form-group col-md-5">
                      <a href="employee-add.php" class="btn btn-primary float-right">Add Data Employee</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>NIP</th>
                      <th>Name</th>
                      <th>Username</th>
                      <th>address</th>
                      <th>phone number</th>
                      <th>department name</th>
                      <th>Position</th>
                      <th colspan="3">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    include 'requestApi/getEmployee.php';
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
    </section>
  </div>

  <!-- Modal Detail Employee Roles -->
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

  <script type="text/javascript">
    const searchOption = document.getElementById('searchOption');

    // Get the productFields and dateFields elements
    const nipFields = document.getElementById('nipFields');
    const dateFields = document.getElementById('dateFields');
    const searchButton = document.getElementById('searchButton');

    // Function to toggle the display of fields based on the selected option
    function toggleFields() {
      const selectedValue = searchOption.value;
      if (selectedValue === 'nip') {
        nipFields.style.display = 'block';
        dateFields.style.display = 'none';
        searchButton.style.display = 'none';
      } else if (selectedValue === 'date') {
        nipFields.style.display = 'none';
        dateFields.style.display = 'block';
        searchButton.style.display = 'block';
      }
    }

    // Add event listener to the searchOption dropdown to trigger toggleFields on change
    searchOption.addEventListener('change', toggleFields);

    // Call toggleFields initially to set the initial display based on the default selected option
    toggleFields();

    function confirm_alert(node) {
      return confirm("Anda yakin mau hapus data ini?");
    }

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
      Detail Employee ID = ${id}
    `;
      let detailProduct = ''
      for (let i = 0; i < detail.length; i++) {
        detailProduct += `
      <tr>
      
        <td>${detail[i].id}</td>
        <td>${detail[i].nama_role}</td>
      </tr>
      `
      }
      const modalContent = `
        <div style="margin-bottom:0px">
        Name : ${column1}<br>
        Username : ${column2} <br>
        Address :${column3} <br> 
        Number Phone :${column4}<br>
        Position: ${column5}<br>
        Product Details:
        <table class="table table-striped table-bordered" style="text-align: center;">
          <tr>
            <th>ID Role</th>
            <th>Nama Role</th>
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
  </script>

  </div>
  <?php
  include '../template/footer.php';
  ?>
</body>

</html>