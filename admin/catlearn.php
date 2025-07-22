<?php

session_start();

if (isset($_SESSION['UsernameAdmin*&%8253'])) {

    $pageTitle = 'Learning';
    include('init.php');
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {

        $stmt = $con->prepare("SELECT * FROM catlearn ORDER BY `num`  ASC");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        ?>
        <div class="container">
            <div class="row">
                <!-- العمود الأول -->
                <div class="col-lg-8  justify-content-end ">
                    <h1 class="m-3 text-secondary">Sections Videos</h1>
                </div>
                <!-- العمود الثاني -->
                <div class="col-lg-4  justify-content-end ">
                    <form class="row mt-4">
                        <div class="m-auto"
                            style="width:370px ; background-color: white; border-radius: 20px;border:solid 3px gray ;padding-left:5px">
                            <label for="search"><i class="fa-solid fa-magnifying-glass text-dark"></i></label>
                            <input type="text" id="search" class="search mt-1" style="width:80%;"
                                placeholder="Search with email only" onkeyup="getSearch()">
                        </div>
                    </form>
                </div>
            </div>


            <div class="container">
                <div class="table-responsive" id="mainSection">
                    <table class=" main-table table table-borderinged text-center">
                        <tr>
                            <td>#ID</td>
                            <td>ordering</td>
                            <td>name</td>
                            <td>Controle</td>
                        </tr>
                        <?php
                        foreach ($rows as $row) {

                            echo "<tr class='trbox'>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['num'] . "</td>";
                            echo "<td class='tditem'>" . $row['name'] . "</td>";
                            echo "<td> 
                                        <a href='catlearn.php?do=Edit&id=" . $row['id'] . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                        <a href='catlearn.php?do=Delete&id=" . $row['id'] . "'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>
                                        <a href='managelearn.php?do=Manage&cat=" . $row['id'] . "&name=" . $row['name'] . "'class='btn btn-info '><i class='fa-brands text-danger bg-light rounded fa-youtube'></i> Vidioes</a>
                                  </td>";
                        }


                        ?>
                    </table>
                </div>
                <a class='btn btn-primary' id="addbtn" href='catlearn.php?do=Add'><i class="fa fa-plus"></i> New Section</a>
                <div id="hiddenSection"></div>

            </div> <?php
    } elseif ($do == 'Add') {

        ?>

            <h1 class="text-center m-5 text-secondary">Add New Section</h1>
            <div class="container">
                <form class="form-horizontal" action="catlearn.php?do=Insert" method="POST">
                    <!-- Name -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Section Name</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="text" name="name" class="form-control form-control-lg" autocomplete="off" required>
                        </div>
                    </div>
                    <!-- Name -->

                    <!-- ordering -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Section ordering</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="number" value="0" name="ordering" class="form-control form-control-lg"
                                autocomplete="off" required>
                        </div>
                    </div>
                    <!-- ordering -->

                    <!-- start btn -->
                    <div class="row form-group">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-10 ">
                            <input type="submit" value="Add New Section" class="btn btn-primary btn-lg ">
                        </div>
                    </div>
                    <!-- end btn -->
                </form>
                <div>


                    <?php


    } elseif ($do == 'Insert') {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<h1 class='text-center text-secondary m-5 pt-5 '>Insert vidio</h1>";
            echo "<div class='container'>";

            // Get Variables From The Form 
            $name = trim($_POST["name"]);
            $ordering = $_POST['ordering'];

            // Validate The Form
            $FormErrors = array();
            if (empty($name)) {
                $FormErrors[] = ' Name Cant Be Empty';
            }
            if (empty($ordering)) {
                $FormErrors[] = ' ordering Cant Be Empty';
            }

            foreach ($FormErrors as $error) {
                $Msg = "<div class='alert alert-danger'>" . $error . '</div>';
                redirectHome($Msg, 'back');

            }
            if (empty($FormErrors)) {

                $check = CheckItem("name", "catlearn", $name);

                if ($check) {
                    $Msg = "<div class='alert alert-danger'> This name Is Used </div>";
                    redirectHome($Msg, 'back', 4);
                } else {
                    //  insert in the database
                    $stmt = $con->prepare("INSERT INTO catlearn(name,`num`)
                    VALUES(:zname,:zordering) ");
                    $stmt->execute(array(
                        'zname' => $name,
                        'zordering' => $ordering
                    ));

                    if ($stmt->rowCount() < 1) {
                        $Msg = "<div class='alert alert-danger'> Record Not Inserted </div>";
                        redirectHome($Msg, 'back', 4);
                    } else {
                        $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Inserted </div>";
                        redirectHome($msg, 'catlearn.php');
                    }
                }

            }
        } else {
            echo "<div class='container'>'";
            $errorMsg = "<div class='alert alert-danger'> Sorry You Cant Browse This Page Directly </div>";
            redirectHome($errorMsg);
            echo "</div>";
        }
        echo "</div>";


    } elseif ($do == 'Edit') {

        $vid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '0';
        // echo $userid;

        $stmt = $con->prepare(" SELECT * FROM catlearn WHERE id = ? LIMIT 1 ");
        $stmt->execute(array($vid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {



            ?>

                        <h1 class="text-center m-5 text-secondary">Edit Section</h1>
                        <div class="container">
                            <form class="form-horizontal" action="catlearn.php?do=Update" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <!-- start name -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3"> name</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="text" name="name" class="form-control form-control-lg" autocomplete="off"
                                            value="<?php echo $row['name'] ?>" required>
                                    </div>
                                </div>
                                <!-- end name -->

                                <!-- start ordering -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3"> ordering</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="number" name="ordering" class="form-control form-control-lg" autocomplete="off"
                                            value="<?php echo $row['num'] ?>" required>
                                    </div>
                                </div>
                                <!-- start ordering -->

                                <!-- start btn -->
                                <div class="row form-group">
                                    <label class="col-sm-2"></label>
                                    <div class="col-sm-10 ">
                                        <input type="submit" value="Save" class="btn btn-primary btn-lg ">
                                    </div>
                                </div>
                                <!-- end btn -->
                            </form>
                            <div>


                                <?php

        } else {
            echo "<div class='container pt-5'>";
            $msg = "<div class='alert alert-danger'>There No Such Id In DataBase</div>";
            redirectHome($msg, 'back');
            echo "</div>";
        }

    } elseif ($do == 'Update') {

        echo "<h1 class='text-center text-secondary m-5 pt-5 f-bold'>Update video</h1>";
        echo "<div class='container'>";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get Variables From The Form 
            $id = $_POST["id"];
            $name = trim($_POST["name"]);
            $ordering = $_POST["ordering"];

            // Validate The Form
            $FormErrors = array();
            if (empty($name)) {
                $FormErrors[] = 'User Name Cant Be Empty';
            }
            if (!isset($ordering) || trim($ordering) === '') {
                $FormErrors[] = 'ordering Cant Be Empty';
            }
            foreach ($FormErrors as $error) {
                $Msg = "<div class='alert alert-danger'>" . $error . '</div>';
                redirectHome($Msg, 'back');

            }
            if (empty($FormErrors)) {


                //  Update the database

                $stmt = $con->prepare("UPDATE catlearn SET name = ? , num = ?  WHERE id = ? ");
                $stmt->execute(array($name, $ordering, $id));
                if ($stmt->rowCount() < 1) {
                    $Msg = "<div class='alert alert-danger'> Record Not Updated </div>";
                    redirectHome($Msg, 'catlearn.php');

                } else {
                    $Msg = "<div class='alert alert-success'> " . $stmt->rowCount() . " Record Updated </div>";
                    redirectHome($Msg, 'catlearn.php');

                }

            }
        } else {
            $msg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
            redirectHome($msg);
            echo "</div>";
        }
    } elseif ($do == 'Delete') {

        echo "<h1 class='text-center text-secondary m-5 pt-5 '>Delete Section</h1>";
        echo "<div class='container'>";

        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '0';

        $check = CheckItem('id', 'catlearn', $id);

        if ($check) {
            $stmt = $con->prepare("DELETE FROM catlearn WHERE id = :zid");
            $stmt->bindparam(":zid", $id);
            $stmt->execute();

            $dv=$con->prepare("DELETE FROM learn WHERE CAT_ID = ?");
            $dv->execute(array($id));
            
            $msg = "<div class='alert alert-success'> " . $stmt->rowCount() . " Record Deleted </div>";
            redirectHome($msg, 'back');
        } else {
            $msg = "<div class='alert alert-danger'>This Id Is Not Exist </div>";
            redirectHome($msg, 'back');
        }

        echo "</div>";


    }

    include($tpl . 'footer.inc.php');

} else {
    header('Location:index.php');
    exit();
}
?>