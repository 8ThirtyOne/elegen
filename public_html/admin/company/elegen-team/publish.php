<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$publish = false;
$dir = "company/elegen-team";
$addurl = 'newurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      if(isset($_GET['id'])){
        $pkid = $webhelper->RequestFilter("id", 0, false);
        $profile = $dbhelper->numOfRows('SELECT first FROM employee_profile WHERE pkid = ?', 'i', $pkid);
        if($profile > 0){
          $publish = $dbhelper->updateAll("UPDATE employee_profile SET status = 1 WHERE pkid = '$pkid'");
          $slugurl = $dbhelper->selectOne('SELECT slugurl FROM employee_profile WHERE pkid = ?', 'i', $pkid);
          if($publish){
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
            $sql = "select pkid, slugurl from employee_profile where pkid in( $pkid )";
            $List = $dbhelper->RunSQLReturnRows($sql);
            if(!empty($List)){
              foreach ($List as $row){
                  $slugurl = $row['slugurl'];
                  $publish = $dbhelper->updateAll("UPDATE employee_profile SET status = 1 WHERE pkid = " . $row["pkid"]);
                  include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
              }
              if($publish){
                include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
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
  echo "Nothing Here";
}