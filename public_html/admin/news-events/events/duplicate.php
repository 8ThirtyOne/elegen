<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$update = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
     if(!empty($_GET['pkid'])){
       $pkid = $webhelper->RequestFilter("pkid", 0, false);
       $titleExist = $dbhelper->numOfRows("SELECT title FROM events WHERE pkid = ?", 'i', $pkid);
       if($titleExist){
       $page = $webhelper->RequestFilter("page", 0, false);
       $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
       $order = $webhelper->RequestFilter("order", 0, false);
       if(isset($page) && isset($order) && isset($searchKey)){
          if($webhelper->isNull($page)) $page = 1;
          if($webhelper->isNull($searchKey)) $searchKey = "";
          if($webhelper->isNull($order)) $order = 0;       
          $Parameter = "?page=$page&searchKey=$searchKey&order=$order";

          $sql = "INSERT INTO events(type, year, startmonth, startday, endmonth, endday, title, eventurl, subtitle, address, location1, location2, lat, lng, url, booth, thumbnail, filename, orgfilename, twhashtag, body, pageBody, updatedate, created, status) 
           SELECT type, year, startmonth, startday, endmonth, endday, title, eventurl, subtitle, address, location1, location2, lat, lng, url, booth, thumbnail, filename, orgfilename, twhashtag, body, pageBody, NOW(), NOW(), status FROM events WHERE pkid = $pkid";
            $inserpkid = $dbhelper->RunSQLReturnID($sql);
            if(!empty($inserpkid) && $inserpkid > 0){
              $sql = "SELECT thumbnail, filename FROM events WHERE pkid = $pkid";
              $ViewData = $dbhelper->RunSQLReturnOneRow($sql);
              if(!empty($ViewData["thumbnail"]) && $ViewData["thumbnail"] != 'none'){
                 $newThumbnail = $webhelper->CopyFile("/events/", $ViewData["thumbnail"]);
              }else{
                 $newThumbnail = 'none';
              }
              if(!empty($ViewData["filename"]) && $ViewData["filename"] != 'none'){
                 $newFilename = $webhelper->CopyFile("/events/", $ViewData["filename"]);
              }else{
                 $newFilename = 'none';
              }
               $update = $dbhelper->updateAll("UPDATE events SET thumbnail = '$newThumbnail', filename = '$newFilename' WHERE pkid = '$inserpkid'");
             if($update){
               header('Location: /admin/news-events/events/list'.$Parameter);
               exit;
             }else{
               header('Location: /admin/news-events/events/list?error=technicalissue');
               exit;
             }
           }
         }
       }//check if no literature
     }else{
        header('Location: /admin/news-events/events/list?error=nopress');
        exit;
     }//check if pkid is set
   }
}else{
  header('Location: /admin/');
  exit;
}