<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\webTools\webHelper;
if(isset($_SESSION['request']) && !empty($_SESSION['request'])){
$webhelper = new WebHelper();
$PageUrl = "/support/thank-you";
$PageCode = "050107";
$bodyid = "support";
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
}else{
 header('Location: /');
 exit();
}
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Thank You | ELEGEN</title>
<meta name="robots" content="noodp" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main">
  
    <section class="wide-section no-margin" id="thank-you-section">
 
           <div class="page-inner">

             <div class="center-paragraph">

                    <h2>Thank You</h2>
                    <h3>Thank you for your interest in Elegen. Our representative will get in touch soon.</h3>

                    <?php 
                     if(isset($_SESSION['request'])){
                       unset($_SESSION['request']);
                     }
                    ?>

             </div>
 
          </div>
 
      </section>
           
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/quick-request.php'); ?>
<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
</body>
</html>
    