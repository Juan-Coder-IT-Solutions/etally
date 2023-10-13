<!-- Sidebar - Brand -->
<li class="nav-item">
    <a class="nav-link" href="index.php">
      <center><img class="img-fluid" src="assets/img/logo.png" style="width: 50%;"></center>
    </a>
</li>

<?php if($_SESSION['etally']['user_category'] == 'O'){ ?>
<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Menu
</div>

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="index.php?page=events">
        <i class="fas fa-fw fa-table"></i>
        <span>Event</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="index.php?page=judges">
        <i class="fas fa-fw fa-users"></i>
        <span>Judges</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="index.php?page=participants">
        <i class="fas fa-fw fa-users"></i>
        <span>Participants</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="index.php?page=users">
        <i class="fas fa-fw fa-user"></i>
        <span>User</span></a>
</li>
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<?php } ?>
<?php if($_SESSION['etally']['user_category'] == 'J'){ ?>
<hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="index.php?page=judge-events">
            <i class="fas fa-fw fa-table"></i>
            <span>Event</span></a>
    </li>
<hr class="sidebar-divider d-none d-md-block">
<?php } ?>
<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
