<?php
include_once('../../../lcmodel/loadRegister.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');

if(isset($_POST['email']) && !empty($_POST['email'])){
    $id = $_POST['email'];
    $emailExists = $dbhelper->selectOne('SELECT pkid FROM admin WHERE email = ?', 's', $email);
    if($emailExists > 0){
        echo "1";
    }else{
        echo "0";
    }
}else{
    echo "Nothing here";
}