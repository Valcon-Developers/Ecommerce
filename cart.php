<?php
    $pageTitle = "cart";
    $NoSearchBar = true;
    include('init.php');
?>



<div class="container">

    <div class='row'>
        
        <div class="col-lg-6 col-md-12 col-sm-12 main-container " >
            <h2 class="pl-4">Your Shopping Cart</h2>
            <div id="cart-items" style='width:90%'></div>
        </div>



            <div class="pill col-lg-6 col-md-12 col-sm-12 text-dark m-0 pb-2 " style="border-radius: 20px; border:solid black 2px">
                   <p class=" text-light text-center mt-3    badge bg-info" style=" background-color: green;  font-size: 2em; " id="total"></p>
                   <h5 class="badge bg-info text-light" >غير شامل مصاريف الشحن</h5> 
                   
                   <form action="insert.php" method="post"id="myForm"  >

                    <label for="name" class="h4 ">Name :</label>
                    <br>
                    <input type="text"   name="name"  id="name" placeholder="Full Name"    class="form-control" required >
                    <br>

                    <label for="phone"class="h4">Phone</label>
                    <br>
                    <input type="number" name="phone" id="phone" placeholder="Phone Number" class="form-control" required>
                    <br>

                    <label for="address" class="h4">Address</label>
                    <br>
                    <input type="text" name="address" id="address" placeholder="Your Address" class="form-control" required>  
                    <br>

                    <input type="text" style='display:none' name="product" id="Products_input_names" class="form-control" required></input>
                    <div class="form-group mt-3">
                    <label class="h4">اختر طريقة الدفع:</label><br>

                    <input type="radio" name="payment" id="cash" value="cash" checked>
                    <label for="cash">الدفع عند الاستلام</label><br>

                    <input type="radio" name="payment" id="instapay" value="instapay" data-toggle="modal" data-target="#instapayModal">
                    <label for="instapay">Instapay</label>
                    </div>

                    <br>                    
                    <input type="submit" value="Order Now" class="form-control btn btn-warning" style=" font-size: 1.4em; font-weight: bold; border-radius: 20px;">
                   </form>
            </div>


        </div>
    </div>
</div>
        
<script> let cartContainer = document.getElementById('cart-items');
            let type='cart';
</script>


<?php 
   include($tpl.'footer.inc.php'); 
?>

<script>
    getnames();
</script>