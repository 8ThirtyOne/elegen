<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$delete = false;
$dir = "content/literatures";
$addurl = 'removeurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_GET['pkid'])){
      $pkid = $webhelper->RequestFilter("pkid", 0, false);
      $titleExists = $dbhelper->numOfRows('SELECT title FROM literatures WHERE pkid = ?', 'i', $pkid);
      if($titleExists > 0){
        $literature = $dbhelper->RunSQLReturnOneRow("SELECT slugurl, thumbnail, filename FROM literatures 
                                                     WHERE pkid = '$pkid'");
        $slugurl = $literature['slugurl'];
        if(!empty($literature['thumbnail'])) $webhelper->DeleteFile("/literatures/", $literature["thumbnail"]);
        if(!empty($literature['filename'])) $webhelper->DeleteFile("/literatures/", $literature["filename"]);
        $delete = $dbhelper->deleteAll("DELETE FROM literatures WHERE pkid = '$pkid'");
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
          $sql = "SELECT pkid, slugurl, thumbnail, filename FROM literatures WHERE pkid IN( $pkid )";
          $List = $dbhelper->RunSQLReturnRows($sql);
          if(!empty($List)){
            foreach ($List as $row){
              $slugurl = $row['slugurl'];
              if($row["thumbnail"] != "")
                $webhelper->DeleteFile("/literatures/", $row["thumbnail"]);
              if($row["filename"] != "")
                $webhelper->DeleteFile("/literatures/", $row["filename"]);
              $delete = $dbhelper->deleteAll("DELETE FROM literatures WHERE pkid = "  . $row["pkid"]);
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
