<?php
include_once('../lcmodel/loadPage.inc.php');
use lcmodel\webTools\webHelper;
$webhelper = new WebHelper();
$PageUrl = "/404";
$PageCode = "000000";
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Page Not Found | ELEGEN</title>
<meta name="robots" content="noodp" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main">
  
    <section class="wide-section no-margin" id="not-found">
 
           <div class="page-inner">

             <div class="center-paragraph">

                    <h2>500</h2>
                    <h3>Please try again later or feel free to contact us if the problem persists.</h3>

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
    