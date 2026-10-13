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
       $titleExist = $dbhelper->numOfRows("SELECT title FROM articles WHERE pkid = ?", 'i', $pkid);
       if($titleExist){
       $page = $webhelper->RequestFilter("page", 0, false);
       $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
       $order = $webhelper->RequestFilter("order", 0, false);
       if(isset($page) && isset($order) && isset($searchKey)){
          if($webhelper->isNull($page)) $page = 1;
          if($webhelper->isNull($searchKey)) $searchKey = "";
          if($webhelper->isNull($order)) $order = 0;       
          $Parameter = "?page=$page&searchKey=$searchKey&order=$order";

          $sql = "INSERT INTO articles(year, month, day, url, title, subtitle, source, slugurl, body, thumbnail, filename, orgfilename, status, type, updatedate, created, permission) 
           SELECT year, month, day, url, title, subtitle, source, slugurl, body, thumbnail, filename, orgfilename, status, type, NOW(), NOW(), permission FROM articles WHERE pkid = $pkid";
            $inserpkid = $dbhelper->RunSQLReturnID($sql);
            if(!empty($inserpkid) && $inserpkid > 0){
              $sql = "SELECT thumbnail, filename FROM articles WHERE pkid = $pkid";
              $ViewData = $dbhelper->RunSQLReturnOneRow($sql);
              if(!empty($ViewData["thumbnail"]) && $ViewData["thumbnail"] != 'none'){
                 $newThumbnail = $webhelper->CopyFile("/news/", $ViewData["thumbnail"]);
              }else{
                 $newThumbnail = 'none';
              }
              if(!empty($ViewData["filename"]) && $ViewData["filename"] != 'none'){
                 $newFilename = $webhelper->CopyFile("/news/", $ViewData["filename"]);
              }else{
                 $newFilename = 'none';
              }
               $update = $dbhelper->updateAll("UPDATE articles SET thumbnail = '$newThumbnail', filename = '$newFilename' WHERE pkid = '$inserpkid'");
             if($update){
               header('Location: /admin/news-events/news/list'.$Parameter);
               exit;
             }else{
               header('Location: /admin/news-events/news/list?error=technicalissue');
               exit;
             }
           }
         }
       }//check if no literature
     }else{
        header('Location: /admin/news-events/news/list?error=nopress');
        exit;
     }//check if pkid is set
   }
}else{
  header('Location: /admin/');
  exit;
}