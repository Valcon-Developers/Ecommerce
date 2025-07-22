
<?php

$pageTitle = "About Us";
$NoSearchBar = true;
include("init.php");


?>


<section class="about-section" style="direction: rtl ;text-align:right">
    <div class="container">
        <h2 class="text-center mb-4">من نحن</h2>
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <p class="fs-5 mb-4">
                    نحن شركة <strong>Tooth Store</strong>، متخصصة في بيع أدوات ومستلزمات طب الأسنان لطلبة كليات طب
                    الأسنان داخل جمهورية مصر العربية.
                    انطلقت رؤيتنا من حاجة الطلبة لحلول موثوقة، بأسعار مناسبة، وتوصيل سريع لكل مكان.
                </p>
                <p class="fs-5">
                    هدفنا هو تسهيل رحلة الطالب من أول يوم دراسة وحتى التخرج، عن طريق توفير كل ما يحتاجه من أدوات،
                    باكدجات متكاملة، وخدمة عملاء تستجيب بسرعة.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="layout/images/box.png" width="300px" class="img-fluid rounded shadow" alt="Dental Tools">
            </div>
        </div>

        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="icon-box h-100">
                    <i class="fas fa-eye"></i>
                    <h5 class="mt-2">رؤيتنا</h5>
                    <p>أن نصبح المنصة التعليمية والتجارية الأولى لطلاب طب الأسنان في مصر، من خلال الابتكار والجودة وخدمة
                        الطالب.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="icon-box h-100">
                    <i class="fas fa-bullseye"></i>
                    <h5 class="mt-2">مهمتنا</h5>
                    <p>نوفر أدوات موثوقة بأسعار منافسة، مع باكدجات خاصة بكل ترم، وخدمة توصيل في أسرع وقت لكل الطلبة في
                        جميع المحافظات.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="icon-box h-100">
                    <i class="fas fa-heart"></i>
                    <h5 class="mt-2">قيمنا</h5>
                    <p>الجودة، المصداقية، الأمان، السرعة، دعم الطالب، والالتزام بالتطور المستمر.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<script> let type = 'about';</script>
<?php include("includes/templates/footer.inc.php") ?>