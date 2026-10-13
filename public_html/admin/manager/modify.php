<?php 
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$missing = array();
$error = array();
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
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
    if(!empty($_POST['pkid']) && !empty($_POST['username']) && !empty($_POST['email'])){
      if(!empty($_POST['type'])){
      $expected = array('username', 'email', 'first', 'last', 'organization', 'country', 'state', 'city', 'zip', 'phone');
      $required = array('username', 'email', 'first', 'last', 'organization', 'country', 'state', 'city', 'zip', 'phone');
        $status = $webhelper->RequestFilter('status', 0, false);
        $administrator = isset($_POST['type'][0]) ? 1 : 0;
        $editor = isset($_POST['type'][1]) ? 1 : 0;
        $hr = isset($_POST['type'][2]) ? 1 : 0;
      foreach($_POST as $key => $value){
        if($key != 'type'){
          $temp = is_array($value) ? $value : trim($value);
          if(empty($temp) && in_array($key, $required)){
            array_push($missing, $key);
          }elseif(in_array($key, $expected)){
            ${$key} = $temp;
          }
          if(!empty($value)){
            if($key == 'pkid' && $key == 'status' && $key == 'type'){
               $input = $webhelper->RequestFilter($key, 0, false);
            }else if($key == 'username' && $key == 'zip' && $key == 'phone'){
               $input = $webhelper->RequestFilter($key, 50, false);
            }else{
               $input = $webhelper->RequestFilter($key, 100, false);
            }
          }else{
            $input=0;
          }//close value check
          $data[$cnt] = $input;
          $cnt++;
         }
       }//for loop
      if(empty($missing)){
        $checkId = $dbhelper->numOfRows('SELECT id FROM admin WHERE pkid = ?', 'i', $data[0]);
        if($checkId > 0){
          if(!$webhelper->validUsername($data[1]) || !$webhelper->validEmail($data[2])){
             echo "2";
          }else{
            $member = $dbhelper->RunSQLReturnOneRow("SELECT id, email FROM admin WHERE pkid = $data[0]");
            $userExists = 0;
            $emailExists = 0;
            if($data[1] != $member['id']){
               $userExists = $dbhelper->numOfRows('SELECT pkid FROM admin WHERE id = ?', 's', $data[1]);
            }
            if($data[2] != $member['email']){
               $emailExists = $dbhelper->numOfRows('SELECT pkid FROM admin WHERE email = ?', 's', $data[2]);
            }
            if($userExists > 0 || $emailExists > 0){
              echo "3";
            }else{
            $update = $dbhelper->updateAll("UPDATE admin SET id='$data[1]', email='$data[2]', firstname='$data[4]', lastname='$data[5]', company='$data[6]', country='$data[7]', 
               providence='$data[8]', city='$data[9]', postcode='$data[10]', 
                phone='$data[11]', isAdministrator='$administrator', isEditor='$editor',
                 isHR='$hr', status='$status' WHERE pkid='$data[0]'");
              if($update){
                echo "1";
              }else{
                echo "0";
              }
           }//username or email already exists
          }//username and email validity check
         }else{
           echo "0";
         }
       }else{
         echo "5";
       }
      }else{
        echo "6";
      }
    }else{
     echo "0";
    }
   }else{
    echo "0";
   }
  }
}else{
  echo "Nothing Here.";
}