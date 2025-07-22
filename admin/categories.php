<?php

/*
============================================
==  Categories Page
============================================
*/

session_start();

if(isset($_SESSION['UsernameAdmin*&%8253'])){
    
    $pageTitle='Categories';
    include('init.php');
    $do=isset($_GET['do'])?$_GET['do']:'Manage';

    if($do=='Manage'){
        $order="ASC";
        $array=["ASC","DESC"];
        if(isset($_GET['sort'])&&in_array($_GET["sort"],$array)){$order=$_GET['sort'];}
        $stmt=$con->prepare("SELECT * FROM categories ORDER BY ordering $order");
        $stmt->execute();
        $rows=$stmt->fetchAll();

        ?>
         <div class="container mt-4">
  <div class="row align-items-center mb-3">
    <!-- العمود الأول -->
    <div class="col-md-6 mb-2">
      <h1 class="text-secondary">Manage Categories</h1>
    </div>
    <!-- العمود الثاني -->
    <div class="col-md-6">
      <form class="w-100">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text bg-white border border-secondary rounded-left">
              <i class="fa fa-search text-dark"></i>
            </span>
          </div>
          <input type="text" id="search" class="form-control border border-secondary" placeholder="Search for products here" onkeyup="getSearch('flex')">
        </div>
      </form>
    </div>
  </div>

  <div class="categories pb-5">
    <div class="card">
      <div class="card-title d-flex flex-wrap justify-content-between align-items-center bg-light px-3 py-2">
        <div class="h4 text-secondary"><i class="fa fa-edit"></i> Manage Categories</div>
        <div class="Option small">
          <i class="fa fa-sort"></i> ORDER : [
          <a href="?sort=ASC" class="<?php if($order=="ASC"){echo "active";} ?>">ASC</a> | 
          <a href="?sort=DESC" class="<?php if($order=="DESC"){echo "active";} ?>">DESC</a> ]
          <i class="fa fa-eye"></i> View : [
          <span class="active" data-view="full">Full</span> |
          <span>Classic</span> ]
        </div>
      </div>

      <div class="card-body" id="mainSection">
        <?php
        foreach($rows as $row){
          echo "<div class='cat trbox d-flex flex-column flex-md-row justify-content-between align-items-start border-bottom pb-3 mb-3'>";
            echo "<div>";
              echo '<h5 class="text-secondary tditem">'.$row['Ordering']." - ".$row['Name'].'</h5>';
              echo "<div class='full-view'>";
              echo '<p class="text-primary">';
              echo ($row['Description'] == '') ? "This category has no description" : $row['Description'];
              echo '</p>';
              if($row['Visibility']==1) echo '<span class="badge badge-danger p-2 m-1"><i class ="fa fa-eye"></i> Hidden</span>';
              if($row['Allow_Comment']==1) echo '<span class="badge badge-dark p-2 m-1"><i class="fa fa-close"></i> Comment Disabled</span>';
              if($row['Allow_Ads']==1) echo '<span class="badge badge-info p-2 m-1"><i class="fa fa-close"></i> Ads Disabled</span>';
              echo "</div>";
            echo "</div>";

            echo "<div class='mt-2'>";
              echo "<a href='categories.php?do=Edit&catid=".$row['ID']."' class='btn btn-success btn-sm mr-2'><i class='fa fa-edit'></i> Edit</a>";
              echo "<a href='categories.php?do=Delete&catid=".$row['ID']."' class='btn btn-danger btn-sm mr-2 confirm'><i class='fa fa-close'></i> Delete</a>";
              echo "<a href='items.php?do=Manage&catid=".$row['ID']."' class='btn btn-info btn-sm'><i class='fa fa-list'></i> Items</a>";
            echo "</div>";
          echo "</div>";
        }
        ?>
      </div>
    </div>

    <div class="text-center">
      <a href='categories.php?do=Add' id='addbtn' class='btn btn-primary mt-4'>
        <i class='fa fa-add'></i> New Category
      </a>
    </div>

    <div id="hiddenSection"></div>
  </div>
</div>


<script>
  function getSearch(viewType){
    // سكريبت البحث هنا
  }
</script>
        <?php
    }elseif($do=='Add'){  ?>

        <h1 class="text-center m-5 text-secondary">Add New Category</h1>
        <div class="container">
            <form class="form-horizontal" action="categories.php?do=Insert" method="POST">
                <!-- start Name -->
                <div class="row form-group ">
                    <label class="col-sm-2 h3">Name</label>
                    <div class="col-sm-8 col-md-8">
                        <input type="text" name="name" class="form-control form-control-lg" autocomplete="off" required placeholder="Name off the category">
                    </div>
                </div>
                <!-- end Name -->

                <!-- start Description -->
                <div class="row form-group ">
                    <label class="col-sm-2 h3">Description</label>
                    <div class="col-sm-8 col-md-8">
                      <input  type="text" name="description" class="form-control form-control-lg"  placeholder="Descripe The Category">
                    </div>
                </div>
                <!-- end Description -->

                <!-- start Ordering -->
                <div class="row form-group ">
                    <label class="col-sm-2 h3">Ordering</label>
                    <div class="col-sm-8 col-md-8">
                        <input type="text" name="ordering" class="form-control form-control-lg" placeholder="Number To Arrange The Categories">
                    </div>
                </div>
                <!-- end Ordering -->

                <!-- start btn -->
                <div class="row form-group">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10 ">
                        <input type="submit" value="Add New Category" class="btn btn-primary btn-lg ">
                    </div>
                </div>
                <!-- end btn -->
            </form>
            <div>
        <?php
    }elseif($do=='Insert'){
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){

            echo"<h1 class='text-center text-secondary m-5 pt-5 '>Insert Category</h1>";
            echo"<div class='container'>";

            // Get Variables From The Form 
            $name      = $_POST["name"];
            $desc      = $_POST["description"];
            $ordering  = $_POST["ordering"];


            $check= CheckItem("Name","categories",$name);

            if($check){
                $Msg= "<div class='alert alert-danger'> This Category Is Used </div>";
                redirectHome($Msg,'back',4);
            }else{
                //  Update the database
                $stmt=$con->prepare("INSERT INTO categories(Name,Description,Ordering)
                VALUES(:zname, :zdesc, :zordering)");
                $stmt->execute(array(
                'zname' => $name,
                'zdesc' => $desc,
                'zordering' => $ordering,
                ));

                if($stmt->rowCount() < 1){
                $Msg = "<div class='alert alert-danger'> Category Not Inserted </div>";
                redirectHome($Msg,'back',4);
                }else{
                $msg="<div class='alert alert-success'>".$stmt->rowCount()." Category Inserted </div>";
                redirectHome($msg,'categories.php');
                }
            }
            
        
        }else{
            echo"<div class='container'>'";
            $errorMsg ="<div class='alert alert-danger'> Sorry You Cant Browse This Page Directly </div>";
            redirectHome($errorMsg,'back');
            echo"</div>";
        }
        echo "</div>";

    }elseif($do=='Edit'){
        $catid=isset($_GET['catid'])&&is_numeric($_GET['catid'])?intval($_GET['catid']):'0';
        $stmt=$con->prepare("SELECT * FROM categories WHERE ID=? LIMIT 1");
        $stmt->execute(array($catid));
        $row=$stmt->fetch();
        $count=$stmt->rowCount();
        if($count > 0){ 
            ?>
                <div class="container">
                    <h1 class="text-center m-5 text-secondary">Edit Category</h1> 
                    <form class="form-horizontal" action="categories.php?do=Update" method="POST">
                        <input type="hidden" name="catid" value="<?php echo $catid ?>">
                        <!-- start Name -->
                        <div class="row form-group ">
                            <label class="col-sm-2 h3">Name</label>
                            <div class="col-sm-8 col-md-8">
                                <input type="text" name="name" class="form-control form-control-lg" value="<?php echo $row['Name'] ?>" autocomplete="off" required >
                            </div>
                        </div>
                        <!-- end Name -->

                        <!-- start Description -->
                        <div class="row form-group ">
                            <label class="col-sm-2 h3">Description</label>
                            <div class="col-sm-8 col-md-8">
                            <input  type="text" name="description" class="form-control form-control-lg" value="<?php echo $row['Description'] ?>">
                            </div>
                        </div>
                        <!-- end Description -->

                        <!-- start Ordering -->
                        <div class="row form-group ">
                            <label class="col-sm-2 h3">Ordering</label>
                            <div class="col-sm-8 col-md-8">
                                <input type="text" name="ordering" value="<?php echo $row['Ordering'] ?>" class="form-control form-control-lg" >
                            </div>
                        </div>
                        <!-- end Ordering -->



                        <!-- start btn -->
                        <div class="row form-group">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10 ">  
                                <input type="submit" value="Update Category" class="btn btn-primary btn-lg ">
                            </div>
                        </div>
                        <!-- end btn -->
                    </form>
                    <div>            
            <?php
        } else {
            echo"<div class='container pt-5'>";
            $msg= "<div class='alert alert-danger'>There No Such Id In DataBase</div>";
            redirectHome($msg,'back');
            echo"</div>";
        }
        
    }elseif($do=='Update'){
        echo"<h1 class='text-center text-secondary m-5 pt-5 f-bold'>Update Category</h1>";
        echo"<div class='container'>";

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            // Get Variables From The Form 
            $id          = $_POST["catid"];
            $name        = $_POST["name"];
            $description = $_POST["description"];
            $ordering    = $_POST["ordering"];
            $errors=[];
            $check=null;

            $stmt=$con->prepare("SELECT * FROM categories WHERE ID=? LIMIT 1");
            $stmt->execute(array($id));
            $row=$stmt->fetch();

            if($name==$row['Name']){
                $check=false;
            }else{
                $check= CheckItem("Name","categories",$name);
            }

            if($check){
                $errors[]="This Category Name Is Used";
            }
            if($name==''){
                $errors[]="Catefory Name Cannot Be Empty";
            }

            if($errors){
                foreach($errors as $error){
                    $Msg= "<div class='alert alert-danger'>". $error . '</div>';
                    echo $Msg;
                    echo "<div class='btn btn-primary' style='cursor:pointer;' onclick='history.back();'>Back</div>";

                }
            }else{

                //  Update the database
                $stmt=$con->prepare("UPDATE categories SET Name = ? , Description = ? , Ordering = ? WHERE ID = ? ");
                $stmt->execute(array( $name ,$description,$ordering,$id));
                if($stmt->rowCount() < 1){
                    $Msg= "<div class='alert alert-danger'> Record Not Updated </div>";
                    redirectHome($Msg,'categories.php');
                    
                }else{
                    $Msg= "<div class='alert alert-success'> ".$stmt->rowCount()." Record Updated </div>";
                    redirectHome($Msg,'categories.php');
                    
                }
            }
            
        }else{
            $msg = "<div class='alert alert-danger'>Sorry You Cant Browse This Page Directly</div>";
            redirectHome($msg);
            echo "</div>";
        }
    }elseif($do=='Delete'){
        echo"<h1 class='text-center text-secondary m-5 pt-5 '>Delete Category Page</h1>";
        echo"<div class='container'>";
            $catid=isset($_GET['catid'])&&is_numeric($_GET['catid'])?intval($_GET['catid']):'0';
            $check=CheckItem("ID","categories",$catid);
            if($check){
                $stmt= $con->prepare("DELETE FROM categories WHERE ID=?");
                $stmt->execute(array($catid));
                $count=$stmt->rowCount();
                $msg="<div class='alert alert-success'> ${count} Category Deleted </div>";
                redirectHome($msg ,'categories.php');
            }else{
                $msg="<div class='alert alert-danger'>This Id Is Not Exist </div>";
                redirectHome($msg,'categories.php');
            }
        echo"</div>";    
                    
        
    }

    include($tpl.'footer.inc.php');
}else{
    header('Location:index.php');
    exit();
}
?>