<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$update = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    echo "0";
  }else{
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
     if(!empty($_GET['pkid'])){
        $pkid = $webhelper->RequestFilter("pkid", 0, false);
        $titleExist = $dbhelper->numOfRows("SELECT title FROM videos WHERE pkid = ?", 'i', $pkid);
        if($titleExist){
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        if(isset($page) && isset($order) && isset($searchKey)){
           if($webhelper->isNull($page)) $page = 1;
           if($webhelper->isNull($searchKey)) $searchKey = "";
           if($webhelper->isNull($order)) $order = 0;       
           $Parameter = "?page=$page&searchKey=$searchKey&order=$order";

           $sql = "INSERT INTO videos(title, param, body, slugurl, thumbnail, updated, created, status) 
            SELECT title, param, body, slugurl, thumbnail, NOW(), NOW(), status FROM videos WHERE pkid = $pkid";
             $inserpkid = $dbhelper->RunSQLReturnID($sql);
             if(!empty($inserpkid) && $inserpkid > 0){
               $sql = "SELECT thumbnail FROM videos WHERE pkid = $pkid";
               $ViewData = $dbhelper->RunSQLReturnOneRow($sql);
               if(!empty($ViewData["thumbnail"])) $newThumbnail = $webhelper->CopyFile("/videos/", $ViewData["thumbnail"]);
                $update = $dbhelper->updateAll("UPDATE videos SET thumbnail = '$newThumbnail' WHERE pkid = '$inserpkid'");
              if($update){
                header('Location: /admin/resources/videos/list'.$Parameter);
                exit;
              }else{
                header('Location: /admin/resources/videos/list?error=technicalissue');
                exit;
              }
            }
          }
        }//check if no literature
      }else{
         header('Location: /admin/resources/videos/list?error=noliterature');
         exit;
      }//check if pkid is set
    }else{
      header('Location: /admin/');
      exit;
    }
  }
}else{
  header('Location: /admin/');
  exit;
}