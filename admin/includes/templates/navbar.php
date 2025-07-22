<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
    <a class="navbar-brand" href="dashboard.php"><?php echo lang("Home_Admin") ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="members.php"><?php echo lang("MEMBERS") ?><span class="sr-only">(current)</span></a>
            </li>
        <li class="nav-item active">
            <a class="nav-link" href="categories.php"><?php echo lang("CATEGORIES") ?><span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="items.php"><?php echo lang("ITEMS") ?><span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="orders.php"><?php echo lang("ORDERS") ?><span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="statistics.php"><?php echo lang("STATISTICS") ?><span class="sr-only">(current)</span></a>
        </li>        
        <li class="nav-item active">
            <a class="nav-link" href="catlearn.php">Learning<span class="sr-only">(current)</span></a>
        </li>        
        <li class="nav-item active">
            <a class="nav-link" href="managereview.php">Review<span class="sr-only">(current)</span></a>
        </li>  

    </ul>
    <div class="nav-item dropdown ">
        <a class="nav-link dropdown-toggle text-light" href="#" id="app-nav" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo lang("Dropdown") ?>
        </a>
        <div class="dropdown-menu " aria-labelledby="app-nav">
        <a class="dropdown-item droplink text-light" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">الملف الشخصي</a>
        <a class="dropdown-item droplink text-light" href="soft-setting.php">الاعدادات</a>
        <a class="dropdown-item droplink text-light" href="items.php?trashpage=1">سلة المحذوفات</a>
        <a class="dropdown-item droplink text-light" href="Logout.php">تسجيل الخروج</a>
        </div>
    </div>
    </div>
  </div>
</nav>
 

