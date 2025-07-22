<?php

/*
============================================
==  Title Page
============================================
*/

session_start();

if(isset($_SESSION['UsernameAdmin*&%8253'])){
    
    $pageTitle='Orders Managment';
    include('init.php');
    $do=isset($_GET['do'])?$_GET['do']:'Manage';
    $x=isset($_GET['x'])?$_GET['x']:"all";
    $id=isset($_GET['id'])&&is_numeric($_GET['id'])?$_GET['id']:0;    
    $title='order';
    $quary='';
    if($x=='all'){
        $quary="SELECT * FROM orders WHERE done = 0  ORDER BY id DESC";
        $title="الطلبات";

    }elseif($x=='confirm'){
        $quary="SELECT * FROM orders WHERE confirm = 0 AND done = 0  ORDER BY id DESC";
        $title="طلبات لم يتم تأكيدها";
    }elseif($x=='inway'){
        $quary="SELECT * FROM orders WHERE confirm = 1 AND done = 0  ORDER BY id DESC";
        $title='طلبات تحت التحضير';

    }elseif($x=='done'){
        $quary="SELECT * FROM orders WHERE done = 1  ORDER BY id DESC";
        $title="طلبات تم تسليمها";
    }elseif($x=='archive'){
        $quary="SELECT * FROM orders WHERE done = 2  ORDER BY id DESC";
        $title='طلبات مؤرشفة';
    }elseif($x='pill'){

        $quary="SELECT * FROM orders WHERE id = $id  ORDER BY id DESC";

    }else{
        $quary='';
        $title='لا توجد معلومات';
    }

  
    // $stmt = $con->prepare("SELECT * FROM orders WHERE $x = ? ORDER BY id DESC");
    // $stmt->execute([$val]);

    $stmt = $con->prepare($quary);
    $stmt->execute();

    $orders = $stmt->fetchAll();

    if($do=='Manage'){ ?>
       
        <div class="container mt-5">
            <div class='d-flex'>
                <h2 class="mb-4"><?php echo $title ?></h2>
                <?php if($x=='done'){?>
                <div class='ml-auto'>
                    <a href='?do=archive' class='btn btn-info'>Archive All</a>
                </div>
                <?php } ?>
            </div>
            <?php 
            $i=0;
            foreach ($orders as $order): ?>
              <div class='pill' class='<?php echo $item['id'] ?>'>
                    <div class="card mb-4 ">
                        

                        <div class="card-header bg-dark text-white row text-warning" style="margin-left:1px;margin-right:1px">
                            <div class='col-lg-4 col-md-6 col-sm-12 '><?php echo " order number : <span class='text-light'>". $order['id'].'<span>'; ?></div>
                            <div class='col-lg-4 col-md-6 col-sm-12 '><?php echo " Name : <span class='text-light'>". $order['name'].'<span>'; ?></div>
                            <div class='col-lg-4 col-md-6 col-sm-12'><?php echo"Phone :  <a href='https://wa.me/20".$order['phone']."' target='_blank'>".$order['phone']."</a> "?></div>
                            <div class='col-lg-4 col-md-6 col-sm-12'><?php echo"Address : <span class='text-light'> ". $order['address']."</span>"; ?></div> 
                            <div class='col-lg-4 col-md-6 col-sm-12'><?php echo 'payment : <span class="text-light">'. $order['payment_method']."</span>"; ?></div>
                            <div class='col-lg-4 col-md-6 col-sm-12'><?php echo 'time : <span class="text-light">'. $order['created_at']."</span>"; ?></div>
                       
                            <?php if(isset($_GET['x']) && $_GET['x']=='pill'){ ?>

                                <button onclick="printPart('<?php echo addslashes($order['name']); ?>')" class="pillControles btn btn-primary ml-auto">print</button>

                                
                            <?php }else{ ?>
                            
                                <a href='orders.php?x=pill&id=<?php echo $order['id']?>'  class="pillControles btn btn-primary ml-auto">pill</a>
                            
                            <?php } ?>

                        </div>
                        <?php   
                                    echo "<div  class='pillControles full-view m-0'>";
                                            if($order['confirm']==1){ echo '<span class="badge badge-primary p-2 m-1"><i class ="fa fa-check-circle"></i></span>';};
                                            if($order['payment']==1){ echo '<span class="badge badge-success p-2 m-1"><i class="fa fa-dollar-sign"></i> <i class="fa fa-money-bill-wave"></i> </span>';};
                                            if($order['prepared']==1){ echo '<span class="badge badge-warning p-2 m-1"><i class="fa fa-bus"></i> In Way</span>';};
                                        echo"</div>";
                        ?>
                        <div class="card-body">
                            <table class=" table  table-bordered ">
                                <thead>
                                    <tr>
                                        <th>product</th>
                                        <th>quntity</th>
                                        <th>price</th>
                                        <th>total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $totalProfit = 0;
                                        $totalSell = 0;
                                        $items = parseOrder($order['product_string']);
                                        // echo'<pre>';
                                        // print_r($items);
                                        // echo'</pre>';
                                        foreach ($items as $item) {
                                            $stmt = $con->prepare("SELECT  price_sale FROM items WHERE item_ID = ?");
                                            $stmt->execute([$item['id']]);
                                            $product = $stmt->fetch();

                                            if ($product) {
                                                $sell = $product['price_sale'];
                                                $qty = $item['qty'];
                                                $total = $sell * $qty;
                                                $totalSell += $total;

                                                echo "<tr>
                                                    <td>{$item['name']}</td>
                                                    <td>{$qty}</td>
                                                    <td>{$sell}</td>
                                                    <td>{$total}</td>
                                                    </tr>";
                                            } else {
                                                echo "<tr class='text-danger'><td colspan='6'>منتج غير موجود: {$item['name']} (ID: {$item['id']})</td></tr>";
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>

                            <div class="text-end mt-3 d-flex">
                                <div class=" text=light d-flex h4">
                                <div class="pr-1">Total Order :  </div ><p> <?php echo " ". $totalSell; ?> EGP </p><br>
                                </div>
                                <div  class="pillControles text-end ml-auto">
                                    <a href="?do=Edit&id=<?php echo $order['id']; ?>&x=<?php echo $x ?>" class="btn btn-sm btn-primary">تعديل</a>
                                    <a href="?do=Delete&id=<?php echo $order['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من الحذف؟');">حذف</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            

            <?php $i++ ; endforeach; ?>


        </div> <?php

    }elseif($do=='Edit'){

        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

        $stmt = $con->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        $order = $stmt->fetch();

     if ($order) {
        $items = parseOrder($order['product_string']);
        ?>
     <div class="container mt-5">
        <h3>تعديل الطلب</h3>
        <form action="?do=Update&id=<?php echo $id; ?>" method="POST">

            <!-- بيانات العميل -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>الاسم</label>
                    <input type="text" name="customer_name" class="form-control" value="<?php echo $order['name']; ?>">
                </div>
                <div class="col-md-4">
                    <label>العنوان</label>
                    <input type="text" name="customer_address" class="form-control" value="<?php echo $order['address']; ?>">
                </div>
                <div class="col-md-4">
                    <label>رقم الهاتف</label>
                    <input type="text" name="customer_phone" class="form-control" value="<?php echo $order['phone']; ?>">
                </div>

            </div>

            <!-- المنتجات الحالية -->
            <?php foreach ($items as $index => $item): ?>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label>اسم المنتج</label>
                        <input type="text" name="items[<?php echo $index; ?>][name]" class="form-control" value="<?php echo $item['name']; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>الكمية</label>
                        <input type="number" name="items[<?php echo $index; ?>][qty]" class="form-control" value="<?php echo $item['qty']; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>ID</label>
                        <input type="number" name="items[<?php echo $index; ?>][id]" class="form-control" readonly value="<?php echo $item['id']; ?>">
                    </div>
                </div>
            <?php endforeach; 
            
            $stmt2=$con->prepare("SELECT item_ID , Name FROM items");
            $stmt2->execute();
            $items = $stmt2->fetchAll();

            ?>

            <!-- منتج جديد -->
            <hr>
            <h5>إضافة منتج جديد (اختياري)</h5>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>اسم المنتج الجديد</label>
                   <select class='w-100' style='height:40px' name="newitem" id="new">
                        
                        <option></option>
                    
                    <?php foreach($items as $item){?>
                        <option  value="<?php echo $item['item_ID'].'->'. $item['Name']?>"><?php echo $item['Name']?></option>
                        <?php $itemid= $item['item_ID'] ?>
                    <?php };  ?>
                   </select>
                </div>
                <div class="col-md-3">
                    <label>الكمية</label>
                    <input type="number" name="newqty" value="0" class="form-control">
                </div>
            </div>
                        <!-- start Confirm-->
                        <div class="row form-group ">
                            <label class="col-sm-2 h3">تاكيد الطلب</label>
                            <div class="col-sm-8 col-md-8">
                                <div>
                                    <input id="conf-yes" type="radio" name="confirm" value="1" <?php if($order['confirm']==1){echo 'checked';}?> /> 
                                    <label for="conf-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="conf-no" type="radio" name="confirm" value="0" <?php if($order['confirm']==0){echo 'checked';}?>/> 
                                    <label for="conf-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- end Confirm -->
                        <!-- start Confirm-->
                        <div class="row form-group ">
                            <label class="col-sm-2 h3">تم الدفع</label>
                            <div class="col-sm-8 col-md-8">
                                <div>
                                    <input id="com-yes" type="radio" name="payment" value="1" <?php if($order['payment']==1){echo 'checked';}?> /> 
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="payment" value="0" <?php if($order['payment']==0){echo 'checked';}?>/> 
                                    <label for="com-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- end Confirm -->

                        <!-- start Confirm-->
                        <div class="row form-group ">
                            <label class="col-sm-2 h3">شركه الشحن</label>
                            <div class="col-sm-8 col-md-8">
                                <div>
                                    <input id="con-yes" type="radio" name="prepared" value="1" <?php if($order['prepared']==1){echo 'checked';}?> /> 
                                    <label for="con-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="con-no" type="radio" name="prepared" value="0" <?php if($order['prepared']==0){echo 'checked';}?>/> 
                                    <label for="con-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!-- end Confirm -->

                        <!-- start Confirm-->
                        <div class="row form-group ">
                            <label class="col-sm-2 h3">حالة الطلب </label>
                            <div class="col-sm-8 col-md-8">
                                
                                <div>
                                    <input id="arch-no" type="radio" name="done" value="0" <?php if($order['done']==0){echo 'checked';}?>/> 
                                    <label for="arch-no">لم يتم التسليم بعد</label>
                                </div>
                                
                                <div>
                                    <input id="arch-yes" type="radio" name="done" value="1" <?php if($order['done']==1){echo 'checked';}?> /> 
                                    <label for="arch-yes">تم التسليم </label>
                                </div>

                                <div id='archive'>
                                    <input id="arch" type="radio" name="done" value="2" <?php if($order['done']==2){echo 'checked';}?>/> 
                                    <label for="arch">أرشفة الطلب</label>
                                </div>

                            </div>
                        </div>
                        <!-- end Confirm -->
                        
                        
                          <?php 
                            $x=$_GET['x']; 
                            
                            if($x=='done' OR  $x=='archive'){ ?>
                        <script>
                            $Archived=document.getElementById('archive');
                            $Archived.style.display='block'
                        </script>
                        <?php } ?>
                         
            <button type="submit" class="btn btn-success mt-3">حفظ التعديلات</button>
        </form>
        </div>
            <?php
        } else {
            echo "<div class='alert alert-danger'>الطلب غير موجود</div>";
        }

        
    }elseif($do=='Update'){

        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name=$_POST['customer_name'];
        $phone=$_POST['customer_phone'];
        $address=$_POST['customer_address'];
        $items = $_POST['items'];
        $newitem=$_POST['newitem'];
        $newqty=$_POST['newqty'];  
        $confirm=$_POST['confirm'];
        $payment=$_POST['payment'];
        $prepared=$_POST['prepared'];
        $done=$_POST['done'];
        
       
              
        $product_string = '';

        foreach ($items as $item) {
            $product_string .= "{$item['id']}->{$item['name']}=>{$item['qty']};";
        }
        if($newitem !=''){

            $product_string.="$newitem=>$newqty";
        }
        $product_string = rtrim($product_string, ';');
         
        
        $stmt = $con->prepare("UPDATE orders SET 
                                                 name = ? ,
                                                 phone = ? ,
                                                 address = ? ,
                                                 product_string = ? ,
                                                 confirm = ? ,
                                                 payment = ? ,
                                                 prepared = ? , 
                                                 done = ? 
                                                    WHERE id = ?");
        $stmt->execute([$name,$phone,$address,$product_string,$confirm,$payment,$prepared,$done,$id]);

        echo "<div class='mt-5 text-center container alert alert-success'>تم تعديل الطلب بنجاح</div>";
        header("refresh:2; url=orders.php");
        exit();
     }

    }elseif($do=='Delete'){

        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

        $stmt = $con->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$id]);

        header('Location: orders.php');
        exit();

        
    }elseif($do=='archive'){
        $stmt3=$con->prepare("UPDATE orders SET done = 2 WHERE done = 1;");
        $stmt3->execute();
    }

    include($tpl.'footer.inc.php');
}else{
    header('Location:index.php');
    exit();
}
?>

