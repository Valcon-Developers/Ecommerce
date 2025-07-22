<?php
/*
============================================================
==  Members Page
==  You Can Add | Edit | DElete Members From Here
============================================================
*/

session_start();
if (isset($_SESSION['UsernameAdmin*&%8253'])) {

    $pageTitle = "Members";
    include('init.php');

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    $idsession=$_SESSION['ID'];
    $getstat=$con->prepare("SELECT GroupID FROM users WHERE UserID = ?");
    $getstat->execute(array($idsession));
    $stat=$getstat->fetch();
    $permission=$stat['GroupID'];
    // echo $permission;

    if ($do == 'Manage') {// Members Page 

        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID =1 ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        ?>
        <div class="container">
          <div class="row">
              <!-- العمود الأول -->
              <div class="col-lg-8  justify-content-end ">
                 <h1 class="m-3 text-secondary">Show Admins</h1>
              </div>
              <!-- العمود الثاني -->
            <div class="col-lg-4  justify-content-end ">
                <form class="row mt-4">
                <div class="m-auto" style="width:370px ; background-color: white; border-radius: 20px;border:solid 3px gray ;padding-left:5px" >
                      <label for="search"><i class="fa-solid fa-magnifying-glass text-dark"></i></label>
                      <input type="text" id="search" class="search mt-1" style="width:80%;" placeholder="Search with email only" onkeyup="getSearch()">
                      </div>
                </form>
            </div>
        </div>


        <div class="container">
            <div class="table-responsive"id="mainSection">
                <table class=" main-table table table-bordered text-center">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registerd Date</td>
                        <?php if($permission==2){?>
                        <td>Controle</td>
                        <?php } ?>
                    </tr>
                    <?php 
                        foreach($rows as $row){

                            echo "<tr class='trbox'>";
                            echo "<td>".$row['UserID']."</td>";
                            echo "<td>".$row['Username']."</td>";
                            echo "<td class='tditem'>".$row['Email']."</td>";
                            echo "<td>".$row['FullName']."</td>";
                            echo "<td>".$row['Date']."</td>";
                            if( $permission == 2 ){
                            echo "<td> 
                                        <a href='members.php?do=Edit&userid=".$row['UserID']."'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                        <a href='members.php?do=Delete&userid=".$row['UserID']."'class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>
                                 </td>";
                            }
                            echo "</td>";
                        }
     
                    ?>
                </table>
            </div>
            <a class='btn btn-primary'id="addbtn" href='members.php?do=Add'><i class="fa fa-plus"></i> New Member</a>
            <div id="hiddenSection"></div>
            
        </div>
    
     <?php 
    }elseif($do=='Add'){
        ?>

        <h1 class="text-center m-5 text-secondary">Add New Member</h1>
        <div class="container">
            <form class="form-horizontal" action="members.php?do=Insert" method="POST">
                <!-- start Username -->
                <div class="row form-group ">
                    <label class="col-sm-2 h3">User name</label>
                    <div class="col-sm-8 col-md-8">
                        <input type="text" name="username" class="form-control form-control-lg" autocomplete="off" required placeholder="User Name For Login To The Shop">
                    </div>
                </div>
                <!-- end Username -->

                <!-- start password -->
                <div class="row form-group ">
                    <label class="col-sm-2 h3">Password</label>
                    <div class="col-sm-8 col-md-8">
                      <input id='pass' type="password" name="password" class="form-control form-control-lg" autocomplete="new-password" required placeholder="Must Be Hard And Complex">
                      <i class="show-pass fa fa-eye fa-2x"onclick="togglePassword()"></i>                   
                    </div>
                </div>
                <!-- end password -->

                <!-- start email -->
                <div class="row form-group ">
                    <label class="col-sm-2 h3">Email</label>
                    <div class="col-sm-8 col-md-8">
                        <input type="email" name="email" class="form-control form-control-lg" required placeholder="Enter A Valid Email">
                    </div>
                </div>
                <!-- end email -->

                <!-- start full name -->
                <div class="row form-group ">
                    <label class="col-sm-2 h3">Full Name</label>
                    <div class="col-sm-8 col-md-8">
                        <input type="text" name="full" class="form-control form-control-lg" required placeholder="Will Appear in Your Profile Page">
                    </div>
                </div>
                <!-- end fullname -->

                <!-- start btn -->
                <div class="row form-group">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10 ">
                        <input type="submit" value="Add New Member" class="btn btn-primary btn-lg ">
                    </div>
                </div>
                <!-- end btn -->
            </form>
            <div>


                <?php

    }elseif($do=='Insert'){// Insert Member Page
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){

            echo"<h1 class='text-center text-secondary m-5 pt-5 '>Insert Page</h1>";
            echo"<div class='container'>";

            // Get Variables From The Form 
            $user      = $_POST["username"];
            $pass      = $_POST["password"];
            $email     = $_POST["email"];
            $name      = $_POST["full"];
            $hash_pass = sha1($_POST["password"]); 
            // Validate The Form
            $FormErrors=array();
            if (empty($user)) {
                $FormErrors[] = 'User Name Cant Be Empty';
            }
            if (strlen($user) < 4) {
                $FormErrors[] = 'User Name Cant Be Less Than 4 Characters';
            }
            if (strlen($user) > 20) {
                $FormErrors[] = 'User Name Cant Be More Than 20 Characters';
            }
            if (empty($pass)) {
                $FormErrors[] = 'Password Cant Be Empty';
            }
            if (strlen($pass) < 4) {
                $FormErrors[] = 'Password Cant Be Less Than 4 Characters';
            }
            if (strlen($pass) > 20) {
                $FormErrors[] = 'Password Cant Be More Than 20 Characters';
            }
            if (empty($email)) {
                $FormErrors[] = 'Email Cant Be Empty';
            }
            if (empty($name)) {
                $FormErrors[] = 'Full Name Cant Be Empty';
            }
            
            foreach ($FormErrors as $error) {
                echo "<div class='alert alert-danger'>". $error . '</div>';
            }
            if(empty($FormErrors)){

                $check= CheckItem("Username","users",$user);

                if($check){
                    $Msg= "<div class='alert alert-danger'> This Username Is Used </div>";
                    redirectHome($Msg,'back',4);
                }else{
                    //  Update the database
                    $stmt=$con->prepare("INSERT INTO users(Username, Password, Email, FullName, GroupID, Date)
                    VALUES(:zuser, :zpass, :zmail, :zname, :zgroupid , now())");
                    $stmt->execute(array(
                    'zuser' => $user,
                    'zpass' => $hash_pass,
                    'zmail' => $email,
                    'zname' => $name,
                    'zgroupid'=>1
                    ));

                    if($stmt->rowCount() < 1){
                    $Msg = "<div class='alert alert-danger'> Record Not Inserted </div>";
                    redirectHome($Msg,'back',4);
                    }else{
                    $msg="<div class='alert alert-success'>".$stmt->rowCount()." Record Inserted </div>";
                    redirectHome($msg,'members.php');
                    }
                }
               
            }
        }else{
            echo"<div class='container'>'";
            $errorMsg ="<div class='alert alert-danger'> Sorry You Cant Browse This Page Directly </div>";
            redirectHome($errorMsg);
            echo"</div>";
        }
        echo "</div>";
    

    } elseif ($do == 'Edit') { // Edite Page 
    
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : '0';
        // echo $userid;

        $stmt = $con->prepare(" SELECT * FROM users WHERE UserID = ? LIMIT 1 ");
        $stmt->execute(array($userid));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            

               
            ?>

            <h1 class="text-center m-5 text-secondary">Edit Member</h1>
            <div class="container">
                <form class="form-horizontal" action="members.php?do=Update" method="POST">
                <input type="hidden" name="userid" value="<?php echo $userid ?>">
                    <!-- start Username -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">User name</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="text" name="username" class="form-control form-control-lg" autocomplete="off" value="<?php echo $row['Username']?> " required>
                        </div>
                    </div>
                    <!-- end Username -->

                    <!-- start password -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Password</label>
                        <div class="col-sm-8 col-md-8">
                            <input id="pass" type="password" name="NewPassword" class="form-control form-control-lg" autocomplete="new-password">
                            <input type="hidden" name="OldPassword" value="<?php echo $row['Password']?>">
                            <i class="show-pass fa fa-eye fa-2x"onclick="togglePassword()"></i>                   
                        </div>
                    </div>
                    <!-- end password -->

                    <!-- start email -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Email</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="email" name="email" class="form-control form-control-lg"value="<?php echo $row['Email']?>"required>
                        </div>
                    </div>
                    <!-- end email -->

                    <!-- start full name -->
                    <div class="row form-group ">
                        <label class="col-sm-2 h3">Full Name</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="text" name="full" class="form-control form-control-lg"value="<?php echo $row['FullName']?>" required>
                        </div>
                    </div>
                    <!-- end fullname -->

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
            echo"<div class='container pt-5'>";
            $msg= "<div class='alert alert-danger'>There No Such Id In DataBase</div>";
            redirectHome($msg,'back');
            echo"</div>";
        }
    } elseif ($do == 'Update') {  // Update Page

        echo"<h1 class='text-center text-secondary m-5 pt-5 f-bold'>Update Page</h1>";
        echo"<div class='container'>";

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            // Get Variables From The Form 
            $id    = $_POST["userid"];
            $user  = $_POST["username"];
            $email = $_POST["email"];
            $name  = $_POST["full"];
            //password trick            
            $pass=empty($_POST['NewPassword'])?$_POST["OldPassword"]:sha1($_POST["NewPassword"]);
            // Validate The Form
            $FormErrors=array();
            if (empty($user)) {
                $FormErrors[] = 'User Name Cant Be Empty';
            }
            if (strlen($user) < 4) {
                $FormErrors[] = 'User Name Cant Be Less Than 4 Characters';
            }
            if (strlen($user) > 20) {
                $FormErrors[] = 'User Name Cant Be More Than 20 Characters';
            }
            if (empty($email)) {
                $FormErrors[] = 'Email Cant Be Empty';
            }
            if (empty($name)) {
                $FormErrors[] = 'Full Name Cant Be Empty';
            }
            
            foreach ($FormErrors as $error) {
                $Msg= "<div class='alert alert-danger'>". $error . '</div>';
                redirectHome($Msg,'back');
            
            }
            if(empty($FormErrors)){

                //  Update the database
                $stmt=$con->prepare("UPDATE users SET Username = ? , Email = ? , FullName = ? , Password = ? WHERE UserID = ? ");
                $stmt->execute(array( $user ,$email,$name,$pass,$id));
                if($stmt->rowCount() < 1){
                    $Msg= "<div class='alert alert-danger'> Record Not Updated </div>";
                    redirectHome($Msg,'members.php');

                }else{
                    $Msg= "<div class='alert alert-success'> ".$stmt->rowCount()." Record Updated </div>";
                    redirectHome($Msg,'members.php');

                }
            }
        }else{
            $msg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
            redirectHome($msg);
            echo "</div>";
        }
    }elseif($do=='Delete'){

        echo"<h1 class='text-center text-secondary m-5 pt-5 '>Delete Page</h1>";
        echo"<div class='container'>";

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : '0';

            $check=CheckItem('userid','users',$userid);

            if ($check) {
                $stmt =$con->prepare("DELETE FROM users WHERE UserID = :zuser");
                $stmt->bindparam(":zuser",$userid);
                $stmt->execute();
                $msg="<div class='alert alert-success'> ".$stmt->rowCount()." Record Deleted </div>";
                redirectHome($msg ,'back');
            }else{
                $msg="<div class='alert alert-danger'>This Id Is Not Exist </div>";
                redirectHome($msg,'back');
            }
        
        echo"</div>";
    

    
    }   
    
    include($tpl . 'footer.inc.php');

} else {
    header('Location: index.php');
    exit();
}

