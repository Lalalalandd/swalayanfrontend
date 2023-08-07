<!-- Sidebar -->
<div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $_SESSION['username']?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php if($_SESSION["role"] == "ROLE_ADMIN") { ?>
          <li class="nav-item">
            <a href="employee.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Employee</p>
            </a>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a href="product.php" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>Product</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="incoming_product-add.php" class="nav-link">
              <i class="nav-icon fas fa-truck"></i>
              <p>Incoming Product</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="transaction-add.php" class="nav-link">
              <i class="nav-icon fas fa-receipt"></i>
              <p>Transaction</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="requestApi/logout.php" class="nav-link">
              <i class="nav-icon fas fa-receipt"></i>
              <p>Log Out</p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->