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
      if($_FILES['thumbnail']['size'] == 0){
        header('Location: /admin/news-events/events/list?error=missingthumbnail');
        exit;
      }else{
       if(!empty($_POST['type'])){
          $expected = array('type', 'title', 'subtitle', 'address', 'locationone', 'url', 'booth', 'eventurl', 'description');
          $required = array('type', 'title', 'subtitle', 'address', 'locationone', 'url', 'booth', 'eventurl', 'description');
          $startdate = $webhelper->RequestFilter("startdate", 10, false);
          $enddate = $webhelper->RequestFilter("enddate", 10, false);
          $start = explode('-', $startdate);
          $end = explode('-', $enddate);
          foreach($_POST as $key => $value){
            if($key != 'startdate' && $key != 'enddate'){
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
         }//end loop
         //add strat date and end date at the end of data array
         array_push($data, $start[0], $start[1], $start[2], $end[0], $end[1]);
         if(empty($missing)){
            $titleExists = $dbhelper->numOfRows('SELECT pkid FROM events WHERE title = ?', 's', $data[1]);
            if($titleExists){
               header('Location: /admin/news-events/events?listerror=titlefound');
               exit;
            }else{
              $urlExists = $dbhelper->numOfRows('SELECT pkid FROM events WHERE eventurl = ?', 's', $data[7]);
              if($urlExists > 0){
                header('Location: /admin/news-events/events/list?error=slugurlfound');
                exit;
              }else{
                  $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–');
                  $slugUrl = str_replace($chars,"",$data[7]);
                  $slugUrl = str_replace(" ","-",$slugUrl);
                  $data[7] = strtolower($slugUrl);
                  $thumbnail = $webhelper->UploadFile("thumbnail", "/events/", true);
                  if($_FILES['up_file']['size'] == 0){
                    $filename['filename'] = 'none';
                    $filename['orgfilename'] = 'none';
                  }else{
                    $filename = $webhelper->UploadFile("up_file", "/events/");
                  }
                  $insert = $dbhelper->eventIn($data, $thumbnail["filename"], $filename["filename"], $filename["orgfilename"]);
                if($insert){
                  header('Location: /admin/news-events/events/list');
                  exit;
                }else{
                  header('Location: /admin/news-evetns/events?error=technicalissue');
                  exit;
                }
             }//slug url already exists
            }//title already exists
           }else{
              header('Location: /admin/news-events/events/list?error=infomissing');
              exit;
           }
        }else{
           header('Location: /admin/news-events/events/list?error=typemissing');
           exit;
        }//check if type is set
      }
    }
}else{
  header('Location: /admin/');
  exit;
}