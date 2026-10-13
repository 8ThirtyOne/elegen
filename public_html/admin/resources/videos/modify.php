<?php 
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$missing = array();
$cnt = 0;
$input='';
$data = array();
$update = false;
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   if($input == 0){
     header('Location: /admin/');
     exit;
   }else{
     $pkid = $webhelper->RequestFilter("pkid", 0, false);
     $video = $dbhelper->numOfRows('SELECT title FROM videos WHERE pkid = ?', 'i', $pkid);
     if($video > 0){
        $expected = array('title', 'youtubeurl', 'slugurl', 'description');
        $required = array('title', 'youtubeurl', 'slugurl', 'description');
        foreach($_POST as $key => $value){
          if($key != 'pkid' && $key != 'pkids'){
          $temp = is_array($value) ? $value : trim($value);
          if(empty($temp) && in_array($key, $required)){
            array_push($missing, $key);
          }elseif(in_array($key, $expected)){
            ${$key} = $temp;
          }
          if(!empty($value)){
            if($key == 'page' || $key == 'order'){
              $input = $webhelper->RequestFilter($key, 0, false);
            }elseif($key == 'searchKey' || $key == 'description'){
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
       if(empty($missing)){
          $doc = $dbhelper->RunSQLReturnOneRow("SELECT slugurl FROM videos WHERE pkid = '$pkid'");
          $urlExists = 0;
          if($doc['slugurl'] != $data[6]){
             $urlExists = $dbhelper->numOfRows('SELECT pkid FROM videos WHERE slugurl = ?', 's', $data[6]);
          }
          if($urlExists > 0){
              header('Location: /admin/resources/videos/list?error=slugurlfound');
              exit;
          }else{

              $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–','/');
              $slugUrl = str_replace($chars,"",$data[6]);
              $slugUrl = str_replace(" ","-",$slugUrl);
              $data[6] = strtolower($slugUrl);
              $thumbnail = $webhelper->UploadFile("thumbnail", "/videos/", true);
              $oldthumbnail = $data[3];
              if($thumbnail != null){
                if(!empty($oldthumbnail))
                   $webhelper->DeleteFile("/videos/", $oldthumbnail);
                   $newThumbnailFileName = $thumbnail["filename"];
              }else{
                $newThumbnailFileName = $oldthumbnail;
              }
              $update = $dbhelper->updateAll("UPDATE videos SET title='$data[4]', youtube_url = '$data[5]', slugurl='$data[6]', body='$data[7]', thumbnail='$newThumbnailFileName', updated = NOW() WHERE pkid='$pkid'");
                  if($update){
                    if($data[1] == 'none') $data[1] = "";
                    if($data[2] == 'none') $data[2] = 0;
                    $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
                    header('Location: /admin/resources/videos/list'.$Parameter);
                    exit;
                  }else{
                    header('Location: /admin/resources/videos/list?error=technicalissue');
                    exit;
                  }
           }//title or url already exists
       }else{
         header('Location: /admin/resources/videos/list?error=infomissing');
         exit;
       }
     }else{
       header('Location: /admin/resources/videos/list');
       exit;
     }//check if video exists
  }
}else{
  header('Location: /admin/');
  exit;
}