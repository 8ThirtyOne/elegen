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
    if(!empty($_POST['type'])){
     $pkid = $webhelper->RequestFilter("pkid", 0, false);
     $resource = $dbhelper->numOfRows('SELECT title FROM literatures WHERE pkid = ?', 'i', $pkid);
     if($resource > 0){
       if(($_FILES['thumbnail']['size'] == 0 && $_FILES['up_file']['size'] == 0) && (empty($_POST['oldthumbnail']) && empty($_POST['oldfile']))){
          header('Location: /admin/resources/literatures/list?error=missingupload');
          exit;
       }else{
          $expected = array('type', 'title', 'slugurl', 'description', 'keywords');
          $required = array('type', 'title', 'slugurl', 'keywords');
          $fulldate = $webhelper->RequestFilter("fulldate", 10, false);
          $date = explode('-', $fulldate);
          $permission = $webhelper->RequestFilter("permission", 0, false);
          foreach($_POST as $key => $value){
            if($key != 'pkid' && $key != 'pkids' && $key != 'permission' && $key != 'fulldate'){
            $temp = is_array($value) ? $value : trim($value);
            if(empty($temp) && in_array($key, $required)){
              array_push($missing, $key);
            }elseif(in_array($key, $expected)){
              ${$key} = $temp;
            }
            if(!empty($value)){
              if($key == 'page' && $key == 'order'){
                $input = $webhelper->RequestFilter($key, 0, false);
              }elseif($key == 'searchKey' && $key == 'description'){
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
            $doc = $dbhelper->RunSQLReturnOneRow("SELECT title, slugurl FROM literatures WHERE pkid = '$pkid'");
            $titleExists = 0;
            $urlExists = 0;
            if($doc['title'] != $data[7]){
              $titleExists = $dbhelper->numOfRows('SELECT pkid FROM literatures WHERE title = ?', 's', $data[7]);
            }
            if($doc['slugurl'] != $data[8]){
               $urlExists = $dbhelper->numOfRows('SELECT pkid FROM literatures WHERE slugurl = ?', 's', $data[8]);
            }
            if($urlExists > 0){
                header('Location: /admin/resources/literatures/list?error=slugurlfound');
                exit;
            }else{
                $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–');
                $slugUrl = str_replace($chars,"",$data[8]);
                $slugUrl = str_replace(" ","-",$slugUrl);
                $data[8] = strtolower($slugUrl);
                //file upload
                $thumbnail = $webhelper->UploadFile("thumbnail", "/literatures/", true);
                $oldthumbnail = $data[3];
                if($thumbnail != null){
                  if(!empty($oldthumbnail))
                      $webhelper->DeleteFile("/literatures/", $oldthumbnail);
                      $newThumbnailFileName = $thumbnail["filename"];
                }else{
                    $newThumbnailFileName = $oldthumbnail;
                }

                $file = $webhelper->UploadFile("up_file", "/literatures/");
                $oldfile = $data[4];
                if($file != null){
                    if(!empty($oldfile))
                      $webhelper->DeleteFile("/literatures/", $oldfile);
                      $newFileName = $file["filename"];
                      $newOrgFileName = $file["orgfilename"];
                }else{
                    $newFileName = $oldfile;
                    $newOrgFileName = $data[5];
                }
                $update = $dbhelper->updateAll("UPDATE literatures SET type='$data[6]', title='$data[7]', slugurl='$data[8]', body='$data[9]', keywords='$data[10]', month='$data[11]', day='$data[12]', year='$data[13]', thumbnail='$newThumbnailFileName', filename = '$newFileName', orgfilename = '$newOrgFileName', permission = '$permission', updatedate = NOW() WHERE pkid='$pkid'");
                    if($update){
                      if($data[1] == 'none') $data[1] = "";
                      if($data[2] == 'none') $data[2] = 0;
                      $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
                      header('Location: /admin/resources/literatures/list'.$Parameter);
                      exit;
                    }else{
                      header('Location: /admin/resources/literatures/list?error=technicalissue');
                      exit;
                    }
             }//title or url already exists
         }else{
           header('Location: /admin/resources/literatures/list?error=infomissing');
           exit;
         }
       }//check if file is uploaded
     }else{
       header('Location: /admin/resources/literatures/list');
       exit;
     }//check if resource exists
    }else{
      header('Location: /admin/resources/literatures/list?error=typemissing');
      exit;
    }//check which type
  }
}else{
  header('Location: /admin/');
  exit;
}