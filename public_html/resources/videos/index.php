<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/resources/vidoes";
$PageCode = "040102";
$bodyid = "resources";
$videos = $dbhelper->selectAll("SELECT * FROM videos WHERE status = 1 ORDER BY created DESC");
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'videos'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Videos | ELEGEN</title>
<meta name="description" content="ELEGEN Latest Videos" />
<link rel="canonical" href="https://elegen.8romans.com/resources/vidoes" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>
  .hero-section{
    background-repeat:no-repeat;
    background-position:left top;
  }
 <?php 
 if(!empty($hero["desktop"]) && $ext != 'mp4'){
  $desktopImg = $hero["desktop"];
  echo "
    .hero-section{background-image: url('/files/hero/$desktopImg');}";
 }
 if(!empty($hero["mobile"])){
  $mobileImg = $hero["mobile"];
 echo "@media all and (max-width: 845px) {
    .hero-section{background-image:url('/files/hero/$mobileImg');}";
  }
 ?>
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">
 
   <section class="hero-section short-hero" id="literature-hero">

    <div class="page-inner">

        <section class="left-hero-content white-text">
              <h3>View our latest videos</h3>
              <h1>Elegen Videos</h1>
          </section>
 
    </section>

    <section class="wide-section related-resources">

        <?php if($videos != null && count($videos) > 0){
           $total = count($videos);
        ?>

        <div class="page-inner">

        </div>

        <?php } ?>

     </section>
           
</main>
 
<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
</body>
</html>