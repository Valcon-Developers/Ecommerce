<?php
$pageTitle = 'Review';
$NoSearchBar = true;
include('init.php');

$stmt = $con->prepare("SELECT * FROM review");
$stmt->execute();
$row = $stmt->fetchAll();

?>
<div class="container"style="min-height:100vh">
    <div class="row pt-5 mt-2">
        <?php foreach ($row as $img) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card shadow rounded-4 h-100">
                    <a href="admin/layout/images/items/<?php echo $img['image']; ?>">
                        <img src="Admin/layout/images/items/<?php echo $img['image']; ?>"
                            class="card-img-top rounded-top-4 img-fluid object-fit-cover" alt="Review Image"
                            style="height: 200px; width: 100%;">
                    </a>
                </div>
            </div>

        <?php } ?>
</div>
</div>
        <script>let type = 'review'</script>
        <?php
        include($tpl . 'footer.inc.php');
        ?>