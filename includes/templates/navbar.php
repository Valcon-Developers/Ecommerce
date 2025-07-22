<div class=' bg-light sticky-top'>
 <div class='container '>
 <div id="navbar"  class="navbar-light bg-light text-dark p-0 ">
        <nav class="container navbar navbar-expand-lg navbar-light pr-5 ">
            <a class="navbar-brand "style=" margin-left:-30px;margin-right:-20px" href="index.php"><img src="layout/images/LOGO4.jpg"  style=" width:150px; max-height: 40px;"  alt=""></a>

             <li class="nav-item ">
                <a class="nav-link text-light ml-auto" style="border-radius:20px " href="cart.php" id="cart-count"></a>
            </li>  
           
            <button class="navbar-toggler "style='margin-right:-30px' type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link active" href="review.php">Review</a>
                    </li>  
                    <li class="nav-item ">
                        <a class="nav-link active" href="learn.php">Education</a>
                    </li>  
                    <li class="nav-item ">
                        <a class="nav-link active" href="index.php#contact">Contact Us</a>
                    </li> 
                    <li class="nav-item ">
                        <a class="nav-link active" href="about.php">About us</a>
                    </li>
                </ul>
                <?php if(!isset($NoSearchBar)){?>
                <form action="" class="ml-auto" >
                    <div class="mx-auto" style="width:300px ; background-color: white; border-radius: 20px;border:solid 3px gray ;padding-left:5px" >
                      <label for="search"><i class="fa-solid fa-magnifying-glass text-dark"></i></label>
                      <input type="text" id="search" class="search search-input" style="width:80%;" placeholder="Search for products here" onkeyup="getSearch()">
                  
                    </div>
                  </form>
                  <?php }?>
            </div>
        </nav>
    </div>
    </div> 
</div>