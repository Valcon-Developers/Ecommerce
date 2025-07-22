<?php
session_start();

if(isset($_SESSION['UsernameAdmin*&%8253'])){
    
    $pageTitle='Statistics';
    include('init.php');
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    $stmt = $con->prepare("SELECT * FROM orders WHERE done = 1 ORDER BY id DESC");
    $stmt->execute();
    $orders = $stmt->fetchAll();
    if($do=='Manage'){ ?>

       <div class='container mt-5 p-3'>
  <div class='row justify-content-center'>

    <!-- اجمالي الطلبات الجديدة -->
    <div class="col-12 col-md-6 col-lg-5 p-2">
      <a href="?do=Amount" class='btn btn-primary w-100 text-center py-4'>
        <i class='fa fa-truck-ramp-box' style='font-size:2rem'></i>
        <br>
        <span style='font-size:1.5rem'>اجمالي الطلبات الجديدة</span>
      </a>
    </div>

    <!-- تم التسليم -->
    <div class="col-12 col-md-6 col-lg-5 p-2">
      <a href="?do=done" class='btn btn-success w-100 text-light text-center py-4'>
        <i class='fa fa-check-circle text-warning' style='font-size:2rem'></i>
        <br> 
        <span style='font-size:1.5rem'>تم التسليم</span>
      </a>
    </div>

    <!-- عرض الحسابات -->
    <div class="col-12 col-md-6 col-lg-5 p-2">
      <a href="?do=money" class='btn bg-secondary text-light w-100 text-center py-4'>
        <i class='fa fa-dollar-sign text-warning' style='font-size:2rem'></i>
        <i class='fa fa-coins text-warning' style='font-size:2rem'></i>
        <br> 
        <span style='font-size:1.5rem'>عرض الحسابات</span>
      </a>
    </div>

    <!-- عرض الأرشيف -->
    <div class="col-12 col-md-6 col-lg-5 p-2">
      <a href="?do=Archived" class='btn btn-info w-100 text-center py-4'>
        <i class="fa-solid fa-box-archive text-warning" style='font-size:2rem'></i> 
        <i class="fa-solid fa-folder text-warning" style='font-size:2rem'></i>
        <br> 
        <span style='font-size:1.5rem'>عرض الأرشيف</span>
      </a>
    </div>

  </div>
</div>

        
    <?php
    }elseif($do=="Amount"){
        $totalAmount=[];
        $stmt2=$con->prepare("SELECT product_string FROM orders WHERE done=0");
        $stmt2->execute();
        $result=$stmt2->fetchAll();
        if($result){
            
            foreach($result as $oneorder){
                
                $order=parseOrder($oneorder['product_string']);

                foreach($order as $item){

                    $id=$item['id'];
                    
                    $qty=$item['qty'];

                    if(!isset($totalAmount[$id])){
                        $stmt3=$con->prepare("SELECT Name FROM items WHERE item_ID=?");
                        $stmt3->execute([$id]);
                        $info=$stmt3->fetch();

                        $totalAmount[$id]=[
                            "name" => $info['Name'],
                            "qty" => 0
                        ];
                    }
                    $totalAmount[$id]['qty']+=$qty;

                }
            }
                echo "<div class='container'>";
                        ?> <button onclick="window.print()" class="btn btn-primary mt-5"> print </button> <?php

                    echo "<h2 style='text-align:center;'> اجمالي الطلبات</h2>";
                    echo "<table border='1' cellpadding='10' cellspacing='0' style='width:100%; text-align:center;'>";
                    echo "<tr style='background-color:#f2f2f2; font-weight:bold;'>
                            <td class='bg-primary'>ID</td>
                            <td class='bg-primary'>Name</td>
                            <td class='bg-primary'>Qty</td>
                            
                        </tr>";
                    $bg='bg-info';
                    foreach($totalAmount as $id=> $product){
                        echo "<tr style='background-color:#f2f2f2; font-weight:bold;'>
                            <td class='$bg'>$id</td>
                            <td class='$bg'>{$product['name']}</td>
                            <td class='$bg'>{$product['qty']}</td>    
                        </tr>";
                        if($bg=='bg-info'){

                            $bg='bg-secondary';
                        }else{
                            $bg='bg-info';
                        }
                    }
                    
                echo"</div>";

        }



    }elseif($do == 'money'){ 
        $all_products = []; // سيتم تجميع المنتجات هنا

        foreach($orders as $order){
            $items = parseOrder($order['product_string']);

            foreach($items as $item){
                $id = $item['id'];
                $name = $item['name'];
                $qty = $item['qty'];

                if(!isset($all_products[$id])){
                    // جلب بيانات المنتج من قاعدة البيانات
                    $stmt = $con->prepare("SELECT Name, price_buy, price_sale FROM items WHERE item_ID = ?");
                    $stmt->execute([$id]);
                    $productData = $stmt->fetch();

                    if($productData){
                        $all_products[$id] = [
                            'name' => $productData['Name'],
                            'qty' => 0,
                            'price_buy' => $productData['price_buy'],
                            'price_sale' => $productData['price_sale']
                        ];
                    } else {
                        // في حالة عدم وجود المنتج في قاعدة البيانات
                        $all_products[$id] = [
                            'name' => $name,
                            'qty' => 0,
                            'price_buy' => 0,
                            'price_sale' => 0
                        ];
                    }
                }

                $all_products[$id]['qty'] += $qty;
            }
        }

        // عرض جدول الإحصائيات
        echo"<div class='container'>";
        ?> <button onclick="window.print()" class="btn btn-primary  mt-5"> print </button> <?php
        echo "<h2 style='text-align:center;'>إحصائيات المبيعات</h2>";
        echo "<table table-responsive border='1' cellpadding='10' cellspacing='0' style='width:100%; text-align:center;'>";
        echo "<tr style='background-color:#f2f2f2; font-weight:bold;'>
                <td>ID</td>
                <td>Name</td>
                <td>Qty</td>
                <td>Buy Price</td>
                <td>Sell Price</td>
                <td>Total Buy</td>
                <td>Total Sell</td>
                <td>Profit</td>
              </tr>";

        $total_buy = 0;
        $total_sell = 0;
        $total_profit = 0;

        foreach($all_products as $id => $product){
            $qty = $product['qty'];
            $buy_total = $product['price_buy'] * $qty;
            $sell_total = $product['price_sale'] * $qty;
            $profit = $sell_total - $buy_total;

            $total_buy += $buy_total;
            $total_sell += $sell_total;
            $total_profit += $profit;

            echo "<tr>
                    <td>$id</td>
                    <td>{$product['name']}</td>
                    <td>$qty</td>
                    <td>{$product['price_buy']}</td>
                    <td>{$product['price_sale']}</td>
                    <td>$buy_total</td>
                    <td>$sell_total</td>
                    <td>$profit</td>
                  </tr>";
        }

        echo "<tr style='font-weight:bold; background-color:#dff0d8;'>
                <td colspan='5'>الإجمالي</td>
                <td>$total_buy</td>
                <td>$total_sell</td>
                <td>$total_profit</td>
              </tr>";

        echo "</table>";
    }elseif($do=='done'){
        header('location:orders.php?x=done');
    }
    elseif($do=='Archived'){
        header('location:orders.php?x=archive');
    }
    include($tpl.'footer.inc.php');
} else {
    header('Location:index.php');
    exit();
}
?>
