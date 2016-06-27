<?php global $user_info; ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image"><img alt="User Image" class="img-circle" src="./assets/images/avatar.png"></div>
      <div class="pull-left info">
        <p><?php echo $user_info['first_name'] .' '. $user_info['last_name']; ?></p>
        <p style="text-transform: uppercase;    margin-bottom: 0px;"><?php echo $user_info['user_type']?></p>
      </div>
    </div><!-- search form -->
    <!--form action="#" class="sidebar-form" method="get">
      <div class="input-group">
        <input class="form-control" name="q" placeholder="Recherche..." type="text">
        <span class="input-group-btn">
          <button class="btn btn-flat" id='search-btn' name='seach' type='submit'>
            <i class="fa fa-search"></i>
          </button>
        </span>
      </div>
    </form--><!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less 
    <ul class="sidebar-menu">-->
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" id="os_admin_menu">
    <?php 
      global $os_admin_menu;
      echo print_menu_items($os_admin_menu);
    ?>
    </ul>

  </section><!-- /.sidebar -->
</aside>

<!-- Contents -->
<div class="wrapper row-offcanvas row-offcanvas-left">
  <aside class="main-content">
    <!-- Main content -->
    <section class="content">