<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$delete = false;
if(!empty($_POST['pkid'])){
   $pkid=trim($_POST['pkid']);
   $pkid = $webhelper->RequestFilter('pkid', 0, false);
   $emailExists = $dbhelper->numOfRows('SELECT email FROM web_subscribers WHERE pkid = ?', 'i', $pkid);
   if($emailExists > 0){
     $delete = $dbhelper->deleteAll("DELETE FROM web_subscribers WHERE pkid = '$pkid'");
     if($delete){
       echo "1";
     }else{
     	echo "0";
     }
   }else{
   	echo "0";
   }
}else{
	echo "Nothing Here";
}