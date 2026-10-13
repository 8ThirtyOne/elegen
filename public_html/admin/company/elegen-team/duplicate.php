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
       $profile = $dbhelper->numOfRows("SELECT first FROM employee_profile WHERE pkid = ?", 'i', $pkid);
       if($profile > 0){
       $page = $webhelper->RequestFilter("page", 0, false);
       $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
       $order = $webhelper->RequestFilter("order", 0, false);
       if(isset($page) && isset($order) && isset($searchKey)){
          if($webhelper->isNull($page)) $page = 1;
          if($webhelper->isNull($searchKey)) $searchKey = "";
          if($webhelper->isNull($order)) $order = 0;       
          $Parameter = "?page=$page&searchKey=$searchKey&order=$order";

          $sql = "INSERT INTO employee_profile(first, last, job_title, quote, headshot, hobby_thumb, body, hobby, slugurl, updated, created, status) SELECT first, last, job_title, quote, headshot, hobby_thumb, body, hobby, slugurl, NOW(), NOW(), status FROM employee_profile WHERE pkid = $pkid";
            $inserpkid = $dbhelper->RunSQLReturnID($sql);
            if(!empty($inserpkid) && $inserpkid > 0){
              $sql = "SELECT headshot, hobby_thumb FROM employee_profile WHERE pkid = $pkid";
              $ViewData = $dbhelper->RunSQLReturnOneRow($sql);
              if(!empty($ViewData["headshot"]) && $ViewData["headshot"] != 'none'){
                 $newHeadshot = $webhelper->CopyFile("/team/", $ViewData["headshot"]);
              }else{
                 $newHeadshot = 'none';
              }
              if(!empty($ViewData["hobby_thumb"]) && $ViewData["hobby_thumb"] != 'none'){
                 $newHobbyImg = $webhelper->CopyFile("/team/", $ViewData["hobby_thumb"]);
              }else{
                 $newHobbyImg = 'none';
              }
               $update = $dbhelper->updateAll("UPDATE employee_profile SET headshot = '$newHeadshot', hobby_thumb = '$newHobbyImg' WHERE pkid = '$inserpkid'");
             if($update){
               header('Location: /admin/company/elegen-team/list'.$Parameter);
               exit;
             }else{
               header('Location: /admin/company/elegen-team/list?error=technicalissue');
               exit;
             }
           }
         }
       }//check if no literature
     }else{
        header('Location: /admin/company/elegen-team/list?error=nopress');
        exit;
     }//check if pkid is set
   }
}else{
  header('Location: /admin/');
  exit;
}