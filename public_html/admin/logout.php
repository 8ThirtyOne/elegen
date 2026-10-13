<?php
include_once('../../lcmodel/loadRegister.inc.php');

if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
	ob_end_flush();
	unset($_SESSION['user']);
	$_SESSION = array();
	session_destroy();
	header('Location: /admin/');
  exit;
}else{
  header('Location: /admin/');
  exit;
}