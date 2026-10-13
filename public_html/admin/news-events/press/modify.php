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
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
    if(!empty($_POST['type'])){
     $pkid = $webhelper->RequestFilter("pkid", 0, false);
     $press = $dbhelper->numOfRows('SELECT title FROM press WHERE pkid = ?', 'i', $pkid);
     if($press > 0){
        $expected = array('type', 'source', 'url', 'maintitle', 'subtitle', 'slugurl', 'description');
        $required = array('type', 'source', 'url', 'maintitle', 'subtitle', 'slugurl', 'description');
        $fulldate = $webhelper->RequestFilter("fulldate", 10, false);
        $date = explode('-', $fulldate);
        foreach($_POST as $key => $value){
          if($key != 'pkid' && $key != 'pkids' && $key != 'fulldate'){
            $temp = is_array($value) ? $value : trim($value);
          if(empty($temp) && in_array($key, $required)){
            array_push($missing, $key);
          }elseif(in_array($key, $expected)){
            ${$key} = $temp;
          }
          if(!empty($value)){
            if($key == 'page' && $key == 'order' && $key == 'type'){
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
         array_push($data, $date[0], $date[1], $date[2]);
         if(empty($missing)){
            $doc = $dbhelper->RunSQLReturnOneRow("SELECT title, slugurl FROM press WHERE pkid = '$pkid'");
            $urlExists = 0;
            if($doc['slugurl'] != $data[10]){
               $urlExists = $dbhelper->numOfRows('SELECT pkid FROM press WHERE slugurl = ?', 's', $data[11]);
            }
            if($urlExists > 0){
                header('Location: /admin/news-events/press/list?error=titleurlfound');
                exit;
            }else{
                $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–');
                $slugUrl = str_replace($chars,"",$data[11]);
                $slugUrl = str_replace(" ","-",$slugUrl);
                $data[11] = strtolower($slugUrl);
                //file upload
                $thumbnail = $webhelper->UploadFile("thumbnail", "/news/", true);
                $oldthumbnail = $data[3];
                if($thumbnail != null){
                  if(!empty($oldthumbnail))
                      $webhelper->DeleteFile("/news/", $oldthumbnail);
                      $newThumbnailFileName = $thumbnail["filename"];
                }else{
                    $newThumbnailFileName = $oldthumbnail;
                }

                $file = $webhelper->UploadFile("up_file", "/news/");
                $oldfile = $data[4];
                if($file != null){
                    if(!empty($oldfile))
                      $webhelper->DeleteFile("/news/", $oldfile);
                      $newFileName = $file["filename"];
                      $newOrgFileName = $file["orgfilename"];
                }else{
                    $newFileName = $oldfile;
                    $newOrgFileName = $data[5];
                }
                $update = $dbhelper->updateAll("UPDATE press SET type='$data[6]', source='$data[7]', url='$data[8]', title='$data[9]', subtitle='$data[10]', slugurl='$data[11]', body='$data[12]', month='$data[13]', day='$data[14]', year='$data[15]', thumbnail='$newThumbnailFileName', filename = '$newFileName', orgfilename = '$newOrgFileName', updatedate = NOW() WHERE pkid='$pkid'");
                    if($update){
                      if($data[1] == 'none') $data[1] = "";
                      if($data[2] == 'none') $data[2] = 0;
                      $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
                      header('Location: /admin/news-events/press/list'.$Parameter);
                      exit;
                    }else{
                      header('Location: /admin/news-events/press/list?error=technicalissue');
                      exit;
                    }
             }//slugurl already exists
         }else{
           header('Location: /admin/news-events/press/list?error=infomissing');
           exit;
         }
     }else{
       header('Location: /admin/news-events/press/list');
       exit;
     }//check if resource exists
    }else{
      header('Location: /admin/news/press/list?error=typemissing');
      exit;
    }//check which type
  }//check user
}else{
  header('Location: /admin/');
  exit;
}