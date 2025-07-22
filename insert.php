<script>
    let type = 'insert';
</script>
<?php
    include('init.php');   

        $pageTitle='Insert';


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $name    = $_POST['name'];
            $phone   = $_POST['phone'];
            $address = $_POST['address'];
            $payment = $_POST['payment'];
            $product = $_POST['product'];


            $stmt = $con->prepare("INSERT INTO orders (name, phone, address, payment_method, product_string) 
                                VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $phone, $address, $payment, $product]);
            $result=$stmt->rowcount();

            if($result>0){
                
                if($payment=='cash'){
                    header('Location:response.php?key=10');
                }elseif($payment=='instapay'){
                    header('Location:response.php?key=11');
                }
                
            }
        }
        else{
            header('Location:response.php?key=false');
        }

    include($tpl.'footer.inc.php') ;
?>


