<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/lib/common.php');

$webhelper = new WebHelper();
$dbhelper = new dbHelper();

$PageUrl = "/admin/news/events/list.php";
$PageCode = "040103";
$webhelper->CheckAdminLogin($PageCode, urlencode($PageUrl), true);

//Parameter
$year = $webhelper->RequestFilter("year", 4, false);
$startmonth = $webhelper->RequestFilter("startmonth", 2, false);
$startday = $webhelper->RequestFilter("startday", 2, false);
$endmonth = $webhelper->RequestFilter("endmonth", 2, false);
$endday = $webhelper->RequestFilter("endday", 2, false);
$maintitle = $webhelper->RequestFilter("maintitle", 200, false);
$subtitle = $webhelper->RequestFilter("subtitle", 1000, false);
$url = $webhelper->RequestFilter("url", 500, false);
$url2 = $webhelper->RequestFilter("url2", 500, false);
$location1 = $webhelper->RequestFilter("location1", 100, false);
$location2 = $webhelper->RequestFilter("location2", 100, false);
$boothnum = $webhelper->RequestFilter("boothnum", 50, false);
$body = $webhelper->RequestFilter("body", -1, true);

//check parameter
if($webhelper->isNull($year)) $webhelper->AlertMessage("Error. Please try again.");
if($webhelper->isNull($startmonth)) $webhelper->AlertMessage("Error. Please try again.");
if($webhelper->isNull($startday)) $webhelper->AlertMessage("Error. Please try again.");
if($webhelper->isNull($endmonth)) $webhelper->AlertMessage("Error. Please try again.");
if($webhelper->isNull($endday)) $webhelper->AlertMessage("Error. Please try again.");
if($webhelper->isNull($maintitle)) $webhelper->AlertMessage("Error. Please try again.");
if($webhelper->isNull($subtitle)) $webhelper->AlertMessage("Error. Please try again.");

//file upload
$thumbnail = $webhelper->UploadFile("thumbnail", "/events/", true);
$file = $webhelper->UploadFile("up_file", "/events/");

$status = 0;

$dbhelper->dbOpen();
$sql = "insert into events(year, startmonth, startday, endmonth, endday, maintitle, subtitle, url, url2, location1, location2, booth, status, body, thumbnail, filename, orgfilename, updatedate) values 
        ('$year', '$startmonth', '$startday', '$endmonth', '$endday', '$maintitle', '$subtitle', '$url', '$url2', '$location1', '$location2', '$boothnum', '$status', '$body', '" . $thumbnail["filename"] . "', '" . $file["filename"] . "', '" . $file["orgfilename"] . "', now() )";
$dbhelper->RunSQL($sql);
$dbhelper->dbClose();

$webhelper->AlertMessageAndGo("", "/admin/news/events/list.php");
?>