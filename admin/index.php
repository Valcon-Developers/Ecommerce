<?php
    session_start();

    if(isset($_SESSION['UsernameAdmin*&%8253'])){
        header('Location: dashboard.php');
        exit(); 
    } 
    
    $nonavbar='';
    $pageTitle="Login";

    include('init.php');

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedpass = sha1($password);

        $stmt = $con->prepare(" SELECT UserID,Username, Password FROM users WHERE Username = ? AND Password = ? AND	GroupID > 0 LIMIT 1 ");
        $stmt->execute(array($username , $hashedpass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if($count > 0){
   
            $_SESSION['UsernameAdmin*&%8253'] =$username;
            $_SESSION['ID']=$row['UserID'];
            header('Location: dashboard.php');
            exit();

    
        }else{
            $error= '<h5 style=" width:300px;" class=" container alert alert-danger text-center mt-3"> Invalid username or password</h5>';
        }
    }
?>
<form class='login'  action = "<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center mb-4">Admin Login</h4>
    <input class="form-control" type="text" name='user' value="<?php if(isset($username)){ echo $username ;} ?>" placeholder="Username" autocomplete="off" required/>
    <input id="pass" class="form-control" type="password"value="<?php if(isset($password)){echo $password;} ?>" name='pass' placeholder="Password" autocomplete="new-password" required/>
    <i class="show-pass-index fa fa-eye"onclick="togglePassword()"></i>                   
    <input type="submit" class="btn btn-primary btn-block" value="login">
    <?php if(isset($error)){echo $error;} ?>
</form>


<?php include($tpl.'footer.inc.php') ; ?>