<?php

session_start();

if (isset($_SESSION['UsernameAdmin*&%8253'])) {

    $pageTitle = 'Learning';

    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


    if ($do == 'Manage') {

        if (isset($_GET['cat'])) {

            $cat = $_GET['cat'];
            $stmt = $con->prepare("SELECT * FROM learn Where CAT_ID = ?");
            $stmt->execute(array($cat));

        } else {

            $stmt = $con->prepare("SELECT * FROM learn ");
            $stmt->execute(array());
        }


        $rows = $stmt->fetchAll();

        ?>
        <div class="container">
            <div class="row">
                <!-- العمود الأول -->
                <div class="col-lg-8  justify-content-end ">
                    <h1 class="m-3 text-secondary">Videos</h1>
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
                    <table class=" main-table table table-bordered text-center">
                        <tr>
                            <td>#ID</td>
                            <td>name</td>
                            <td>link</td>
                            <td>category</td>
                            <td>Controle</td>
                        </tr>
                        <?php

                        foreach ($rows as $row) {

                            echo "<tr class='trbox'>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td class='tditem'>" . $row['name'] . "</td>";
                            echo "<td>" . $row['link'] . "</td>";
                            echo "<td>" . $_GET['name'] . "</td>";
                            echo "<td> 
                                        <a href='managelearn.php?do=Edit&id=" . $row['id'] . "&name=" . $_GET['name'] . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                        <a href='managelearn.php?do=Delete&id=" . $row['id'] . "'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>
                                 </td>";
                        }


                        ?>
                    </table>
                </div>
                <a class='btn btn-primary' id="addbtn" href='managelearn.php?do=Add&name=<?php echo $_GET['name'] ?>'><i
                        class="fa fa-plus"></i> New video</a>
                <div id="hiddenSection"></div>

            </div> <?php
    } elseif ($do == 'Add') {
        // echo $_GET['name'];
        ?>

            <h1 class="text-center m-5 text-secondary">Add New video</h1>
            <div class="container">
                <form class="form-horizontal" action="managelearn.php?do=Insert" method="POST">
                    <!-- Name -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Video Name</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="text" name="name" class="form-control form-control-lg" autocomplete="off" required>
                        </div>
                    </div>
                    <!-- Name -->

                    <!-- start link -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Link</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="text" name="link" class="form-control form-control-lg" required>
                        </div>
                    </div>
                    <!-- start link -->

                    <!-- start category -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">category</label>
                        <div class="col-sm-8 col-md-8">
                            <select class='form-control' name="category" id="">
                                <option value="">...</option>
                                <?php
                                $stmt4 = $con->prepare("SELECT * FROM catlearn ");
                                $stmt4->execute();
                                $names = $stmt4->fetchAll();


                                foreach ($names as $name) {
                                    echo "<option value ='";
                                    echo $name['id'];
                                    echo "'";
                                    if ($name['name'] == $_GET['name']) {
                                        echo "selected";
                                    }
                                    echo '>';
                                    echo $name['name'];
                                    echo "</option>";
                                }

                                ?>
                            </select>

                        </div>
                    </div>
                    <!-- start category -->


                    <!-- start btn -->
                    <div class="row form-group">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-10 ">
                            <input type="submit" value="Add New video" class="btn btn-primary btn-lg ">
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
            $name = $_POST["name"];
            $link = $_POST["link"];
            $category = $_POST['category'];

            // Validate The Form
            $FormErrors = array();
            if (empty($name)) {
                $FormErrors[] = ' Name Cant Be Empty';
            }
            if (strlen($name) < 4) {
                $FormErrors[] = ' Name Cant Be Less Than 4 Characters';
            }
            if (empty($link)) {
                $FormErrors[] = 'Link Cant Be Empty';
            }
            if (strlen($link) < 10) {
                $FormErrors[] = 'link Cant Be Less Than 10 Characters';
            }
            if (!filter_var($link, FILTER_VALIDATE_URL)) {
                $FormErrors[] = 'Link must be a valid URL';
            }

            foreach ($FormErrors as $error) {
                $Msg = "<div class='alert alert-danger'>" . $error . '</div>';
                redirectHome($Msg, 'back');

            }
            if (empty($FormErrors)) {

                $check = CheckItem("name", "learn", $name);

                if ($check) {
                    $Msg = "<div class='alert alert-danger'> This name Is Used </div>";
                    redirectHome($Msg, 'back', 4);
                } else {
                    //  Update the database


                    $stmt = $con->prepare("INSERT INTO learn(name, link,CAT_ID)
                    VALUES(:zname, :zlink,:zcategory) ");
                    $stmt->execute(array(
                        'zname' => $name,
                        'zlink' => $link,
                        'zcategory' => $category
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

        $stmt = $con->prepare(" SELECT * FROM learn WHERE id = ? LIMIT 1 ");
        $stmt->execute(array($vid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {



            ?>

                        <h1 class="text-center m-5 text-secondary">Edit video</h1>
                        <div class="container">
                            <form class="form-horizontal" action="managelearn.php?do=Update" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                <!-- start name -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3"> name</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="text" name="name" class="form-control form-control-lg" autocomplete="off"
                                            value="<?php echo $row['name'] ?> " required>
                                    </div>
                                </div>
                                <!-- end name -->

                                <!-- start link -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3">Link </label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="text" name="link" class="form-control form-control-lg"
                                            value="<?php echo $row['link'] ?>" required>
                                    </div>
                                </div>
                                <!-- start link -->
                                <!-- start category -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3">category</label>
                                    <div class="col-sm-8 col-md-8">
                                        <select class='form-control' name="category" id="">
                                            <option value="">...</option>
                                            <?php
                                            $stmt4 = $con->prepare("SELECT * FROM catlearn ");
                                            $stmt4->execute();
                                            $names = $stmt4->fetchAll();

                                            foreach ($names as $name) {
                                                echo "<option value='";
                                                echo $name['id'];
                                                echo "'";
                                                if ($_GET['name'] == $name['name']) {
                                                    echo 'selected';
                                                }
                                                echo ">";
                                                echo $name['name'];

                                                echo "</option>";
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- start category -->

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
            $name = $_POST["name"];
            $link = $_POST["link"];
            $category = $_POST["category"];

            // Validate The Form
            $FormErrors = array();
            if (empty($name)) {
                $FormErrors[] = 'User Name Cant Be Empty';
            }
            if (strlen($name) < 4) {
                $FormErrors[] = 'User Name Cant Be Less Than 4 Characters';
            }
            if (empty($link)) {
                $FormErrors[] = 'link Cant Be Empty';
            }
            if (strlen($link) < 10) {
                $FormErrors[] = 'link Cant Be less than 10 characters';
            }
            if (!filter_var($link, FILTER_VALIDATE_URL)) {
                $FormErrors[] = 'Link must be a valid URL';
            }

            foreach ($FormErrors as $error) {
                $Msg = "<div class='alert alert-danger'>" . $error . '</div>';
                redirectHome($Msg, 'back');

            }
            if (empty($FormErrors)) {

                //  Update the database

                echo "<pre>";
                print_r($_POST);
                echo "</pre>";

                $stmt = $con->prepare("UPDATE learn SET name = ? , link = ? , CAT_ID = ? WHERE id = ? ");
                $stmt->execute(array($name, $link, $category, $id));
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

        echo "<h1 class='text-center text-secondary m-5 pt-5 '>Delete video</h1>";
        echo "<div class='container'>";

        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : '0';

        $check = CheckItem('id', 'learn', $id);

        if ($check) {
            $stmt = $con->prepare("DELETE FROM learn WHERE id = :zid");
            $stmt->bindparam(":zid", $id);
            $stmt->execute();
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