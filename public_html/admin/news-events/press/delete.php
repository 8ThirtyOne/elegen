<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$delete = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      if(isset($_GET['pkid'])){
        $pkid = $webhelper->RequestFilter("pkid", 0, false);
        $titleExists = $dbhelper->numOfRows('SELECT title FROM press WHERE pkid = ?', 'i', $pkid);
        if($titleExists > 0){
          $press = $dbhelper->RunSQLReturnOneRow("SELECT thumbnail, filename FROM press 
                                                       WHERE pkid = '$pkid'");
          if(!empty($press['thumbnail'])) $webhelper->DeleteFile("/news/", $press["thumbnail"]);
          if(!empty($press['filename'])) $webhelper->DeleteFile("/news/", $press["filename"]);
          $delete = $dbhelper->deleteAll("DELETE FROM press WHERE pkid = '$pkid'");
          if($delete){
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
            $sql = "SELECT pkid, thumbnail, filename FROM press WHERE pkid IN( $pkid )";
            $List = $dbhelper->RunSQLReturnRows($sql);
            if(!empty($List)){
              foreach ($List as $row){
                if($row["thumbnail"] != "")
                  $webhelper->DeleteFile("/news/", $row["thumbnail"]);
                if($row["filename"] != "")
                  $webhelper->DeleteFile("/news/", $row["filename"]);
                $delete = $dbhelper->deleteAll("DELETE FROM press WHERE pkid = "  . $row["pkid"]);
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
  echo "Nothing Here.";
}