<?php

/*
============================================
==  Items Page
============================================
*/

session_start();

if (isset($_SESSION['UsernameAdmin*&%8253'])) {

    $pageTitle = 'Items';
    include('init.php');
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        $addquary = null;
        if (isset($_GET["catid"])) {
            $catid = $_GET["catid"];
            $addquary = "WHERE trash = 0 AND Cat_ID = $catid;";
        } elseif (isset($_GET["trashpage"])) {
            $addquary = "WHERE trash = 1 ";
        } else {
            $addquary = 'WHERE trash = 0  ';
        }
        // dovjgmcb7um0qusdm3u916oeko
        $stmt = $con->prepare("SELECT items.* , categories.Name AS Category_Name FROM items INNER JOIN categories on items.Cat_ID = categories.ID $addquary;");
        $stmt->execute();
        $items = $stmt->fetchAll();
        ?>
        <div class="container">
            <div class="row">
                <!-- العمود الأول -->
                <div class="col-lg-8  justify-content-end ">
                    <h1 class="m-3 text-secondary">Manage items</h1>
                </div>
                <!-- العمود الثاني -->
                <div class="col-lg-4  justify-content-end ">
                    <form class="row mt-4">
                        <div class="m-auto"
                            style="width:370px ; background-color: white; border-radius: 20px;border:solid 3px gray ;padding-left:5px">
                            <label for="search"><i class="fa-solid fa-magnifying-glass text-dark"></i></label>
                            <input type="text" id="search" class="search mt-1" style="width:80%;"
                                placeholder="Search for products here" onkeyup="getSearch()">
                        </div>
                    </form>
                </div>
            </div>


            <div class="container">
                <div class="table-responsive" id="mainSection">
                    <table class=" main-table table table-bordered text-center">
                        <tr>
                            <td>#ID</td>
                            <td>Image</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Price_buy</td>
                            <td>price_sale</td>
                            <td>price_del</td>
                            <td>Adding Date</td>
                            <td>Category</td>
                            <td>File</td>
                            <td>Controle</td>
                        </tr>
                        <?php
                        foreach ($items as $item) {

                            echo "<tr class='trbox'>";

                            echo "<td>" . $item['item_ID'] . " ";
                            if ($item['hidden'] == 1) {
                                echo '<i class="text-danger h2  fa-solid fa-eye-slash"></i>';
                            }
                            echo "</td>";
                            echo "<td> ";
                            echo "<a href ='layout/images/items/" . $item['Image'] . "'/ >";
                            echo " <img src='layout/images/items/" . $item['Image'] . "'alt='sorry This file type not supported'style='width:50px;height:50px' ></td>";
                            echo "</a>";
                            echo "</td>";
                            echo "<td class='tditem'>" . $item['Name'] . "</td>";
                            echo "<td>" . $item['Description'] . "</td>";
                            echo "<td>" . $item['price_buy'] . "</td>";
                            echo "<td>" . $item['price_sale'] . "</td>";
                            echo "<td>" . $item['price_deleting'] . "</td>";
                            echo "<td>" . $item['Add_Date'] . "</td>";
                            echo "<td>" . $item['Category_Name'] . "</td>";
                            echo "<td>";
                            if ($item['File'] != "") {

                                echo "<a href='files/offers/" . $item['File'] . "' target='_blank'>";
                                echo "<li class='fa fa-file-pdf h2'></li>";
                                echo "</a>";
                                echo "</td>";
                            } else {
                                echo "<div class='text-danger' > This Item Has No File </div>";
                            }
                            echo "<td>";

                            if (isset($_GET['trashpage'])) {
                                echo "<a href='items.php?do=back&itemid=" . $item['item_ID'] . "'class='btn btn-primary'><i class='fa-solid fa-recycle'></i> Back</a>";
                            } else {
                                echo "<a href='items.php?do=Edit&itemid=" . $item['item_ID'] . '&img=' . $item['Image'] . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>";

                            }

                            if (isset($_GET['trashpage'])) {
                                echo "<a href='items.php?do=Delete&itemid=" . $item['item_ID'] . "&img=" . $item['Image'] . "' class='btn btn-danger confirm ml-1'><i class='fa fa-close'></i> Delete</a>";
                            } else {
                                echo "<a href='items.php?do=trash&itemid=" . $item['item_ID'] . "' class='btn btn-danger confirm ml-1'><i class='fa-solid fa-trash'></i> Trash</a>";

                            }
                            echo "</td>";
                            echo "</td>";
                        }

                        ?>
                    </table>
                </div>
                <a class='btn btn-primary' id="addbtn" href='items.php?do=Add'><i class="fa fa-plus"></i> New Item</a>
                <div id="hiddenSection"></div>
            </div>

        <?php
    } elseif ($do == 'Add') { ?>

            <h1 class="text-center m-5 text-secondary">Add New Item</h1>
            <div class="container">
                <form class="form-horizontal" action="items.php?do=Insert" method="POST" enctype="multipart/form-data">
                    <!-- start Name -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Name</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="text" name="name" class="form-control form-control-lg" autocomplete="off" required
                                placeholder="Name off the item">
                        </div>
                    </div>
                    <!-- end Name -->

                    <!-- start Description -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Description</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="text" name="description" class="form-control form-control-lg"
                                placeholder="Descripe The item" required>
                        </div>
                    </div>
                    <!-- end Description -->

                    <!-- start price-buy -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Price_Buy</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="number" name="price_buy" class="form-control form-control-lg"
                                placeholder="Price buying item" required>
                        </div>
                    </div>
                    <!-- end price-buy -->

                    <!-- start price-sale -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Price_Sale</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="number" name="price_sale" class="form-control form-control-lg"
                                placeholder="Price saling item" required>
                        </div>
                    </div>
                    <!-- end price-sale -->

                    <!-- start price-deleted -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Price_deleting</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="number" name="price_dell" class="form-control form-control-lg"
                                placeholder="Price that line over throw item">
                        </div>
                    </div>
                    <!-- end price-deleted -->

                    <!-- start country made -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Country_Made</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="text" name="country" class="form-control form-control-lg"
                                placeholder="country made item">
                        </div>
                    </div>
                    <!-- end country made -->

                    <!-- start hidden -->
                    <div class="row form-group">
                        <label class="col-sm-2 h3">Visibility</label>
                        <div class="col-sm-8 col-md-8 d-flex align-items-center " style='gap:50px ; background-color:white'>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visible" id="visibleYes" value="0" checked>
                                <label class="form-check-label" for="visibleYes">Visible</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="visible" id="visibleNo" value="1">
                                <label class="form-check-label" for="visibleNo">Hidden</label>
                            </div>
                        </div>
                    </div>
                    <!-- end hidden -->


                    <!-- start category -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Category</label>
                        <div class="col-sm-8 col-md-8">
                            <select name="category" class="form-control bg-light text-dark">
                                <option value="0">...</option>
                                <?php
                                $stmt = $con->prepare("SELECT * FROM categories ");
                                $stmt->execute();
                                $cats = $stmt->fetchAll();
                                foreach ($cats as $cat) {
                                    echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";

                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- end category -->

                    <!-- start image -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Image</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="file" name="image" class="form-control form-control-lg" required>
                        </div>
                    </div>
                    <!-- end image -->

                    <!-- start file -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">file</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="file" name="file" class="form-control form-control-lg">
                        </div>
                    </div>
                    <!-- end file -->

                    <!-- start btn -->
                    <div class="row form-group">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-10 ">
                            <input type="submit" value="save item" class="btn btn-primary btn-lg ">
                        </div>
                    </div>
                    <!-- end btn -->
                </form>
                <div>

                    <?php

    } elseif ($do == 'Insert') {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            echo "<h1 class='text-center text-secondary m-5 pt-5 '>Insert Item</h1>";
            echo "<div class='container'>";

            // Get Variables From The Form 
            $itemName = $_POST["name"];
            $description = $_POST["description"];
            $price_buy = $_POST["price_buy"];
            $price_sale = $_POST["price_sale"];
            $price_dell = $_POST["price_dell"];
            $country = $_POST["country"];
            $cat = $_POST["category"];
            $visible = $_POST["visible"];

            $realImageName = $_FILES["image"]["name"];
            $ext = pathinfo($realImageName, PATHINFO_EXTENSION);
            $newImageName = uniqid("img_") . "." . $ext;
            $tmpName = $_FILES["image"]["tmp_name"];
            $imagepath = "layout/images/items/" . basename($newImageName);

            if (isset($_FILES["file"]['name']) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {

                $fileRealName = $_FILES['file']['name'];
                $file_exe = pathinfo($fileRealName, PATHINFO_EXTENSION);
                $newFileName = uniqid("file_") . "." . $file_exe;
                $tempFile = $_FILES['file']['tmp_name'];
                $newFilePath = "files/offers/" . basename($newFileName);
            } else {
                $newFileName = '';
            }

            // Validate The Form
            $FormErrors = array();
            if (empty($itemName)) {
                $FormErrors[] = 'Item Name Cant Be Empty';
            }
            if (empty($description)) {
                $FormErrors[] = 'Description Name Cant Be Empty';
            }
            if (empty($price_buy)) {
                $FormErrors[] = 'Price_buy Cant Be Empty';
            }
            if (empty($price_sale)) {
                $FormErrors[] = 'price_sale Cant Be Empty';
            }
            if ($cat == "0") {
                $FormErrors[] = 'You Must Choose Category';
            }
            if (empty($realImageName)) {
                $FormErrors[] = 'You Must Choose image';
            }
            foreach ($FormErrors as $error) {
                echo "<div class='alert alert-danger'>" . $error . '</div>';

                echo "<div class='btn btn-primary' style='cursor:pointer;' onclick='history.back();'>Back</div>";

            }
            if (empty($FormErrors)) {
                // move image 
                if (isset($_FILES["file"]['name']) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
                    move_uploaded_file($tempFile, $newFilePath);
                }
                move_uploaded_file($tmpName, $imagepath);
                //  insert the database
                $stmt = $con->prepare("INSERT INTO items(Name,Description,price_buy,price_sale,price_deleting,Add_Date,Country_Made,	Cat_ID,Image,File,hidden)
                    VALUES(:zName, :zDescription, :zprice_buy, :zprice_sale, :zprice_deleting, now() , :zCountry_Made,:zcat ,:zimage,:zFile,:zhidden)");
                $stmt->execute(array(
                    'zName' => $itemName,
                    'zDescription' => $description,
                    'zprice_buy' => $price_buy,
                    'zprice_sale' => $price_sale,
                    'zprice_deleting' => $price_dell,
                    'zCountry_Made' => $country,
                    'zcat' => $cat,
                    'zimage' => $newImageName,
                    'zFile' => $newFileName,
                    'zhidden' => $visible
                ));

                if ($stmt->rowCount() < 1) {
                    $Msg = "<div class='alert alert-danger'> Record Not Inserted </div>";
                    redirectHome($Msg, 'items.php', 4);
                } else {
                    $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Inserted </div>";
                    redirectHome($msg, 'items.php');
                }


            }
        } else {
            echo "<div class='container'>'";
            $errorMsg = "<div class='alert alert-danger'> Sorry You Cant Browse This Page Directly </div>";
            redirectHome($errorMsg, 'logout.php');
            echo "</div>";
        }
        echo "</div>";


    } elseif ($do == 'Edit') {

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : '0';
        // echo $userid;

        $stmt = $con->prepare(" SELECT * FROM items WHERE item_ID = ? ");
        $stmt->execute(array($itemid));
        $item = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            ?>

                        <h1 class="text-center m-5 text-secondary">Edit Item</h1>
                        <div class="container">
                            <form class="form-horizontal" action="items.php?do=Update" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
                                <input type="hidden" name="old_image" value="<?php echo $item['Image'] ?>" />
                                <input type="hidden" name="old_file" value="<?php echo $item['File'] ?>" />

                                <!-- start Name -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3">Name</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="text" name="name" class="form-control form-control-lg" autocomplete="off"
                                            required placeholder="Name off the item" value="<?php echo $item['Name'] ?>">
                                    </div>
                                </div>
                                <!-- end Name -->

                                <!-- start Description -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3">Description</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="text" name="description" class="form-control form-control-lg"
                                            placeholder="Descripe The item" required value="<?php echo $item['Description'] ?>">
                                    </div>
                                </div>
                                <!-- end Description -->

                                <!-- start price-buy -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3">Price_Buy</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="number" name="price_buy" class="form-control form-control-lg"
                                            placeholder="Price buying item" required value="<?php echo $item['price_buy'] ?>">
                                    </div>
                                </div>
                                <!-- end price-buy -->

                                <!-- start price-sale -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3">Price_Sale</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="number" name="price_sale" class="form-control form-control-lg"
                                            placeholder="Price saling item" required value="<?php echo $item['price_sale'] ?>">
                                    </div>
                                </div>
                                <!-- end price-sale -->

                                <!-- start price-deleted -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3">Price_deleting</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="number" name="price_deleting" class="form-control form-control-lg"
                                            placeholder="Price that line over throw item"
                                            value="<?php echo $item['price_deleting'] ?>">
                                    </div>
                                </div>
                                <!-- end price-deleted -->

                                <!-- start country made -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3">Country_Made</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="text" name="country" class="form-control form-control-lg"
                                            placeholder="country made item" value="<?php echo $item['Country_Made'] ?>">
                                    </div>
                                </div>
                                <!-- end country made -->

                                <!-- start hidden -->
                                <div class="row form-group">
                                    <label class="col-sm-2 h3">Visibility</label>
                                    <div class="col-sm-8 col-md-8 d-flex align-items-center "
                                        style='gap:50px ; background-color:white'>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="visible" id="visibleYes" value="0"
                                                <?php if ($item['hidden'] == 0) {
                                                    echo "checked";
                                                } ?>>
                                            <label class="form-check-label" for="visibleYes">Visible</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="visible" id="visibleNo" value="1"
                                                <?php if ($item['hidden'] == 1) {
                                                    echo "checked";
                                                } ?>>
                                            <label class="form-check-label" for="visibleNo">Hidden</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- end hidden -->

                                <!-- start category -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3">Category</label>
                                    <div class="col-sm-8 col-md-8">
                                        <select name="category" class="form-control bg-light text-dark">
                                            <?php
                                            $stmt = $con->prepare("SELECT * FROM categories ");
                                            $stmt->execute();
                                            $cats = $stmt->fetchAll();
                                            foreach ($cats as $cat) {
                                                echo "<option value='" . $cat['ID'] . "'";
                                                if ($cat["ID"] == $item["Cat_ID"]) {
                                                    echo "selected";
                                                }
                                                ;
                                                echo ">" . $cat['Name'] . "</option>";

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- end category -->

                                <!-- start image -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3">Image</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="file" name="image" class="form-control form-control-lg">
                                    </div>
                                </div>
                                <!-- end image -->

                                <!-- start file -->
                                <div class="row form-group ">
                                    <label class="col-sm-2 h3">PDF</label>
                                    <div class="col-sm-8 col-md-8">
                                        <input type="file" name="file" class="form-control form-control-lg">
                                    </div>
                                </div>
                                <!-- end file -->

                                <!-- start btn -->
                                <div class="row form-group">
                                    <label class="col-sm-2"></label>
                                    <div class="col-sm-10 ">
                                        <input type="submit" value="save item" class="btn btn-primary btn-lg ">
                                    </div>
                                </div>
                                <!-- end btn -->
                            </form>
                            <div>




                                <?php

        } else {
            echo "<div class='container pt-5'>";
            $msg = "<div class='alert alert-danger'>There No Such Id In DataBase</div>";
            redirectHome($msg, 'items.php');
            echo "</div>";
        }

    } elseif ($do == 'Update') {
        echo "<h1 class='text-center text-secondary m-5 pt-5 f-bold'>Update Page</h1>";
        echo "<div class='container'>";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Get Variables From The Form 

            $id = $_POST["itemid"];
            $name = $_POST["name"];
            $desc = $_POST["description"];
            $price_buy = $_POST["price_buy"];
            $price_sale = $_POST["price_sale"];
            $price_del = $_POST["price_deleting"];
            $country = $_POST["country"];
            $category = $_POST["category"];
            $old_image = $_POST["old_image"];
            $newImageName = null;
            $chossen_iamge = $_FILES["image"]["name"];
            $newFileName = null;
            $old_file = $_POST['old_file'];
            $visible = $_POST['visible'];

            if (!empty($_FILES["image"]["name"])) {
                // تم رفع صورة جديدة
                $realImageName = $_FILES["image"]["name"];
                $ext = pathinfo($realImageName, PATHINFO_EXTENSION);
                $newImageName = uniqid("img_") . "." . $ext;
                $tmpName = $_FILES["image"]["tmp_name"];
                $imagepath = "layout/images/items/" . basename($newImageName);
                move_uploaded_file($tmpName, $imagepath);
                if (file_exists("layout/images/items/$old_image")) {
                    unlink("layout/images/items/$old_image");
                }

            } else {
                // مفيش صورة جديدة
                $newImageName = $old_image;
            }

            if (isset($_FILES["file"]['name']) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {

                $fileRealName = $_FILES['file']['name'];
                $file_exe = pathinfo($fileRealName, PATHINFO_EXTENSION);
                $newFileName = uniqid("file_") . "." . $file_exe;
                $tempFile = $_FILES['file']['tmp_name'];
                $newFilePath = "files/offers/" . basename($newFileName);
                move_uploaded_file($tempFile, $newFilePath);
                if (!empty($old_file) && file_exists("files/offers/$old_file")) {
                    unlink("files/offers/$old_file");
                }

            } else {
                $newFileName = $old_file;
            }

            // Validate The Form

            $FormErrors = array();
            if (empty($name)) {
                $FormErrors[] = 'Item Name Cant Be Empty';
            }

            if (empty($desc)) {
                $FormErrors[] = 'Description Cant Be Empty';
            }
            if (empty($price_buy)) {
                $FormErrors[] = 'Price-buy Cant Be Empty';
            }
            if (empty($price_sale)) {
                $FormErrors[] = 'Price-buy Cant Be Empty';
            }

            foreach ($FormErrors as $error) {
                $Msg = "<div class='alert alert-danger'>" . $error . '</div>';
                echo $Msg;
                echo "<div class='btn btn-primary' style='cursor:pointer;' onclick='history.back();'>Back</div>";


            }
            if (empty($FormErrors)) {

                //  Update the database
                $stmt = $con->prepare("UPDATE items SET Name = ? , Description  = ? , price_buy = ? , price_sale = ?, price_deleting = ? ,Country_Made=?,	Cat_ID=? , Image = ? , File = ?,hidden=? WHERE item_ID = ? ");
                $stmt->execute(array($name, $desc, $price_buy, $price_sale, $price_del, $country, $category, $newImageName, $newFileName, $visible, $id));
                if ($stmt->rowCount() < 1) {
                    $Msg = "<div class='alert alert-danger'> Record Not Updated </div>";
                    redirectHome($Msg, 'items.php');

                } else {
                    $Msg = "<div class='alert alert-success'> " . $stmt->rowCount() . " Record Updated </div>";
                    redirectHome($Msg, 'items.php');

                }
            }
        } else {
            $msg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
            redirectHome($msg);
            echo "</div>";
        }
    } elseif ($do == 'Delete') {

        echo "<h1 class='text-center text-secondary m-5 pt-5 '>Delete item</h1>";
        echo "<div class='container'>";

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : '0';
        $itemimage = $_GET['img'];

        $check = CheckItem('item_ID', 'items', $itemid);

        if ($check) {

            $stmt0 = $con->prepare("SELECT * FROM items WHERE item_ID = ?");
            $stmt0->execute(array($itemid));
            $item = $stmt0->fetch();
            $itemfile = $item["File"];

            $stmt = $con->prepare("DELETE FROM items WHERE item_ID = :zitem");
            $stmt->bindparam(":zitem", $itemid);
            $stmt->execute();
            $msg = "<div class='alert alert-success'> " . $stmt->rowCount() . " item Deleted </div>";
            if (file_exists("layout/images/items/$itemimage")) {
                unlink("layout/images/items/$itemimage");
            }
            if (!empty($itemfile) && file_exists("files/offers/$itemfile")) {
                unlink("files/offers/$itemfile");
            }
            // echo $itemimage ;
            redirectHome($msg, 'items.php');


        } else {
            $msg = "<div class='alert alert-danger'>This Id Is Not Exist </div>";
            redirectHome($msg, 'items.php');
        }

        echo "</div>";

    } elseif ($do == 'trash') {

        echo "<h1 class='text-center text-secondary m-5 pt-5 '>Move to Trash </h1>";
        echo "<div class='container'>";

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : '0';

        $check = CheckItem('item_ID', 'items', $itemid);

        if ($check) {

            $stmt = $con->prepare("UPDATE items set trash = 1 WHERE item_ID=?");
            $stmt->execute(array($itemid));

            $msg = "<div class='alert alert-success'>Item Moved To Trash Successfuly </div>";
            redirectHome($msg, 'items.php');

        } else {
            $msg = "<div class='alert alert-danger'>This Id Is Not Exist </div>";
            redirectHome($msg, 'items.php');
        }

        echo "</div>";

    } elseif ($do == 'back') {

        echo "<h1 class='text-center text-secondary m-5 pt-5 '>Back From Trash </h1>";
        echo "<div class='container'>";

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : '0';


        $check = CheckItem('item_ID', 'items', $itemid);

        if ($check) {

            $stmt = $con->prepare("UPDATE items set trash = 0 WHERE item_ID=?");
            $stmt->execute(array($itemid));

            $msg = "<div class='alert alert-success'>Item Backed From Trash Successfuly </div>";
            redirectHome($msg, 'items.php');

        } else {
            $msg = "<div class='alert alert-danger'>This Id Is Not Exist </div>";
            redirectHome($msg, 'items.php');
        }

        echo "</div>";

    }

    include($tpl . 'footer.inc.php');
} else {
    header('Location:index.php');
    exit();
}
?>