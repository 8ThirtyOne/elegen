<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$publish = false;
$dir = "resources/videos";
$addurl = 'newurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    header('Location: /admin/');
    exit;
  }else{
    if(isset($_GET['id'])){
      $pkid = $webhelper->RequestFilter("id", 0, false);
      $titleExists = $dbhelper->numOfRows('SELECT title FROM videos WHERE pkid = ?', 'i', $pkid);
      if($titleExists > 0){
        $publish = $dbhelper->updateAll("UPDATE videos SET status = 1 WHERE pkid = '$pkid'");
        $slugurl = $dbhelper->selectOne('SELECT slugurl FROM videos WHERE pkid = ?', 'i', $pkid);
        if($publish){
          include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
          echo "1";
        }else{
          echo "0";
        }
      }else{
        echo "2";
      }
    }elseif(isset($_POST['pkids'])){
       $pkids = $webhelper->RequestFilterMulti("pkids", 0, false);
       if(count($pkids)>0){
          $pkid = implode(",", $pkids);
          $sql = "select pkid, slugurl from videos where pkid in( $pkid )";
          $List = $dbhelper->RunSQLReturnRows($sql);
          if(!empty($List)){
            foreach ($List as $row){
              $slugurl = $row['slugurl'];
              $publish = $dbhelper->updateAll("UPDATE videos SET status = 1 WHERE pkid = " . $row["pkid"]);
              include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
            }
            if($publish){
              echo "1";
            }else{
              echo "0";
            }
          }
       }else{
         echo "-1";
       }
    }else{
     echo "0";
    }
  }
}else{
  header('Location: /admin/');
  exit;
}