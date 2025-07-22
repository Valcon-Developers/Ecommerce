<script>  let type = 'insert';  </script>

<?php
    
    $NoSearchBar=true;
    include('init.php');
    $pageTitle='Insert';
    $key=$_GET['key'];

        $stmt = $con->prepare("SELECT * FROM setting LIMIT 1");
        $stmt->execute();
        $setting = $stmt->fetch();

    echo"<div class='container ' style='height:74vh'>";

        if($key=='10' || $key=='11'){

            echo "<h2 style='text-align:center;margin-top:50px' class='text-success'><i style='font-size:4rem' class ='fa h1 fa-check-circle  mt-3 '></i><strong> Order Sended Successfuly</strong> </h2>";
            echo"<div class='h2'>سيتم تاكيد الطلب معك خلال 24 ساعه</div>";
            
            if($key=='11'){

                echo"<div class='p-2 h2 mt-5'>برجاء الدفع من خلال  الرابط وارسال الايصال علي الواتساب </div>";
                echo "<strong>رابط انستا باي : <strong><a href='".$setting['insta_account']."' class='btn'><i class ='fa fa-dollar-sign text-success '></i> <i class ='fa fa-coins text-warning '></i> <i class ='fa fa-moner--billcircle text-warning '></i> instapay Acoount</a><br>";
                echo "شات الواتساب : <a href='https://wa.me/20".$setting['whatsapp_number']."' class='btn '> <i class ='fab fa-whatsapp text-success '></i> Whatsap Chat</a><br>";


            }


        }else{
            echo "<h2 style='text-align:center;margin-top:50px' class='text-danger'><i style='font-size:4rem' class ='fa h1 fa-close  mt-3 '></i><strong> Wrong Way</strong> </h2>";
        }
        
        
        echo "<div class='text-center m-4 p-5'><a href='index.php' class='btn btn-outline-primary'>Home</a></div>";
        
        
    echo'</div>';

    include($tpl.'footer.inc.php') ;
?>

<script> clear() </script> 