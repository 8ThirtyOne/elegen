<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$missing = array();
$error = array();
$cnt = 0;
$input='';
$data = array();
$insert = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
       if(!empty($_POST['type'])){
          $expected = array('type', 'source', 'url', 'title', 'subtitle', 'slugurl', 'description');
          $required = array('type', 'source', 'url', 'title', 'subtitle', 'slugurl', 'description');
          $isSlide = isset($_POST['sb'][0]) ? 1 : 0;
          $isBanner = isset($_POST['sb'][1]) ? 1 : 0;
          $fulldate = $webhelper->RequestFilter("fulldate", 10, false);
          $date = explode('-', $fulldate);
          foreach($_POST as $key => $value){
            if($key != 'fulldate' && $key != 'sb'){
            $temp = is_array($value) ? $value : trim($value);
            if(empty($temp) && in_array($key, $required)){
              array_push($missing, $key);
            }elseif(in_array($key, $expected)){
              ${$key} = $temp;
            }
            if(!empty($value)){
              if($key == 'page' || $key == 'order' || $key == 'type'){
               $input = (int)$key;
               $input = $webhelper->RequestFilter($key, 0, false);
              }elseif($key == 'description'){
                 $input = $webhelper->RequestFilter($key,  -1, true);
              }else{
                 $input = $webhelper->RequestFilter($key, 255, false);
              }
            }else{
              $input='none';
            }
            $data[$cnt] = $input;
            $cnt++;
           }
         }//for loop
         array_push($data, $date[0], $date[1], $date[2]);
         if(empty($missing)){
            $titleExists = $dbhelper->numOfRows('SELECT pkid FROM articles WHERE title = ?', 's', $data[3]);
            if($titleExists){
               header('Location: /admin/news-events/news?listerror=titlefound');
               exit;
            }else{
              $urlExists = $dbhelper->numOfRows('SELECT pkid FROM articles WHERE slugurl = ?', 's', $data[5]);
              if($urlExists > 0){
                header('Location: /admin/news-events/news/list?error=urlfound');
                exit;
              }else{
                  $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–');
                  $slugUrl = str_replace($chars,"",$data[5]);
                  $slugUrl = str_replace(" ","-",$slugUrl);
                  $data[5] = strtolower($slugUrl);
                  if($_FILES['thumbnail']['size'] == 0){
                    $thumbnail['filename'] = 'none';
                  }else{
                    $thumbnail = $webhelper->UploadFile("thumbnail", "/news/", true);
                  }
                  if($_FILES['up_file']['size'] == 0){
                    $filename['filename'] = 'none';
                    $filename['orgfilename'] = 'none';
                  }else{
                    $filename = $webhelper->UploadFile("up_file", "/news/");
                  }
                  $insert = $dbhelper->newsIn($data, $thumbnail["filename"], $filename["filename"], $filename["orgfilename"], $isSlide, $isBanner);
                if($insert){
                  header('Location: /admin/news-events/news/list');
                  exit;
                }else{
                  header('Location: /admin/news-evetns/newslist?error=technicalissue');
                  exit;
                }
             }//slug url already exists
            }//title already exists
           }else{
              header('Location: /admin/news-events/news/list?error=infomissing');
              exit;
           }
        }else{
           header('Location: /admin/news-events/news/list?error=typemissing');
           exit;
        }//check if type is set
    }
}else{
  header('Location: /admin/');
  exit;
}