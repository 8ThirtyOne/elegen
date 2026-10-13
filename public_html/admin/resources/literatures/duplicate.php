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
        $titleExist = $dbhelper->numOfRows("SELECT title FROM literatures WHERE pkid = ?", 'i', $pkid);
        if($titleExist){
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        if(isset($page) && isset($order) && isset($searchKey)){
           if($webhelper->isNull($page)) $page = 1;
           if($webhelper->isNull($searchKey)) $searchKey = "";
           if($webhelper->isNull($order)) $order = 0;       
           $Parameter = "?page=$page&searchKey=$searchKey&order=$order";

           $sql = "INSERT INTO literatures(title, status, authors, institution, year, month, day, publication, version, slugurl, link, keywords, body, thumbnail, filename, orgfilename, permission, type, updatedate, created) 
            SELECT title, status, authors, institution, year, month, day, publication, version, slugurl, link, keywords, body, thumbnail, filename, orgfilename, permission, type, NOW(), NOW() FROM literatures WHERE pkid = $pkid";
             $inserpkid = $dbhelper->RunSQLReturnID($sql);
             if(!empty($inserpkid) && $inserpkid > 0){
               $sql = "SELECT thumbnail, filename, orgfilename FROM literatures WHERE pkid = $pkid";
               $ViewData = $dbhelper->RunSQLReturnOneRow($sql);
               if(!empty($ViewData["thumbnail"]))
                  $newThumbnail = $webhelper->CopyFile("/literatures/", $ViewData["thumbnail"]);
                if(!empty($ViewData["filename"]))
                  $newFilename = $webhelper->CopyFile("/literatures/", $ViewData["filename"]);
                $update = $dbhelper->updateAll("UPDATE literatures SET thumbnail = '$newThumbnail', filename = '$newFilename' WHERE pkid = '$inserpkid'");
              if($update){
                header('Location: /admin/resources/literatures/list'.$Parameter);
                exit;
              }else{
                header('Location: /admin/resources/literatures/list?error=technicalissue');
                exit;
              }
            }
          }
        }//check if no literature
      }else{
         header('Location: /admin/resources/literatures/list?error=noliterature');
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