<?php
include_once('../../../../libs/common.php');

$webhelper = new WebHelper();
$dbhelper = new dbHelper();

$PageUrl = "/admin/news/events/list.php";
$PageCode = "040103";
$webhelper->CheckAdminLogin($PageCode, urlencode($PageUrl), true);

//file upload
$desktop = $webhelper->UploadFile("desktop", "/heroes/", true);
$mobile = $webhelper->UploadFile("mobile", "/heroes/", true);

$status = 1;

$dbhelper->dbOpen();
$sql = "insert into hero_images(status, desktop, mobile, page_name, created) values 
        ('$status', '" . $desktop["filename"] . "', '" . $mobile["filename"] . "', 'events', now() )";
$dbhelper->RunSQL($sql);
$dbhelper->dbClose();

$webhelper->AlertMessageAndGo("", "/admin/news/events/list.php");