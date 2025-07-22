<?php
# condition ? true : false
$do  =  isset($_GET['do'])  ?  $_GET['do']  :  'Manage'  ;


########################################
if($do =='Manage'){
    echo "Welcom You Are In Manage Category Page";
    echo "<br>";
    echo "<a href='?do=Add'>Add New Section</a>";
}elseif($do == 'Add'){
    echo "Welcom You Are In Add Category Page";
}elseif($do == 'Insert'){
    echo "Welcom You Are In Insert Category Page";
}else{
    echo "Error  Tere Is No Page With This Name";
}

?>