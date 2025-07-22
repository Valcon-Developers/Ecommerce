<?php

/*
============================================
==  Title Page
============================================
*/

session_start();

if(isset($_SESSION['UsernameAdmin*&%8253'])){
    
    $pageTitle='';
    include('init.php');
    $do=isset($_GET['do'])?$_GET['do']:'Manage';

    if($do=='Manage'){
        echo "Welcom You Are in PageTile Page";
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