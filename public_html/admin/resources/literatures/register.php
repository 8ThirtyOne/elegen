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
  if(!empty($_POST['type'])){
   if($_FILES['thumbnail']['size'] == 0 && $_FILES['up_file']['size'] == 0){
      header('Location: /admin/resources/literatures/list?error=missingupload');
      exit;
   }else{
    $expected = array('type', 'title', 'slugurl', 'description', 'keywords');
    $required = array('type', 'title', 'slugurl', 'keywords');
    $fulldate = $webhelper->RequestFilter("fulldate", 10, false);
    $date = explode('-', $fulldate);
    $permission = $webhelper->RequestFilter("permission", 0, false);
    foreach($_POST as $key => $value){
      if($key != 'permission' && $key != 'fulldate'){
      $temp = is_array($value) ? $value : trim($value);
      if(empty($temp) && in_array($key, $required)){
        array_push($missing, $key);
      }elseif(in_array($key, $expected)){
        ${$key} = $temp;
      }
      if(!empty($value)){
        if($key == 'type'){
           $input = $webhelper->RequestFilter($key,  0, true);
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
      $titleExists = $dbhelper->numOfRows('SELECT pkid FROM literatures WHERE title = ?', 's', $data[1]);
      if($titleExists){
         header('Location: /admin/resources/literatures/list?error=titlefound');
         exit;
      }else{
        $urlExists = $dbhelper->numOfRows('SELECT pkid FROM literatures WHERE slugurl = ?', 's', $data[2]);
        if($urlExists > 0){
          header('Location: /admin/resources/literatures/list?error=urlfound');
          exit;
        }else{
          $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–');
          $slugUrl = str_replace($chars,"",$data[2]);
          $slugUrl = str_replace(" ","-",$slugUrl);
          $data[2] = strtolower($slugUrl);
          //file upload
          $thumbnail = $webhelper->UploadFile("thumbnail", "/literatures/", true);
          $file = $webhelper->UploadFile("up_file", "/literatures/");
          $insert = $dbhelper->documentIn($data, $thumbnail["filename"], $file["filename"], $file["orgfilename"], $permission);
              if($insert){
                header('Location: /admin/resources/literatures/list');
                exit;
              }else{
                header('Location: /admin/resources/literatures/list?error=technicalissue');
                exit;
              }
       }//slug url already exists
      }//title already exists
     }else{
        header('Location: /admin/resources/literatures/list?error=infomissing');
        exit;
     }
    }//check if file is uploaded
  }else{
     header('Location: /admin/resources/literatures/list?error=typemissing');
     exit;
  }//check if type is set
 }//check id seesion is not 0
}else{
  header('Location: /admin/');
  exit;
}