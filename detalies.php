<?php
  $pageTitle = "Detalies";
  $NoSearchBar = true;
  include('init.php');

  // تحديد دومين الموقع تلقائيًا بدل ما تكتبه يدوي
  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
  $domain = $protocol . "://" . $_SERVER['HTTP_HOST'];

  $productId = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'unknown';
?>
<div id="Detailes"></div>

<script>let type = 'detalies';</script>
<?php include($tpl.'footer.inc.php'); ?>

<script>
  showDetaliesFromURL(); // جلب تفاصيل المنتج من الرابط
</script>

