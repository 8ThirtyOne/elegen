<?php 
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$delete = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    header('Location: /admin/');
    exit;
  }else{
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
    if(!empty($_POST['pkid'])){
       $pkid=trim($_POST['pkid']);
       $pkid = $webhelper->RequestFilter('pkid', 0, false);
       $checkId = $dbhelper->numOfRows('SELECT id FROM admin WHERE pkid = ?', 'i', $pkid);
       if($checkId > 0){
         $delete = $dbhelper->deleteAll("DELETE FROM admin WHERE pkid = '$pkid'");
         if($delete){
           echo "1";
         }else{
         	echo "0";
         }
       }else{
       	echo "0";
       }
    }else{
    	echo "0";
    }
  }else{
    echo "0";
  }
 }
}else{
  echo "Nothing Here.";
}