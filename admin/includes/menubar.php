<aside class="main-sidebar">
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo (!empty($admin['photo'])) ? '../images/'.$admin['photo'] : '../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $admin['firstname'].' '.$admin['lastname']; ?></p>
        <a><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
    <!--   <li class="header">REPORTS</li> -->
      <li><a href="home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <li><a href="sales.php"><i class="fa fa-search" aria-hidden="true"></i> <span>Request List</span></a></li>
      <li><a href="ongoing.php"><i  class="fa fa-spinner" aria-hidden="true"></i> <span>On-Going Orders</span></a></li>
      <li><a href="return.php"><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> <span>Return List</span></a></li>
      <li><a href="dbody.php"><i class="fa fa-minus-circle" aria-hidden="true"></i> <span>Scrap Parts List</span></a></li>
      <li><a href="lowstock.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Low Stock</span></a></li>
      <li><a href="report.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Reports</span></a></li>

      <!-- <li><a href="users.php"><i class="fa fa-bar-chart" aria-hidden="true"></i> <span>Reports</span></a></li> -->


      <li class="header">MANAGE</li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-barcode"></i>
          <span>Products</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="products.php"><i class="fa fa-square-o"></i> Product List</a></li>
          <li><a href="category.php"><i class="fa fa-square-o"></i> Brand</a></li>
          <li><a href="vendor.php"><i class="fa fa-square-o"></i> Vendor</a></li>
          

        </ul>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-odnoklassniki"></i>
          <span>Users Control</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="users.php"><i class="fa fa-square-o"></i> Users </a></li>
           <li><a href="plant.php"><i class="fa fa-square-o"></i> Plant </a></li>
           <li><a href="line.php"><i class="fa fa-square-o"></i> Line </a></li>

        </ul>
      </li>

<!-- <li class="header">CHATTING</li>
      <li><a href="../chat/admin/index.php" target="_blank" rel="noreferrer noopener"><i class="fa fa-comments"></i> <span>Chat Now</span></a></li>

 -->
    <!-- </ul> -->
  </section>
  <!-- /.sidebar -->
</aside>
