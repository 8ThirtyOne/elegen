<?php
include_once('../../../lcmodel/loadRegister.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');

if(isset($_POST['id']) && !empty($_POST['id'])){
    $id = $_POST['id'];
    $idExists = $dbhelper->selectOne('SELECT pkid FROM admin WHERE id = ?', 's', $id);
    if($idExists > 0){
        echo "1";
    }else{
        echo "0";
    }
}else{
    echo "Nothing here";
}