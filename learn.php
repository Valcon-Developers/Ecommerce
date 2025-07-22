<?php
$pageTitle = "learn";
$NoSearchBar = true;

include('init.php');
$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

if ($do == "Manage") {


    $stmt = $con->prepare("SELECT * FROM catlearn ");
    $stmt->execute();
    $products = $stmt->fetchAll();



    ?>


    <div id="hero"></div>


    <div class="container" id="tools" style="min-height:80vh">

        <div class="p-3 ">
            <form class="">
                <div class="mx-auto barsearch"
                    style="background-color: white; border-radius: 20px;border:solid 3px gray ;padding-left:5px">

                    <label for="search"><i class="fa-solid fa-magnifying-glass text-dark"></i></label>
                    <input type="text" id="search" class="search search-input" placeholder="Search for section here"
                        style="width:90%" onkeyup="getSearch()">

                </div>
            </form>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;" id="products"
            class="tdbox">

            <?php foreach ($products as $product): ?>

                <div class="card text-white m-3 border-0 shadow trbox"
                    style="background: linear-gradient(135deg, #17a2b8, #6f42c1); border-radius: 1rem; transition: transform 0.3s;"
                    onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <a href="learn.php?do=show&section=<?php echo urlencode($product['id']) ?>"
                        class="text-white text-decoration-none">
                        <div class="card-body text-center p-4">
                            <span style="font-size: 3rem;">🦷</span>
                            <i class="fas fa-layer-group fa-3x mb-3"></i>
                            <h3 class="card-title font-weight-bold tditem"><?php echo $product['name'] ?></h3>
                        </div>
                    </a>
                </div>

            <?php endforeach; ?>
        </div>
        <div id="hiddenSection"></div>
    </div>

    <!-- end products -->

    <?php
} elseif ($do == 'show') {

    $catid = isset($_GET['section']) && is_numeric($_GET['section']) ? intval($_GET['section']) : '0';

    $stmt = $con->prepare("SELECT * FROM learn WHERE CAT_ID = ?");
    $stmt->execute([$catid]);
    $videos = $stmt->fetchAll();
    ?>
    <div class="container text-center pt-5" style="min-height:80vh">
        <!-- hero section is needed for search function work -->
        <div id="hero"></div>

        <h2 class="mb-4 text-center">📚 Videos in This Section</h2>
        <div class="mb-4">

            <form class="pb-3 text-left ">
                <div class="mx-auto barsearch"
                    style="background-color: white; border-radius: 20px;border:solid 3px gray ;padding-left:5px">

                    <label for="search"><i class="fa-solid fa-magnifying-glass text-dark"></i></label>
                    <input type="text" id="search" class="search search-input" placeholder="Search for section here"
                        style="width:90%" onkeyup="getSearch()">

                </div>
            </form>
        </div>
        <?php
        echo '<div id="products"></div>
                <div class="row" id="videoContainer">';
        $i = 0;
        foreach ($videos as $video) {
            // استخراج ID الفيديو من الرابط
            preg_match('/(?:v=|\/)([0-9A-Za-z_-]{11}).*/', $video['link'], $matches);
            $youtubeID = $matches[1] ?? '';
            if ($youtubeID != '') {
                $loading = ($i > 5) ? 'loading="lazy"' : '';
                echo '
                <div class="col-md-6 col-lg-4 text-center trbox">
                    <div class="">
                        <div class="">
                        <div class="">
                        <iframe ' . $loading . ' src="https://www.youtube.com/embed/' . $youtubeID . '" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                            </div>
                            
                            <h5 class=" tditem card-title video-title">' . htmlspecialchars($video['name']) . '</h5>
                        </div>
                    </div>
                </div>';
            }
            $i++;
        }
        echo '</div>';
        echo ' 
        <div id="hiddenSection"></div> </div> ';

}
?>
    <script> let type = 'learn';</script>
    <?php
    include($tpl . 'footer.inc.php');
    ?>