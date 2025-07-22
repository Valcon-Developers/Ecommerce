<?php

/*
============================================
==  setting Page
============================================
*/

session_start();

if (isset($_SESSION['UsernameAdmin*&%8253'])) {
    $pageTitle = 'setting';
    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        // Fetch current setting from database
        $stmt = $con->prepare("SELECT * FROM setting LIMIT 1");
        $stmt->execute();
        $setting = $stmt->fetch();
        ?>
        <div class="container my-4 ">
            <h1 class="text-center text-secondary"><i class="fa-solid fa-gears"></i> Website setting</h1>
            <form action="?do=Update" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Phone_1</label>
                    <input type="text" name="phone_1" class="form-control" value="<?= $setting['phone_1'] ?>">
                </div>
                <div class="form-group">        
                    <label>Phone 2</label>
                    <input type="text" name="phone_2" class="form-control" value="<?= $setting['phone_2'] ?>">
                </div>
                <div class="form-group">
                    <label>Telegram Link</label>
                    <input type="text" name="telegram" class="form-control" value="<?= $setting['telegram'] ?>">
                </div>
                <div class="form-group">
                    <label>Facebook Link</label>
                    <input type="text" name="facebook" class="form-control" value="<?= $setting['facebook'] ?>">
                </div>
                <div class="form-group">
                    <label>Instagram Link</label>
                    <input type="text" name="instagram" class="form-control" value="<?= $setting['instagram'] ?>">
                </div>
                <div class="form-group">
                    <label>WhatsApp Group</label>
                    <input type="text" name="whatsapp_group" class="form-control" value="<?= $setting['whatsapp_group'] ?>">
                </div>
                <div class="form-group">
                    <label>WhatsApp Number</label>
                    <input type="text" name="whatsapp_number" class="form-control" value="<?= $setting['whatsapp_number'] ?>">
                </div>
                <div class="form-group">
                    <label>YouTube Link</label>
                    <input type="text" name="youtube" class="form-control" value="<?= $setting['youtube'] ?>">
                </div>
                <div class="form-group">
                    <label>Instagram Account</label>
                    <input type="text" name="insta_account" class="form-control" value="<?= $setting['insta_account'] ?>">
                </div>
                <button type="submit" class="btn btn-primary w-100">Set</button>
            </form>
        </div>
        <?php

    } elseif ($do == 'Update') {
        // Handle form submission and update database
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get previous image names from database
            $stmt = $con->prepare("SELECT * FROM setting LIMIT 1");
            $stmt->execute();
            $old = $stmt->fetch();
            $phone_1 = $_POST['phone_1'];
            $phone_2 = $_POST['phone_2'];
            $telegram = $_POST['telegram'];
            $facebook = $_POST['facebook'];
            $instagram = $_POST['instagram'];
            $whatsapp_group = $_POST['whatsapp_group'];
            $whatsapp_number = $_POST['whatsapp_number'];
            $youtube = $_POST['youtube'];
            $insta_account = $_POST['insta_account'];

            // Background phone image
            if ($_FILES['bg_phone']['name']) {
                $bg_phone = time() . '_phone_' . $_FILES['bg_phone']['name'];
                move_uploaded_file($_FILES['bg_phone']['tmp_name'], "files/layout/$bg_phone");
            } else {
                $bg_phone = $old['bg_phone'];
            }

            // Background desktop image
            if ($_FILES['bg_desktop']['name']) {
                $bg_desktop = time() . '_desktop_' . $_FILES['bg_desktop']['name'];
                move_uploaded_file($_FILES['bg_desktop']['tmp_name'], "files/layout/$bg_desktop");
            } else {
                $bg_desktop = $old['bg_desktop'];
            }

            $stmt = $con->prepare("UPDATE setting SET phone_1 = ? , phone_2 = ? , telegram=?, facebook=?, instagram=?, whatsapp_group=?, whatsapp_number=?, youtube=?, insta_account=?, bg_phone=?, bg_desktop=?");
            $stmt->execute([$phone_1,$phone_2,$telegram, $facebook, $instagram, $whatsapp_group, $whatsapp_number, $youtube, $insta_account, $bg_phone, $bg_desktop]);

            echo "<div class='container mt-5 text-center alert alert-success'>Setting Updated Successfully</div>";
            header("refresh:2; url=?do=Manage");
            exit();
        }
    }

    include($tpl . 'footer.inc.php');

} else {
    header('Location:index.php');
    exit();
}
?>


