<?php
    session_start();
    if(isset($_SESSION['UsernameAdmin*&%8253'])){
        
        $pageTitle = "Dashboard";
        include('init.php');
        // start dashbord page
        $limit=5;
        $latest=getlatest("*","items",'item_ID',$limit);


        ?>

            <div class="container home-stats text-center">
                <h1 class='text-secondary m-5'>Dashboard</h1>
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat bg-primary mb-5">
                            Total Admins
                            <span><a href='members.php'> <?php echo countItems("UserID",'users'); ?></a> </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat st-items">
                            Total categories
                            <span><a href='categories.php'> <?php echo countItems("ID",'categories'); ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="stat bg-info">
                            Total Items
                            <span><a href='items.php'> <?php echo countItems("item_ID",'items'); ?></a></span>
                        </div>
                    </div>

                    <div class="col-md-3 ">
                        <div class="stat bg-danger">
                            طلبات لم يتم تاكيدها
                            <span><a href='orders.php?x=confirm'> <?php echo countItems("id",'orders WHERE confirm = 0 AND done = 0'); ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat bg-warning">
                            طلبات تحت التحضير
                            <span> <a href='orders.php?x=inway'><?php echo countItems("id",'orders WHERE confirm = 1 AND done = 0'); ?></a></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat bg-success">
                           طلبات تم تسليمها
                            <span><a href='orders.php?x=done'> <?php echo countItems("done",'orders WHERE done = 1'); ?></a></span>                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="stat st-Orders">
                            الارشيف
                            <span><a href='orders.php?x=archive'> <?php echo countItems("confirm",'orders WHERE done = 2'); ?></a></span>                        </div>
                    </div>
                    

                </div>

           <?php
        // start dashbord page
        include($tpl.'footer.inc.php') ;

    } else {
        header('Location: index.php');
        exit(); 
    }