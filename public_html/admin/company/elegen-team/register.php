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
      if($_FILES['headshot_img']['size'] == 0){
         header('Location: /admin/company/elegen-team/registerFrm?error=missingupload');
         exit;
      }else{
        $expected = array('first', 'last', 'jobtitle', 'quote', 'pagebody');
        $required = array('first', 'last', 'jobtitle', 'quote', 'pagebody');
        foreach($_POST as $key => $value){
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
        }//for loop
        if(empty($missing)){
          $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–');
          $first = str_replace($chars,"",$data[0]);
          $last = str_replace($chars,"",$data[1]);
          $slugUrl = strtolower($first.' '.$last);
          $slugUrl = str_replace(" ","-",$slugUrl);
           $urlExists = $dbhelper->numOfRows('SELECT pkid FROM employee_profile WHERE slugurl = ?', 's', $slugUrl);
            if($urlExists > 0){
              header('Location: /admin/company/elegen-team/list?error=slugurlfound');
              exit;
            }else{
                if($_FILES['headshot_img']['size'] == 0){
                  $headshotImg['filename'] = 'none';
                }else{
                  $headshotImg = $webhelper->UploadFile("headshot_img", "/team/", true);
                }
                if($_FILES['hobby_img']['size'] == 0){
                  $hobbyImg['filename'] = 'none';
                }else{
                  $hobbyImg = $webhelper->UploadFile("hobby_img", "/team/", true);
                }
                
                $insert = $dbhelper->teamIn($data, $headshotImg["filename"], $hobbyImg["filename"], $slugUrl);
              if($insert){
                header('Location: /admin/company/elegen-team/list');
                exit;
              }else{
                header('Location: /admin/company/elegen-team/list?error=technicalissue');
                exit;
              }
           }//slug url already exists
         }else{
            header('Location: /admin/company/elegen-team/list?error=infomissing');
            exit;
         }
     }//check if headshot is uploaded
   }
}else{
  header('Location: /admin/');
  exit;
}