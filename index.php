<?php
session_start();
$pageTitle = "Home";

include('init.php');


$stmt = $con->prepare("SELECT * FROM items where hidden = 0 AND trash = 0");
$stmt->execute();
$products = $stmt->fetchAll();

$stmt3 = $con->prepare("SELECT ID, Name FROM categories");
$stmt3->execute();
$categories = $stmt3->fetchAll();


$stmt2 = $con->prepare("SELECT * FROM setting LIMIT 1");
$stmt2->execute();
$setting = $stmt2->fetch();


?>


<section class="hero" id='hero'>
  <div class="content mt-5">
    <!-- <h1 class='text-bold text-info'>WELCOM IN TOOTH STORE</h1>
    <h2 class='text-bold  text-info'>SAVE YOUR TIME</h2> -->
    <!-- روابط السوشيال ميديا -->
    <div class=" h2 social-icons mt-5 pt-5">
      <!-- WhatsApp -->
      <a href="<?php echo $setting['whatsapp_group'] ?>" target="_blank" class="whatsapp">
        <i class="fab fa-whatsapp text-success"></i>
      </a>
      <!-- Facebook -->
      <a href="<?php echo $setting['facebook'] ?>" target="_blank" class="facebook">
        <i class="fab fa-facebook-f text-primary"></i>
      </a>
      <!-- YouTube -->
      <a href="<?php echo $setting['youtube'] ?>" target="_blank" class="youtube">
        <i class="fab fa-youtube text-danger"></i>
      </a>
      <!-- Telegram -->
      <a href="<?php echo $setting['telegram'] ?>" target="_blank" class="telegram">
        <i class="fab fa-telegram-plane text-info"></i>
      </a>
      <!-- instgram -->
      <a href="<?php echo $setting['instagram'] ?>" target="_blank" class="instagram">
        <img src="layout/images/instagram_PNG9.png" width='33px' alt="">
      </a>


    </div>
    <a href="#category" class="btn btn-primary">Start Now</a>
  </div>
</section>



<!-- Start categories -->

<div class="container d-flex my-5 pb-3 category" id='category'>
  <button class="btn btn-outline-primary b-pill mx-3 category-btn active" data-id="all">كل المنتجات</button>

  <?php foreach ($categories as $category): ?>
    <button class="btn btn-outline-primary b-pill mx-3 category-btn" data-id="<?= $category['ID'] ?>">
      <?= $category['Name'] ?>
    </button>
  <?php endforeach; ?>
</div>



<!-- End categories -->


<!-- start products -->

<div class="container" id="tools">
  <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;" id="products">
    <?php foreach ($products as $product): ?>
      <div class="card text-dark card-product search-card mt-1 trbox"
        style="border:solid 2px rgb(0, 0, 0); max-height: 390px;" data-category="<?= $product['Cat_ID'] ?>">

        <div class="card-img img-fluid text-center" style="height: 200px; overflow:hidden;">
          <img class="img" loading="lazy" src="<?php echo 'admin/layout/images/items/' . $product['Image'] ?>" alt="" style="width:200px"
            onclick='getdatalies(<?php echo json_encode($product); ?>)'>
        </div>

        <div onclick='getdatalies(<?php echo json_encode($product); ?>)' class="card-body"
          style="display: flex; flex-direction: column; justify-content: space-between;margin-top:-60px ">
          <div class="card-title search-title tditem"><?= $product["Name"] ?></div>


          <?php if ($product["price_deleting"] == 0) {
            echo "<div class='card-text h5'>" . $product['price_sale'] . " EGP</div>";
          } else {
            echo "<div class='pricedel card-text h5'>" . $product['price_deleting'] . " EGP </div>";
            echo "<div class='card-text h5'>" . $product['price_sale'] . " EGP</div>";

          } ?>
        </div>

        <div class="container">
          <button type="button"
            onclick="addToCart('<?= $product['item_ID'] ?>', '<?= $product['Name'] ?>', '<?= $product['Image'] ?>', '<?= $product['price_sale'] ?>')"
            class="btn btn-warning  w-100 mx-auto mb-2" style="border-radius:10px;">
            Add To Cart <i class="fa-solid fa-cart-plus"></i>
          </button>
        </div>

      </div>
    <?php endforeach; ?>
  </div>
  <div id="hiddenSection"></div>
</div>

<!-- end products -->



<div class="container mt-5" id='contact'>
  <div class="contact-info">

    <h2 class="section-title text-center">Contuct Us</h2>
    <h5 class='text-dark'>
      <strong class='text-primary'>Phone 1 :</strong>
      <?php echo $setting['phone_1'] ?>
      <h5>
        <h5 class='text-dark'>
          <strong class='text-primary'>Phone 2 :</strong>
          <?php echo $setting['phone_2'] ?>
          <h5>
            <!-- روابط السوشيال ميديا -->
            <div class="social-icons mt-5">
              <!-- WhatsApp -->
              <a href="<?php echo $setting['whatsapp_group'] ?>" target="_blank" class="whatsapp">
                <i class="fab fa-whatsapp text-success"></i>
              </a>
              <!-- Facebook -->
              <a href="<?php echo $setting['facebook'] ?>" target="_blank" class="facebook">
                <i class="fab fa-facebook-f text-primary"></i>
              </a>
              <!-- YouTube -->
              <a href="<?php echo $setting['youtube'] ?>" target="_blank" class="youtube">
                <i class="fab fa-youtube text-danger"></i>
              </a>
              <!-- Telegram -->
              <a href="<?php echo $setting['telegram'] ?>" target="_blank" class="telegram">
                <i class="fab fa-telegram-plane text-info"></i>
              </a>
              <!-- instgram -->
              <a href="<?php echo $setting['instagram'] ?>" target="_blank" class="instagram">
                <img src="layout/images/instagram_PNG9.png" width='33px' alt="">
              </a>


            </div>
  </div>
</div>
<script> let type = 'home';</script>
<?php


include($tpl . 'footer.inc.php');
?>
<script> filter() </script>