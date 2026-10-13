<?php
ini_set('session.use_only_cookies', TRUE);
ini_set('session.use_trans_sid', FALSE);
session_start();
ob_start();
ini_set("display_errors", 0);
header("Pragma: no-cache");
header("Cache: no-cache");
define('cdn', '');
date_default_timezone_set('america/los_angeles');
include_once('use_ssl.php');
include_once('load.inc.php');
include_once('webTools/Mobile_Detect.php');
$detect = new Mobile_Detect;

if(isset($_GET['lng']) && basename($_GET['lng']) == $_GET['lng']){
  $lng = $_GET['lng'] == 'en' ? 'english' : '';
  $_SESSION['lng-pref'] = $lng;
}