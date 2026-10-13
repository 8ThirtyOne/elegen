<?php
include_once('../../../lcmodel/loadRegister.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$pkid = $webhelper->RequestFilter("pkid", 0, false);
if($webhelper->isNull($pkid)) $webhelper->AlertMessage("It is the wrong access.");
$sql = "select pkid, url_name, filename, orgfilename, permission from applications where status = 1 and pkid = " . $pkid;
$ViewData = $dbhelper->RunSQLReturnOneRow($sql);

if($ViewData == null)
    $webhelper->AlertMessageAndHistoryBack("Data is deleted or not Exist.");

if($ViewData["permission"] == 1)
{
    //public
    if(!$detect->isMobile() && !$detect->isTablet()){
      header("Location: /content/applications/".$ViewData["url_name"]);
      exit;
    }else{
     $webhelper->DownloadFile("/applications/", $ViewData["filename"], $ViewData["orgfilename"]);
    }
}else if($ViewData["permission"] == 2)
{
    //Register
    if($webhelper->isNull($webhelper->GetRegisterInfo()))
    {
        $webhelper->AlertMessageAndGo ("", "/resources/request-information-application-notes?pkid=$pkid");
    }else
    {
      if(!$detect->isMobile() && !$detect->isTablet()){
        header("Location: /content/applications/".$ViewData["url_name"]);
        exit;
      }else{
       $webhelper->DownloadFile("/applications/", $ViewData["filename"], $ViewData["orgfilename"]);
      }
    }
}else
{
    //user
    if($webhelper->isNull($webhelper->GetLoginPkid()))
        $webhelper->AlertMessageAndGo ("", "/user/login");
    else
        $webhelper->DownloadFile("/applications/", $ViewData["filename"], $ViewData["orgfilename"]);
}
?>
