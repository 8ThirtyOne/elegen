<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/company/investors";
$PageCode = "060101";
$bodyid = "company";
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Investors | ELEGEN</title>
<meta name="description" content="Elegen Investors" />
<meta name="keywords" content="synthetic biology, dna, gene, sequence, molecules" />
<link rel="canonical" href="https://www.elegenbio.com/company/investors" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">
 
   <section class="hero-section short-hero" id="investors-hero">

    <div class="page-inner">

          <section class="left-hero-content white-text">
              <!--<h3><span class="elegen-green-text">ELEGEN</span></h3>-->
              <h1>Our Investors</h1>
              <!--<p id="hero-note-right">LONG DNA WITHOUT THE WAIT</p>-->
          </section>
 
    </section>
	   
	  <p>&nbsp;</p>
 
      <section class="wide-section no-margin bottom-space">
 
            <div class="page-inner">

               <div class="center-paragraph">
               
               </div>

            </div>

      </section>

      <section class="wide-section no-margin investors-section">
 
            <div class="page-inner narrow-section">   
          
               <div class="col3 left" id="investors">

                  <div class="col-box white-box">

                      <div class="center-icon">
                        <img src="/img/company/andreessen-horowitz-logo.jpg">
                      </div>

                      <div class="green-box-desc">
                      <p>&nbsp;</p>
                      </div>


                  </div>

               </div>

               <div class="col3 left">

                  <div class="col-box white-box">

                    <div class="center-icon">
                        <img src="/img/company/kdt-ventures-logo.jpg">
                      </div>

                      <div class="green-box-desc">
                      <p>&nbsp;</p>
                      </div>


                  </div>

               </div>

               <div class="col3 left">

                  <div class="col-box white-box">

                    <div class="center-icon">
                        <img src="/img/company/8vc-logo2.jpg">
                      </div>

                      <div class="green-box-desc">
                      <p>&nbsp;</p>

                      </div>


                  </div>

               </div>

            </div>

        </section>

        <section class="wide-section no-margin investors-section investors-col2">
 
            <div class="page-inner narrow-section"> 

              <div class="center-paragraph">

               <div class="left-paragraph text-paragraph">

                  <div class="col-box white-box">

                   <div class="center-icon">
                        <img src="/img/company/ame-cloud-logo2.jpg">
                      </div>

                      <div class="green-box-desc">
                      <p>&nbsp;</p>

                      </div>

                  </div>

               </div>

               <div class="right-paragraph text-paragraph">

                  <div class="col-box white-box">

                  <div class="center-icon">
                        <img src="/img/company/y-combinator-logo2.jpg">
                      </div>

                      <div class="green-box-desc">
                      <p>&nbsp;</p>
                      </div>

                  </div>

               </div>

             </div>

            </div>

        </section>
      
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/quick-request.php'); ?>
<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script>
      $("#press-release ul").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: !0,
    autoplaySpeed: 4E3,
    centerPadding: 0,
    pauseOnFocus: !1,
    pauseOnHover: !0,
    slide: "li",
    vertical: !0
  });
</script>
</body>
</html>