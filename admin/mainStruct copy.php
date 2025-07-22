<?php

/*
============================================
== Learn Page
============================================
*/

session_start();

if(isset($_SESSION['UsernameAdmin*&%8253'])){
    
    $pageTitle='Learning';
    include('init.php');
    $do=isset($_GET['do'])?$_GET['do']:'Manage';

    if($do=='Manage'){

    }elseif($do=='Add'){

    }elseif($do=='Insert'){
        
    }elseif($do=='Edit'){
        
    }elseif($do=='Update'){
        
    }elseif($do=='Delete'){
        
    }

    include($tpl.'footer.inc.php');
}else{
    header('Location:index.php');
    exit();
}
?>