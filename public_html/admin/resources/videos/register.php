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
  if($input == 0){
    header('Location: /admin/');
    exit;
  }else{
   if($_FILES['thumbnail']['size'] == 0){
      header('Location: /admin/resources/videos/list?error=missingupload');
      exit;
   }else{
    $expected = array('title', 'youtubeurl', 'slugurl', 'description');
    $required = array('title', 'youtubeurl', 'slugurl', 'description');
    foreach($_POST as $key => $value){
      $temp = is_array($value) ? $value : trim($value);
      if(empty($temp) && in_array($key, $required)){
        array_push($missing, $key);
      }elseif(in_array($key, $expected)){
        ${$key} = $temp;
      }
      if(!empty($value)){
        if($key == 'description'){
           $input = $webhelper->RequestFilter($key,  -1, true);
        }else{
           $input = $webhelper->RequestFilter($key, 255, false);
        }
      }else{
        $input='none';
      }
      $data[$cnt] = $input;
      $cnt++;
   }//for loop
   if(empty($missing)){
      $urlExists = $dbhelper->numOfRows('SELECT pkid FROM videos WHERE slugurl = ?', 's', $data[2]);
      if($urlExists > 0){
        header('Location: /admin/resources/videos/list?error=urlfound');
        exit;
      }else{
        $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–','/');
        $slugUrl = str_replace($chars,"",$data[2]);
        $slugUrl = str_replace(" ","-",$slugUrl);
        $data[2] = strtolower($slugUrl);
        //file upload
        $thumbnail = $webhelper->UploadFile("thumbnail", "/videos/", true);
        $insert = $dbhelper->videoIn($data, $thumbnail["filename"]);
            if($insert){
              header('Location: /admin/resources/videos/list');
              exit;
            }else{
              header('Location: /admin/resources/videos/list?error=technicalissue');
              exit;
            }
       }//slug url already exists
     }else{
        header('Location: /admin/resources/videos/list?error=infomissing');
        exit;
     }
    }//check if file is uploaded
 }//check if logged in
}else{
  header('Location: /admin/');
  exit;
}