<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/company/careers";
$PageCode = "060101";
$bodyid = "company";
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Careers | ELEGEN</title>
<meta name="description" content="Elegen Careers" />
<meta name="keywords" content="synthetic biology, dna, gene, sequence, molecules" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">
 
   <section class="hero-section short-hero" id="careers-hero">

    <div class="page-inner">

          <section class="left-hero-content white-text">
              <h3>Be part of an amazing team</h3>
			  <h1>Careers</h1>
          </section>
 
    </section>
 
      <section class="wide-section no-margin bottom-space">
 
            <div class="page-inner">

               <div class="center-paragraph">

                  <div id="grnhse_app"></div>
               
               </div>

            </div>

      </section>
      
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/quick-request.php'); ?>
<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script src="https://boards.greenhouse.io/embed/job_board/js?for=elegen"></script>
</body>
</html>