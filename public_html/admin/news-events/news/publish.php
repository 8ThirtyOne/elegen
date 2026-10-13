<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$publish = false;
$dir = "content/articles";
$addurl = 'newurl';
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      if(isset($_GET['id'])){
        $pkid = $webhelper->RequestFilter("id", 0, false);
        $titleExists = $dbhelper->numOfRows('SELECT title FROM articles WHERE pkid = ?', 'i', $pkid);
        if($titleExists > 0){
          $publish = $dbhelper->updateAll("UPDATE articles SET status = 1 WHERE pkid = '$pkid'");
          $article = $dbhelper->RunSQLReturnOneRow("SELECT slugurl, filename FROM articles WHERE pkid = $pkid");
          $slugurl = $article['slugurl'];
          if($publish){
            //check if has no pdf file, then it's elegen slugurl
            if($article['filename'] != 'none') include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
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
            $sql = "select pkid, slugurl, filename from articles where pkid in( $pkid )";
            $List = $dbhelper->RunSQLReturnRows($sql);
            if(!empty($List)){
              foreach ($List as $row){
                $slugurl = $row['slugurl'];
                $publish = $dbhelper->updateAll("UPDATE articles SET status = 1 WHERE pkid = " . $row["pkid"]);
                if($row['filename'] != 'none') include($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/sitemap-update.php');
              }
              if($publish){
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