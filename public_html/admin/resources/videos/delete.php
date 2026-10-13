<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$delete = false;
$dir = "resources/videos";
$addurl = 'removeurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_GET['pkid'])){
      $pkid = $webhelper->RequestFilter("pkid", 0, false);
      $titleExists = $dbhelper->numOfRows('SELECT title FROM videos WHERE pkid = ?', 'i', $pkid);
      if($titleExists > 0){
        $videos = $dbhelper->RunSQLReturnOneRow("SELECT slugurl, thumbnail FROM videos 
                                                     WHERE pkid = '$pkid'");
        $slugurl = $videos['slugurl'];
        if(!empty($videos['thumbnail'])) $webhelper->DeleteFile("/videos/", $literature["thumbnail"]);
        $delete = $dbhelper->deleteAll("DELETE FROM videos WHERE pkid = '$pkid'");
        if($delete){
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
          $sql = "SELECT pkid, slugurl, thumbnail FROM videos WHERE pkid IN( $pkid )";
          $List = $dbhelper->RunSQLReturnRows($sql);
          if(!empty($List)){
            foreach ($List as $row){
              $slugurl = $row['slugurl'];
              if($row["thumbnail"] != "") $webhelper->DeleteFile("/videos/", $row["thumbnail"]);
              $delete = $dbhelper->deleteAll("DELETE FROM videos WHERE pkid = "  . $row["pkid"]);
              include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php'); 
            }
            if($delete){
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
  echo "0";
}
