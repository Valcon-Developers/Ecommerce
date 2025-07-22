<?php

/*
============================================
==  Title Page
============================================
*/

session_start();

if (isset($_SESSION['UsernameAdmin*&%8253'])) {

    $pageTitle = 'Review';
    include('init.php');
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    echo "<div class='container'>";

    if ($do == 'Manage') {
        $stmt = $con->prepare("SELECT * FROM review");
        $stmt->execute();
        $row = $stmt->fetchAll();
        ?>

        <div class="row pt-5 mt-2">
            <?php foreach ($row as $img) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card shadow rounded-4 h-100">
                        <a href="layout/images/items/<?php echo $img['image']; ?>">
                            <img src="layout/images/items/<?php echo $img['image']; ?>"
                                class="card-img-top rounded-top-4 img-fluid object-fit-cover" alt="Review Image"
                                style="height: 200px; width: 100%;">
                        </a>
                        <div class="card-body p-2">
                            <a href='?do=Delete&id=<?php echo $img['id']; ?>' class='confirm btn btn-danger w-100'>Delete</a>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>
        <a href='?do=Add' class=' mt-5 btn btn-primary'>New Image</a>

        <?php



    } elseif ($do == 'Add') { ?>
        <h2 class="text-center text-secondary m-5">Add New Image</h2>
        <form action="managereview.php?do=Insert" method="POST" enctype="multipart/form-data"> <!-- start image -->
            <div class="row form-group ">
                <label class="col-sm-2 h3">Image</label>
                <div class="col-sm-8 col-md-8">
                    <input type="file" name="image" class="form-control form-control-lg">
                </div>
            </div>
            <!-- end image -->

            <div class="row form-group">
                <label class="col-sm-2"></label>
                <div class="col-sm-10 ">
                    <input type="submit" value="save image" class="btn btn-primary btn-lg ">
                </div>
            </div>
            <!-- end btn -->
        </form>
        <?php
    } elseif ($do == 'Insert') {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<h1 class='text-center text-secondary m-5 pt-5 '>Insert Image</h1>";
            echo "<div class='container'>";

            // Get Variables From The Form 

            $realImageName = $_FILES["image"]["name"];
            $ext = pathinfo($realImageName, PATHINFO_EXTENSION);
            $newImageName = uniqid("img_") . "." . $ext;
            $tmpName = $_FILES["image"]["tmp_name"];
            $imagepath = "layout/images/items/" . basename($newImageName);



            // Validate The Form
            $FormErrors = [];
            if (empty($realImageName)) {
                $FormErrors[] = 'You Must Choose image';
            }
            foreach ($FormErrors as $error) {

                echo "<div class='alert alert-danger'>" . $error . '</div>';

                echo "<div class='btn btn-primary' style='cursor:pointer;' onclick='history.back();'>Back</div>";

            }
            if (empty($FormErrors)) {

                // move image 

                move_uploaded_file($tmpName, $imagepath);

                //  insert the database

                $stmt = $con->prepare("INSERT INTO review(Image)
                    VALUES(:zimage)");
                $stmt->execute(array(
                    'zimage' => $newImageName
                ));

                if ($stmt->rowCount() < 1) {
                    $Msg = "<div class='alert alert-danger'> Record Not Inserted </div>";
                    redirectHome($Msg, 'managereview.php', 4);
                } else {
                    $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Inserted </div>";
                    redirectHome($msg, 'managereview.php');
                }


            }
        } else {
            echo "<div class='container'>'";
            $errorMsg = "<div class='alert alert-danger'> Sorry You Cant Browse This Page Directly </div>";
            redirectHome($errorMsg, 'logout.php');
            echo "</div>";
        }
        echo "</div>";



    } elseif ($do == 'Delete') {
        echo "<h1 class='text-center text-secondary m-5 pt-5'>Delete Image</h1>";
        echo "<div class='container'>";

        // Get image ID
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

        // Check if image exists
        $stmt = $con->prepare("SELECT * FROM review WHERE id = ?");
        $stmt->execute([$id]);
        $img = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
            // Delete image from folder
            $imageFile = "layout/images/items/" . $img['image'];
            if (file_exists($imageFile)) {
                unlink($imageFile); // remove from folder
            }

            // Delete from database
            $stmt = $con->prepare("DELETE FROM review WHERE id = :zid");
            $stmt->bindParam(":zid", $id);
            $stmt->execute();

            $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Image Deleted </div>";
            redirectHome($msg, 'managereview.php');

        } else {
            $msg = "<div class='alert alert-danger'>No image found with this ID</div>";
            redirectHome($msg, 'managereview.php');
        }

        echo "</div>";
    }

    echo "</div>";
    include($tpl . 'footer.inc.php');
} else {
    header('Location:index.php');
    exit();
}
?>