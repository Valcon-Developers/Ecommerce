<?php


function getTitle(){

    global $pageTitle ;
 
    if(isset($pageTitle)){
      echo $pageTitle;
    }else{
      echo"Defult";
    }

};

// Redirect function
// function redirectHome($errorMsg ,$url=null, $seconds = 3 ){
//   if($url===null){
//      $url='index.php';
//      $link='Home Page';
//   }else{
//     if(isset($_SERVER['HTTP_REFERER'])&&$_SERVER['HTTP_REFERER']!=''){

//       $url=$_SERVER['HTTP_REFERER'];
//       $link='Previous Page';
//     }else{
//       $url='index.php';
//       $link='Home Page';
//     }
//   }
//   echo $errorMsg ;

//   echo "<div class='alert alert-info'> You Will Be Redirected To $link After $seconds Seconds </div>" ;
//   header("refresh:$seconds;url=$url");
//   exit();
// };


function redirectHome($errorMsg ,$url = null, $seconds = 3) {
    // تحديد الرابط النهائي اللي هيروحله
    if ($url === null || $url === 'back') {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previous Page';
        } else {
            $url = 'index.php';
            $link = 'Home Page';
        }
    } else {
        // هنا بقى بعت له لينك معين زي items.php
        $link = $url;
    }

    // عرض الرسالة
    echo $errorMsg;
    echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds Seconds</div>";

    // تنفيذ التحويل بعد الوقت المحدد
    header("refresh:$seconds;url=$url");
    exit();
}

// check item if exist n data base 
 
function CheckItem($select,$from,$value){
  
  global $con ;
  $statement = $con-> prepare("SELECT $select FROM $from WHERE $select=?");
  $statement->execute(array($value));
  $count = $statement->rowCount();
  if($count>0){
    return true;
  }else{
    return false;
  }

};
// 
function countItems($item,$table){
  global $con ;
  $stmt2=$con->prepare("SELECT COUNT($item) FROM $table");
  $stmt2->execute();
  return $stmt2->fetchColumn();
};

function getlatest($select,$table,$order,$limit=5){
  global $con;
  $stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
  $stmt->execute();
  $rows= $stmt->fetchAll();
  return $rows;
};

function parseOrder($orderString) {
    $products = explode(';', $orderString);
    $items = [];

    foreach ($products as $p) {
        if (trim($p) === '') continue;
        preg_match('/(\d+)->(.*?)=>(\d+)/', $p, $matches);
        if ($matches && (int)$matches[3]>0) {
            $items[] = [
                'id' => $matches[1],
                'name' => trim($matches[2]),
                'qty' => $matches[3]
            ];
        }
    }

    return $items;
}


?>