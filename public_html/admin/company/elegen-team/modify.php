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
     $pkid = $webhelper->RequestFilter("pkid", 0, false);
     $profile = $dbhelper->numOfRows('SELECT first FROM employee_profile WHERE pkid = ?', 'i', $pkid);
     if($profile > 0){
        $status = $dbhelper->selectOne('SELECT status FROM employee_profile WHERE pkid = ?', 'i', $pkid);
        $expected = array('first', 'last', 'jobtitle', 'quote', 'pagebody');
        $required = array('first', 'last', 'jobtitle', 'quote', 'pagebody');
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
              $input = (int)$key;
              $input = $webhelper->RequestFilter($key, 0, false);
            }elseif($key == 'quote' || $key == 'pagebody' || $key == 'hobbytext'){
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
          $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–');
          $first = str_replace($chars,"",$data[5]);
          $last = str_replace($chars,"",$data[6]);
          $slugUrl = strtolower($first.' '.$last);
          $slugUrl = str_replace(" ","-",$slugUrl);
          $urlExists = 0;
          $record = $dbhelper->RunSQLReturnOneRow("SELECT slugurl FROM employee_profile WHERE pkid = '$pkid'");
          if($record['slugurl'] != $slugUrl){
            $urlExists = $dbhelper->numOfRows('SELECT pkid FROM employee_profile WHERE slugurl = ?', 's', $slugUrl);
          }
          if($urlExists > 0){
            header('Location: /admin/company/elegen-team/modifyFrm?error=slugurlexists');
            exit;
          }else{
            //file upload
            $headshot = $webhelper->UploadFile("headshot_img", "/team/", true);
            $oldheadshot = $data[3];
            if($headshot != null){
              if(!empty($oldheadshot))
                 $webhelper->DeleteFile("/team/", $oldheadshot);
                 $newHeadshotName = $headshot["filename"];
            }else{
              $newHeadshotName = $oldheadshot;
            }

            $hobbyImg = $webhelper->UploadFile("hobby_img", "/team/", true);
            $oldhobbyImg = $data[4];
            if($hobbyImg != null){
              if(!empty($oldhobbyImg))
                 $webhelper->DeleteFile("/team/", $oldhobbyImg);
                 $newHobbyImgName = $hobbyImg["filename"];
            }else{
              $newHobbyImgName = $oldhobbyImg;
            }

            $update = $dbhelper->updateAll("UPDATE employee_profile SET first ='$data[5]', last='$data[6]', job_title='$data[7]', quote='$data[8]', body='$data[9]', hobby='$data[10]', slugurl='$slugUrl', headshot='$newHeadshotName', hobby_thumb = '$newHobbyImgName', status = '$status', updated = NOW() WHERE pkid='$pkid'");
            if($update){
              if($data[1] == 'none') $data[1] = "";
              if($data[2] == 'none') $data[2] = 0;
              $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
              header('Location: /admin/company/elegen-team/list'.$Parameter);
              exit;
            }else{
              header('Location: /admin/company/elegen-team/list?error=technicalissue');
              exit;
            }
          }//check duplicate slugurl
       }else{
         header('Location: /admin/company/elegen-team/list?error=infomissing');
         exit;
       }
     }else{
       header('Location: /admin/company/elegen-team/list');
       exit;
     }//check if profile exists
   }//check user
}else{
  header('Location: /admin/');
  exit;
}