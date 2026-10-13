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
      $event = $dbhelper->numOfRows('SELECT title FROM events WHERE pkid = ?', 'i', $pkid);
      if($event > 0){
        $status = $dbhelper->selectOne('SELECT status FROM events WHERE pkid = ?', 'i', $pkid);
        $expected = array('type', 'title', 'subtitle', 'address', 'locationone', 'url', 'booth', 'eventurl', 'description');
          $required = array('type', 'title', 'subtitle', 'address', 'locationone', 'url', 'booth', 'eventurl', 'description');
        $startdate = $webhelper->RequestFilter("startdate", 10, false);
        $enddate = $webhelper->RequestFilter("enddate", 10, false);
        $start = explode('-', $startdate);
        $end = explode('-', $enddate);
        foreach($_POST as $key => $value){
          if($key != 'pkid' && $key != 'pkids' && $key != 'startdate' && $key != 'enddate'){
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
            }elseif($key == 'searchKey' || $key == 'description'){
               $input = $webhelper->RequestFilter($key,  -1, true);
            }elseif($key == 'url'){
               $input = $webhelper->RequestFilter($key, 500, false);
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
         //add strat date and end date at the end of data array
         array_push($data, $start[0], $start[1], $start[2], $end[0], $end[1]);
         if(empty($missing)){
            $doc = $dbhelper->RunSQLReturnOneRow("SELECT title, eventurl FROM events WHERE pkid = '$pkid'");
            $urlExists = 0;
            if($doc['eventurl'] != $data[13]){
               $urlExists = $dbhelper->numOfRows('SELECT pkid FROM events WHERE eventurl = ?', 's', $data[13]);
            }
            if($urlExists > 0){
                header('Location: /admin/news-events/events/list?error=titleurlfound');
                exit;
            }else{
              $chars = array('@', ',', '!', '"',':','|',"'",' - ','.','?','#','–');
              $slugUrl = str_replace($chars,"",$data[13]);
              $slugUrl = str_replace(" ","-",$slugUrl);
              $data[13] = strtolower($slugUrl);
              //file upload
              $thumbnail = $webhelper->UploadFile("thumbnail", "/events/", true);
              $oldthumbnail = $data[3];
              if($thumbnail != null){
                if(!empty($oldthumbnail))
                    $webhelper->DeleteFile("/events/", $oldthumbnail);
                    $newThumbnailFileName = $thumbnail["filename"];
              }else{
                  $newThumbnailFileName = $oldthumbnail;
              }

              $file = $webhelper->UploadFile("up_file", "events/");
              $oldfile = $data[4];
              if($file != null){
                  if(!empty($oldfile))
                    $webhelper->DeleteFile("/events/", $oldfile);
                    $newFileName = $file["filename"];
                    $newOrgFileName = $file["orgfilename"];
              }else{
                  $newFileName = $oldfile;
                  $newOrgFileName = $data[5];
              }
              $update = $dbhelper->updateAll("UPDATE events SET type='$data[6]', title='$data[7]', subtitle='$data[8]', address='$data[9]', location1='$data[10]', eventurl='$data[13]', startmonth='$data[15]', startday='$data[16]', endmonth='$data[18]', endday='$data[19]', year='$data[17]', url='$data[11]', booth='$data[12]',body='$data[14]', thumbnail='$newThumbnailFileName', filename = '$newFileName', orgfilename = '$newOrgFileName', status = '$status', updatedate = NOW() WHERE pkid='$pkid'");
                if($update){
                  if($data[1] == 'none') $data[1] = "";
                  if($data[2] == 'none') $data[2] = 0;
                  $Parameter = "?page=$data[0]&searchKey=$data[1]&order=$data[2]";
                  header('Location: /admin/news-events/events/list'.$Parameter);
                  exit;
                }else{
                  header('Location: /admin/news-events/events/list?error=technicalissue');
                  exit;
                }
            }//title or url already exists
         }else{
           header('Location: /admin/news-events/events/list?error=infomissing');
           exit;
         }
       }else{
         header('Location: /admin/news-events/events/list');
         exit;
       }//check if event exists
     }else{
       header('Location: /admin/news-events/events/list?error=typemissing');
       exit;
     }//check if type
   }//check user
}else{
  header('Location: /admin/');
  exit;
}