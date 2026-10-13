<?php
include_once('../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/";
$PageCode = "000000";
$ip = $webhelper->catchIP();
$bodyid = "main";
$PageName = "Home";
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
if(!isset($bodyid))
    $bodyid = "main";
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Delivering Industry-leading DNA | ELEGEN</title>
<meta name="description" content="Elegen helps researchers and builders of the new bioecoomy turn their imagination into reality with fast-turnaround, high quality long, synthetic DNA." />
<meta name="keywords" content="synthetic biology, dna, gene, sequence, molecules" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?> 
<style>
  .grecaptcha-badge{display:none}
  @media all and (max-width: 845px) {
  .slide-1{background-image: url('/img/main/hero-m-main-fast-01b.jpg')}
  .slide-2{background-image: url('/img/main/hero-m-main-no-cloning-01b.jpg')}
  .slide-3{background-image: url('/img/main/hero-m-main-accuracy-01b.jpg')}
  }
</style>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">
 
   <section class="hero-section" id="main-hero">

       <div class="animate slide-1">

        <div class="page-inner">

          <section class="left-hero-content white-text">
            <img src="/img/common/Icon-Elegen-Full.svg" class="hero-logo" />
              <p><span class="line-break elegen-green-text">High Fidelity DNA</span></p>
              <h3>Delivering industry-leading</h3>
              <h1>SPEED, LENGTH and QUALITY</h1>
              <p>Elegen reliably delivers DNA up to 7kb with more than 95% of the molecules sequence perfect in just 7 business days.</span></p>
              <a href="https://ecommerce.elegen.com/login" class="global-btn green-btn smooth-hover">ORDER NOW</a>
          </section>
              
        </div>

     </div>

          <div class="animate slide-2">
 
          <div class="page-inner">

          <section class="left-hero-content white-text">
              <img src="/img/common/Icon-Elegen-Full.svg" class="hero-logo" />
              <p><span class="line-break elegen-green-text">High Fidelity DNA</span></p>
              <h3>Streamline your workflow by simplifying assembly of longer DNA</h3>
            <h1>SKIP CLONING</h1>
              <p>Elegen’s unique process yields superior DNA that can often be used without traditional cloning in many high throughput workflows.</span></p>
              <a href="https://ecommerce.elegen.com/login" class="global-btn green-btn smooth-hover">ORDER NOW</a>
          </section>

          </div>
 
      </div>


      <div class="animate slide-3">
 
          <div class="page-inner">

          <section class="left-hero-content white-text">
            <img src="/img/common/Icon-Elegen-Full.svg" class="hero-logo" />
              <p><span class="line-break elegen-green-text">High Fidelity DNA</span></p>
              <h3>Elegen unlocks the promise of synthetic biology</h3>
            <h1>Accelerate Your DESIGN<span style="font-size: 200">&ndash;</span>BUILD&ndash;TEST&ndash;LEARN Cycle</h1>
              <p>By delivering a new class of DNA quickly, Elegen enables researchers to reliably get more done.</span></p>
              <a href="https://ecommerce.elegen.com/login" class="global-btn green-btn smooth-hover">ORDER NOW</a>
          </section>

          </div>
 
      </div>
 
    </section>

      <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/gen-article-2303.php'); ?>
    
      <section class="wide-section no-margin">
 
            <div class="page-inner">

               <div class="center-paragraph">
               
                  <h2>A NEW CLASS OF DNA</h2>
                  <h3>Streamline your workflow going from design to experiment</h3>
               </div>

            </div>

      </section>


      <section class="wide-section bottom-space">
 
            <div class="page-inner narrow-section">   
          
               <div class="col3 left">

                  <div class="col-box green-box">

                      <div class="green-box-img">  
                  
                      <img src="img/common/Circle-Faster-Turnaround-01.svg">

                      </div>
                      <h3>Faster Turnaround</h3>

                      <div class="green-box-stats">
                        <h4>7</h4>
                        <h5>business days</h5>
                      </div>

                      <div class="green-box-desc">
                      <p>DNA shipped in 6 - 8 business days, <span class="line-break">so you go from ideas to results faster</span></p>
                      </div>

                  </div>

              </div>
    
               <div class="col3 left">

                  <div class="col-box green-box">

                      <div class="green-box-img">  

                        <img src="img/common/Circle-Longer-DNA-01.svg">

                      </div>
                      <h3>Longer DNA</h3>

                      <div class="green-box-stats">
                        <h4><span class="small-text">up to</span>7<span>kb</span></h4>
                        <h5>in length</h5>
                      </div>

                      <div class="green-box-desc">
                      <p>Delivering longer DNA, <span class="line-break">letting you focus on your discoveries</span></p>
                      </div>

                  </div>

              </div>

              <div class="col3 left">

                  <div class="col-box green-box">

                      <div class="green-box-img">  
                       <img src="img/common/Circle-Superior-Accuracy-01.svg">
                      </div>

                      <h3>Superior Accuracy</h3>

                      <div class="green-box-stats">
                         <h4><span class="align-text">></span>95<span>%</span></h4>
                        <h5>sequence perfect molecules</h5>
                      </div>

                      <div class="green-box-desc">
                      <p>DNA so accurate, <span class="line-break">it simplifies your workflow</span></p>
                      </div>

                  </div>

              </div>

              <div class="center-paragraph key-benefits">

                <uL class="ul-with-circles">
                  <li>Plan with confidence</li>
                  <li>Execute on time</li>
                  <li>Get more done</li>
                </uL>
              </div>
        
            </div>
 
      </section>

      <section id="elegen-vision" class="wide-section dark-gray-section lite-title">

           <div class="page-inner">

              <div class="center-paragraph">

                <div class="center-icon">

<svg version="1.1" id="our-vision-svg" xmlns:serif="http://www.serif.com/"
   xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 574.8 576" style="enable-background:new 0 0 574.8 576;" xml:space="preserve">
<style type="text/css">
  .zt0{fill:url(#vision-svg);}
</style>
<linearGradient id="vision-svg" gradientUnits="userSpaceOnUse" x1="-12.5738" y1="13.1433" x2="-11.5738" y2="13.1433" gradientTransform="matrix(-1.823066e-05 419.0167 -419.0167 -1.823066e-05 5794.5913 5375.3486)">
  <stop  offset="0" style="stop-color:#27C9D0"/>
  <stop  offset="0.42" style="stop-color:#4DCAA4"/>
  <stop  offset="1" style="stop-color:#82C953"/>
</linearGradient>
<path class="zt0" d="M271.4,0.4v195.8c0,19.7,0.6,17.5-10.4,33.8c-28.2,42.9-28.2,35.1,26.4,35.1c49,0,51.1,3.6,39.3-14.9
  c-19.2-30.1-23.4-28.5-23.4-54.1V0.4C298,0.2,292.7,0,287.4,0C282,0,276.7,0.2,271.4,0.4z M330.3,190.9c0,18.8-1,14.7,9.5,30.2
  c27.6,40.8,15.3,49.3,74.3-39.5c23.1-34.7,46.2-69.9,68.9-105c-41.4-38.4-94.2-64.8-152.7-73.5L330.3,190.9L330.3,190.9z M91.7,76.7
  c26.6,41,53.8,81.9,81,123.3c45.3,69,36.7,58.9,62.2,21.1c10.5-15.5,9.5-11.4,9.5-30.2V3.2C185.9,11.9,133.1,38.3,91.7,76.7
  L91.7,76.7z M2.7,244.2h121.1c32.1,0,26.1,0.3,55,12.1L72.7,96.1C36.3,136.7,11.3,187.8,2.7,244.2z M395.9,256.3
  c28.8-11.8,22.8-12.1,55-12.1H572c-8.6-56.4-33.6-107.5-70-148.1C466.6,149.5,431.3,202.8,395.9,256.3L395.9,256.3z M455.7,271.5
  c-74.1,0.2-74.1,32.8,0,32.9l119.1,0.2v-33.4L455.7,271.5z M-0.1,304.6l119.1-0.2c74.1-0.2,74.1-32.8,0-32.9l-119.1-0.2
  C-0.1,271.3-0.1,304.6-0.1,304.6z M261,345.8c11,16.3,10.4,14.1,10.4,33.8v195.8c10.8,0.6,21,0.6,31.9,0V379.6
  c0-25.6,4.2-24,23.4-54.1c11.8-18.5,9.7-14.9-39.3-14.9c-14.5,0-25.2-0.6-32.5-0.6C234.8,310.1,240.3,314.3,261,345.8L261,345.8z
   M502,479.8c36.4-40.7,61.4-91.7,70-148.1H450.9c-32.1,0-26.1-0.3-55-12.1C431.3,373.1,466.6,426.4,502,479.8z M123.9,331.7H2.7
  c8.6,56.4,33.6,107.5,70,148.1l106.1-160.2C150,331.4,156,331.7,123.9,331.7L123.9,331.7z M362.5,325.2c-6.1,0-10.6,11.7-22.6,29.6
  c-10.5,15.6-9.5,11.4-9.5,30.2v187.7c58.5-8.8,111.3-35.1,152.7-73.5c-22.7-35.1-45.8-70.2-68.9-105
  C381,344.3,370.3,325.2,362.5,325.2L362.5,325.2L362.5,325.2z M212.2,325.2c-6.8,0-15.7,14.4-39.6,50.7
  c-27.2,41.4-54.4,82.2-81,123.3c41.4,38.4,94.2,64.8,152.7,73.5V385c0-18.8,1-14.7-9.5-30.2C222.8,336.9,218.4,325.2,212.2,325.2
  L212.2,325.2L212.2,325.2z"/>
</svg>



                </div>
          
                <h3>OUR VISION</h3>
<blockquote>
                <p>
                  For decades, the promise of synthetic biology has been fundamentally limited by our ability to accurately, reliably and rapidly synthesize DNA at a scale. Elegen helps researchers and builders of the new bioecoomy turn their imagination into reality with fast-turnaround, high quality long, synthetic DNA; eliminating the need for time-intensive in-house cloning and enabling rapid prototyping in biologic sciences.
                </p>
</blockquote>
                <h4>High Fidelity DNA</h4>

                <a href="/products/high-fidelity-dna" class="global-btn light-green-btn smooth-hover">LEARN MORE</a>

              </div>

            </div>

          </section>

        <section id="synbio-revolution" class="wide-section light-gray-box no-margin">
 
            <div class="page-inner">

              <div class="center-paragraph">

              <div id="synbio-dna-icon" class="center-icon">

<svg version="1.1" id="revolution-synbio-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   viewBox="0 0 300 300" style="enable-background:new 0 0 300 300;" xml:space="preserve">
<style type="text/css">
  .et0{fill:#6BBE4A;}
</style>
<g>
  <path class="et0" d="M149.56,1.09C67.57,1.09,1.1,67.55,1.1,149.54S67.57,298,149.56,298s148.46-66.47,148.46-148.46
    S231.55,1.09,149.56,1.09z M91.72,49.3c0-2.19,1.77-3.96,3.96-3.96s3.96,1.77,3.96,3.96v16.61c0,1.4,0.1,2.79,0.25,4.17
    c0.35-0.1,0.71-0.22,1.09-0.22h27.43c2.19,0,3.96,1.77,3.96,3.96c0,2.19-1.77,3.96-3.96,3.96H101.6
    c2.54,7.7,7.46,14.53,14.27,19.31c1.79,1.25,2.23,3.72,0.97,5.51c-0.77,1.1-2,1.69-3.24,1.69c-0.79,0-1.57-0.23-2.27-0.72
    c-12.28-8.6-19.61-22.68-19.61-37.65V49.3z M100.98,224.71h21.43c1.77-7.99,8.89-13.99,17.41-13.99c8.52,0,15.63,6,17.41,13.99
    h41.1c-2.43-9.71-8.62-18.29-17.38-23.53c-1.87-1.12-2.48-3.55-1.36-5.43c1.12-1.87,3.56-2.49,5.43-1.36
    c13.81,8.26,22.39,23.38,22.39,39.45v15.95c0,2.19-1.77,3.96-3.96,3.96c-2.19,0-3.96-1.77-3.96-3.96v-15.95
    c0-0.41-0.07-0.81-0.08-1.22h-42.24c-1.84,7.9-8.9,13.81-17.35,13.81s-15.51-5.91-17.35-13.81h-21.49c-0.45,0-0.87-0.12-1.27-0.26
    c-0.02,0.49-0.07,0.98-0.07,1.48v15.95c0,2.19-1.77,3.96-3.96,3.96s-3.96-1.77-3.96-3.96v-15.95c0-25.33,20.61-45.94,45.94-45.94
    h23.8c13.77,0,25.82-7.38,32.49-18.37h-19.18c-2.19,0-3.96-1.77-3.96-3.96c0-2.19,1.77-3.96,3.96-3.96h22.46
    c0.12,0,0.23,0.06,0.35,0.07c1.22-3.72,1.9-7.69,1.9-11.81c0-3.19-0.43-6.32-1.21-9.35c-0.34,0.1-0.67,0.21-1.04,0.21h-20.96
    c-2.19,0-3.96-1.77-3.96-3.96c0-2.19,1.77-3.96,3.96-3.96h19.06c-3.21-6.36-8.11-11.86-14.39-15.61c-1.87-1.12-2.48-3.55-1.36-5.43
    c1.12-1.87,3.55-2.49,5.43-1.36c13.81,8.26,22.39,23.38,22.39,39.45c0,25.33-20.61,45.94-45.94,45.94h-23.8
    c-17.83,0-32.79,12.35-36.88,28.93C100.85,224.74,100.91,224.71,100.98,224.71z M207.4,65.91c0,25.33-20.61,45.94-45.94,45.94
    h-23.8c-14.83,0-27.68,8.56-33.94,20.98h57.15c2.19,0,3.96,1.77,3.96,3.96c0,2.19-1.77,3.96-3.96,3.96h-58.61
    c-0.5,0-0.96-0.12-1.4-0.28c-0.77,3.02-1.23,6.16-1.23,9.42c0,4.1,0.72,8.08,1.97,11.87c0.22-0.04,0.43-0.13,0.66-0.13h57.97
    c2.19,0,3.96,1.77,3.96,3.96c0,2.19-1.77,3.96-3.96,3.96h-55.05c2.76,4.56,6.43,8.59,10.95,11.7c1.8,1.24,2.25,3.7,1.02,5.51
    c-0.77,1.11-2.01,1.71-3.27,1.71c-0.77,0-1.55-0.23-2.24-0.69c-12.48-8.58-19.93-22.74-19.93-37.88
    c0-25.33,20.61-45.94,45.94-45.94h23.8c16.82,0,31.11-10.99,36.11-26.16h-50.05c-2.19,0-3.96-1.77-3.96-3.96
    c0-2.19,1.77-3.96,3.96-3.96h51.77c0.14-1.3,0.21-2.62,0.21-3.95V49.3c0-2.19,1.77-3.96,3.96-3.96c2.19,0,3.96,1.77,3.96,3.96
    V65.91z"/>
  <path class="et0" d="M139.82,238.51c5.48,0,9.94-4.46,9.94-9.94c0-5.48-4.46-9.94-9.94-9.94s-9.94,4.46-9.94,9.94
    C129.88,234.05,134.34,238.51,139.82,238.51z"/>
</g>
</svg>

              </div>

              <h2>Fueling the synthetic biology revolution</h2>

               <p>
                  We engineered a new class of DNA - unlike any non-clonal or clonal products offered today. <span class="line-break">With Elegen's DNA, you no longer have to make trade-offs to make breakthroughs.</span>
              </p>
            </div>

              <div class="col4">

                <div id="chemicals-icon-green" class="center-icon">


<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   viewBox="0 0 210 321" style="enable-background:new 0 0 210 321;" xml:space="preserve">
<style type="text/css">
  .ct0{fill:#6BBE4A;}
</style>
<g>
  <path class="ct0" d="M193.7,20.7H16.3C11.7,20.7,8,24.4,8,29v62.5c0,4.6,3.7,8.3,8.3,8.3H18V291c0,4.6,3.7,8.3,8.3,8.3h157.4
    c4.6,0,8.3-3.7,8.3-8.3V99.8h1.8c4.6,0,8.3-3.7,8.3-8.3V29C202,24.4,198.3,20.7,193.7,20.7z M175.4,282.8H34.6v-183h140.9V282.8z
     M185.5,83.2h-1.8H26.3h-1.8v-46h15.1v32.5c0,3.9,3.2,7.1,7.1,7.1c3.9,0,7.1-3.2,7.1-7.1V37.2h15v32.5c0,3.9,3.2,7.1,7.1,7.1
    c3.9,0,7.1-3.2,7.1-7.1V37.2h15v32.5c0,3.9,3.2,7.1,7.1,7.1c3.9,0,7.1-3.2,7.1-7.1V37.2h15v32.5c0,3.9,3.2,7.1,7.1,7.1
    c3.9,0,7.1-3.2,7.1-7.1V37.2h15v32.5c0,3.9,3.2,7.1,7.1,7.1c3.9,0,7.1-3.2,7.1-7.1V37.2h15.1V83.2z"/>
  <path class="ct0" d="M50.8,250h108.3c3.9,0,7.1-3.2,7.1-7.1V139.7c0-3.9-3.2-7.1-7.1-7.1H50.8c-3.9,0-7.1,3.2-7.1,7.1v103.2
    C43.8,246.8,46.9,250,50.8,250z M57.9,146.7h94.2v89.1H57.9V146.7z"/>
  <polygon class="ct0" points="119.2,153.9 105,153.9 90.8,153.9 90.8,176.7 68,176.7 68,205 90.8,205 90.8,227.9 119.2,227.9 
    119.2,205 142,205 142,190.9 142,176.7 119.2,176.7   "/>
</g>
</svg>

                </div>
                <h5>Therapeutics</h5>
                <div class="col4-img">
                   <img class="lazy" src="<?php echo cdn ?>/img/common/placeholder.gif" data-lazy="/img/applications/img-therapeutics-01a.jpg" alt="Therapeutics" />
                  </div>

                  <p>Minimize extraneous work and expedite the development of your cell and nucleic acid-based therapies with fast, reliable, accurate DNA.</p>
            </div>
        
        <div class="col4">
                  <div id="agriculture-icon-green" class="center-icon">
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   viewBox="0 0 300 186" style="enable-background:new 0 0 300 186;" xml:space="preserve">
<style type="text/css">
  .at0{fill-rule:evenodd;clip-rule:evenodd;fill:#6BBE4A;}
</style>
<path class="at0" d="M26.69,65.22c56.41,12.39,98.46,59.67,104.2,117.16c7.39-74.04,61.54-134.93,134.21-150.9
  c-54.86,27.46-96.38,75.82-115.25,134.21c84.51-6.07,149.32-77.55,147.09-162.27c-46.82-1.62-92.05,17.2-123.92,51.53
  c-24.83,26.76-39.63,60.87-42.56,96.68c-3.47-25.27-14.62-49.14-32.29-68.19c-24.74-26.67-59.85-41.26-96.21-40
  C0.23,109.21,50.54,164.7,116.16,169.42C101.51,124.09,69.27,86.56,26.69,65.22L26.69,65.22z"/>
</svg>

                  </div>
                  <h5>Food and Agriculture</h5>

                  <div class="col4-img">
                    <img class="lazy" src="<?php echo cdn ?>/img/common/placeholder.gif" data-lazy="/img/applications/img-agriculture-01a.jpg" alt="Food and Agriculture" />
                  </div>

                  <p>Creating sustainable, abundant food sources is one of the most important goals of synthetic biology, and desparately needed as our resources shrink and our needs grow.</p>
              </div>

              <div class="col4">

                <div id="chemicals-icon-green" class="center-icon">
                  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   viewBox="0 0 210 321" style="enable-background:new 0 0 210 321;" xml:space="preserve">
<style type="text/css">
  .bt0{fill-rule:evenodd;clip-rule:evenodd;fill:#6BBE4A;}
</style>
<path class="bt0" d="M67.73,203.84c5.89,0,10.62,4.73,10.62,10.72c0,5.89-4.73,10.65-10.62,10.65c-5.86,0-10.7-4.76-10.7-10.65
  C57.04,208.57,61.87,203.84,67.73,203.84L67.73,203.84z M111.7,236.55c2.98,0,5.43,2.44,5.43,5.42c0,3.01-2.44,5.45-5.43,5.45
  c-2.98,0-5.45-2.44-5.45-5.45C106.25,238.99,108.72,236.55,111.7,236.55L111.7,236.55z M145.65,254.37c1.77,0,3.24,1.49,3.24,3.27
  c0,1.83-1.47,3.32-3.24,3.32c-1.83,0-3.32-1.49-3.32-3.32C142.33,255.86,143.82,254.37,145.65,254.37L145.65,254.37z M105.38,265.27
  c4.58,0,8.25,3.68,8.25,8.25c0,4.58-3.68,8.36-8.25,8.36c-4.55,0-8.26-3.78-8.26-8.36C97.12,268.95,100.83,265.27,105.38,265.27
  L105.38,265.27z M28.42,188.21c-3.06,8.51-4.63,17.56-4.63,26.97c0,44.9,36.31,81.28,81.15,81.28s81.18-36.39,81.18-81.28
  c0-9.41-1.67-18.46-4.65-26.97l0,0c-22.65,31.19-48.01,16.17-77.76,8.59C70.79,188.36,52.28,207,28.42,188.21L28.42,188.21z"/>
<path class="bt0" d="M67.3,30.97h75.29h1.31v1.23v102.65l6.33,3.68c14.04,8.1,25.35,19.7,33.17,33.22
  c7.79,13.55,12.19,29.11,12.19,45.36c0,25.05-10.18,47.8-26.59,64.16c-16.4,16.43-39.06,26.64-64.05,26.64
  c-25.02,0-47.65-10.21-64.05-26.64c-16.41-16.35-26.59-39.11-26.59-64.16c0-16.25,4.29-31.81,12.11-45.36
  c7.89-13.53,19.21-25.12,33.25-33.22l6.33-3.68V32.2v-1.23H67.3z M193.4,166.14c-8.95-15.56-21.86-28.57-37.39-37.54l-0.72-0.44
  v-0.69V32.2v-1.23h1.23c3.7-0.26,7.05-1.85,9.49-4.4c2.36-2.54,3.86-5.97,3.86-9.75l0,0c0-3.88-1.57-7.38-4.11-9.93
  c-2.54-2.57-6.07-4.14-9.93-4.14H54.05c-3.86,0-7.38,1.59-9.93,4.14c-2.54,2.55-4.11,6.04-4.11,9.93l0,0c0,3.78,1.49,7.2,3.86,9.75
  c2.37,2.55,5.79,4.14,9.46,4.4h1.23v1.23v95.27v0.69l-0.69,0.44c-15.53,8.97-28.44,21.99-37.39,37.54
  c-8.69,14.94-13.6,32.42-13.6,50.96c0,28.21,11.42,53.79,29.83,72.33c18.51,18.46,44.05,29.88,72.23,29.88
  c28.16,0,53.69-11.42,72.13-29.88C195.58,270.9,207,245.32,207,217.11C207,198.57,202.06,181.08,193.4,166.14L193.4,166.14z"/>
<path class="bt0" d="M139.24,147.17c8.07,0,14.66,6.58,14.66,14.58c0,8.07-6.58,14.58-14.66,14.58c-7.97,0-14.55-6.51-14.55-14.58
  C124.69,153.75,131.27,147.17,139.24,147.17L139.24,147.17z"/>
<path class="bt0" d="M85.37,160.07c4.65,0,8.43,3.78,8.43,8.43c0,4.65-3.78,8.43-8.43,8.43c-4.65,0-8.41-3.78-8.41-8.43
  C76.97,163.86,80.72,160.07,85.37,160.07L85.37,160.07z"/>
</svg>

                </div>
                <h5>Chemicals</h5>

                <div class="col4-img">
                 <img class="lazy" src="<?php echo cdn ?>/img/common/placeholder.gif" data-lazy="/img/applications/img-chemicals-01a.jpg" alt="Chemicals" />
                </div>

                <p>Biology has been creating compounds through enzymatic chemistry before humans were around. Let's tap into the world's oldest green chemical manufacturing process and evolve it to create new chemicals.</p>

              </div>

              <div class="col4">
                <div id="materials-icon-green" class="center-icon">

<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
   viewBox="0 0 243.5 259" style="enable-background:new 0 0 243.5 259;" xml:space="preserve">
<style type="text/css">
  .dt0{fill:#6BBE4A;}
</style>
<g>
  <path class="dt0" d="M3.11,59.94v85.95c4.22,0.62,8.51,1.16,13.79,1.16c5.54,0,9.86-0.4,13.79-0.96V59.96
    c-4.28,0.4-8.63,0.77-13.79,0.77C12.21,60.73,7.67,60.35,3.11,59.94z"/>
  <path class="dt0" d="M87.01,243.96c-5.53,0-9.86,0.4-13.79,0.95v11.65h27.58v-11.65C96.87,244.36,92.54,243.96,87.01,243.96z"/>
  <path class="dt0" d="M16.9,191.92c-4.97,0-9.39-0.38-13.79-0.78v65.43h27.45l0.13-65.41C26.4,191.55,22.06,191.92,16.9,191.92z"/>
  <path class="dt0" d="M143.34,146.1c3.93,0.56,8.25,0.95,13.79,0.95c5.54,0,9.86-0.39,13.79-0.95v-29.02
    c-0.01-0.06-0.07-0.09-0.08-0.15c-0.01-0.1,0.08-0.18,0.08-0.28V59.96c-4.28,0.4-8.63,0.77-13.79,0.77
    c-5.16,0-9.51-0.37-13.79-0.76v56.54c0,0.16,0.14,0.27,0.11,0.43c-0.01,0.09-0.1,0.13-0.11,0.22V146.1z"/>
  <path class="dt0" d="M73.34,96.51c0.05,0,0.07-0.07,0.11-0.07l0.03,0.03c3.67-0.93,7.75-1.59,13.14-1.59
    c5.39,0,9.47,0.67,13.12,1.6l0.05-0.03c0.05,0,0.07,0.07,0.12,0.07c5.72,1.48,10.1,3.75,14.66,6.36
    c5.77,3.25,11.95,6.27,20.15,8.17V83.12c-4.71-1.5-8.58-3.54-12.49-5.77c-8.48-4.78-17.87-10.1-35.62-10.1
    c-17.77,0-27.18,5.32-35.48,10.02c-3.81,2.16-7.51,4.07-11.84,5.55v28.01c7.9-1.96,13.9-4.9,19.32-7.97
    C63.21,100.26,67.61,97.98,73.34,96.51z"/>
  <path class="dt0" d="M226.85,67.45c-17.77,0-27.18,5.32-35.48,10.02c-3.81,2.16-7.51,4.07-11.84,5.55v28.01
    c7.89-1.96,13.9-4.9,19.32-7.97c4.59-2.61,8.99-4.89,14.72-6.36c0.05,0,0.07-0.07,0.12-0.07l0.05,0.03
    c3.66-0.93,7.73-1.6,13.12-1.6c5.39,0,9.47,0.67,13.12,1.6l0.05-0.03c0.05,0,0.07,0.07,0.12,0.07c0.34,0.09,0.6,0.24,0.93,0.33
    v-28.1C236.92,68.08,232.39,67.45,226.85,67.45z"/>
  <path class="dt0" d="M73.21,237c0.05,0,0.07-0.07,0.11-0.07l0.05,0.03c3.65-0.93,7.73-1.59,13.12-1.59c5.39,0,9.47,0.67,13.12,1.6
    c0,0,0.03-0.03,0.05-0.03c0.05,0,0.07,0.07,0.12,0.07c5.72,1.48,10.1,3.75,14.66,6.36c5.77,3.25,11.95,6.27,20.15,8.17v-27.91
    c-4.71-1.5-8.58-3.54-12.49-5.77c-8.48-4.78-17.87-10.1-35.62-10.1c-17.77,0-27.18,5.32-35.48,10.02
    c-3.81,2.16-7.51,4.07-11.84,5.55v28.01c7.9-1.96,13.9-4.9,19.32-7.97C63.08,240.75,67.48,238.47,73.21,237z"/>
  <path class="dt0" d="M226.85,207.74c-17.77,0-27.18,5.32-35.48,10.02c-3.81,2.16-7.51,4.07-11.84,5.55v28.01
    c7.89-1.96,13.9-4.9,19.32-7.97c4.59-2.61,8.99-4.88,14.72-6.36c0.05,0,0.07-0.07,0.12-0.07l0.05,0.02
    c3.66-0.92,7.73-1.6,13.12-1.6c5.39,0,9.47,0.67,13.12,1.6l0.05-0.03c0.05,0,0.07,0.07,0.12,0.07c0.34,0.09,0.6,0.24,0.93,0.33
    v-28.09C236.92,208.37,232.39,207.74,226.85,207.74z"/>
  <path class="dt0" d="M170.8,154.2c-0.05,0-0.07,0.07-0.11,0.07c-0.02,0-0.03-0.03-0.03-0.03c-3.67,0.93-7.75,1.59-13.14,1.59
    c-5.39,0-9.47-0.67-13.12-1.6l-0.03,0.03c-0.07,0-0.09-0.07-0.14-0.07c-5.72-1.48-10.1-3.75-14.66-6.36
    c-5.77-3.25-11.95-6.27-20.15-8.17v27.91c4.72,1.5,8.58,3.54,12.49,5.77c8.48,4.78,17.87,10.1,35.62,10.1
    c17.77,0,27.18-5.32,35.48-10.02c3.81-2.16,7.51-4.07,11.84-5.55v-28.01c-7.9,1.96-13.9,4.9-19.32,7.97
    C180.93,150.44,176.53,152.72,170.8,154.2z"/>
  <path class="dt0" d="M45.3,147.63c-4.59,2.6-8.99,4.88-14.72,6.36c-0.05,0-0.07,0.07-0.11,0.07l-0.05-0.03
    c-3.65,0.93-7.73,1.59-13.12,1.59c-5.39,0-9.47-0.67-13.12-1.6c0,0-0.03,0.03-0.05,0.03c-0.05,0-0.07-0.07-0.12-0.07
    c-0.33-0.08-0.58-0.23-0.9-0.32v28.09c4.13,0.86,8.65,1.49,14.18,1.49c17.77,0,27.18-5.32,35.48-10.02
    c3.81-2.16,7.51-4.07,11.85-5.55v-28.01C56.72,141.62,50.71,144.56,45.3,147.63z"/>
  <path class="dt0" d="M170.26,22.83c-0.05,0-0.07,0.07-0.11,0.07l-0.03-0.03c-3.67,0.93-7.75,1.59-13.14,1.59
    c-5.39,0-9.47-0.67-13.12-1.6l-0.05,0.03c-0.05,0-0.07-0.07-0.12-0.07c-5.72-1.48-10.1-3.75-14.66-6.36
    c-5.77-3.25-11.95-6.27-20.15-8.17v27.91c4.72,1.5,8.58,3.54,12.49,5.77c8.48,4.78,17.87,10.1,35.62,10.1
    c17.77,0,27.18-5.32,35.48-10.02c3.81-2.16,7.51-4.07,11.84-5.55V8.5c-7.9,1.96-13.9,4.9-19.32,7.97
    C180.39,19.07,176,21.35,170.26,22.83z"/>
  <path class="dt0" d="M45.3,16.46c-4.59,2.61-8.99,4.88-14.72,6.36c-0.05,0-0.07,0.07-0.11,0.07l-0.05-0.02
    c-3.65,0.92-7.73,1.6-13.12,1.6c-5.39,0-9.47-0.67-13.12-1.6c0,0-0.03,0.03-0.05,0.03c-0.05,0-0.07-0.07-0.12-0.07
    c-0.33-0.08-0.58-0.23-0.9-0.32v28.09c4.13,0.86,8.65,1.49,14.18,1.49c17.77,0,27.18-5.32,35.48-10.02
    c3.81-2.16,7.51-4.07,11.85-5.55V8.5C56.72,10.46,50.71,13.4,45.3,16.46z"/>
  <path class="dt0" d="M100.8,199.85v-95.2c-3.94-0.56-8.26-0.96-13.79-0.96c-5.53,0-9.86,0.4-13.79,0.95v95.2
    c4.28-0.39,8.63-0.76,13.79-0.76C92.18,199.09,96.52,199.46,100.8,199.85z"/>
  <path class="dt0" d="M170.88,220.82c-0.01-0.07,0.05-0.12,0.04-0.19v-29.48c-4.28,0.4-8.63,0.77-13.79,0.77
    c-5.16,0-9.51-0.37-13.79-0.77l-0.02,65.41h27.6v-35.72C170.91,220.83,170.88,220.84,170.88,220.82z"/>
  <path class="dt0" d="M143.34,3.15v11.71c3.94,0.56,8.26,0.96,13.79,0.96c5.53,0,9.86-0.4,13.79-0.95V3.1h-27.6L143.34,3.15z"/>
  <path class="dt0" d="M73.22,3.15v56.43c4.28-0.39,8.63-0.76,13.79-0.76c4.75,0,8.69,0.36,12.68,0.7V3.1H73.2
    C73.21,3.12,73.22,3.13,73.22,3.15z"/>
  <path class="dt0" d="M213.46,3.1l0.02,0.05v56.43c4.28-0.4,8.63-0.76,13.79-0.76c4.92,0,9.39,0.37,13.79,0.78V3.15l0.02-0.05
    H213.46z"/>
  <polygon class="dt0" points="-5.5,3.15 -5.47,3.1 -5.5,3.1   "/>
  <path class="dt0" d="M3.09,3.1l0.02,0.05v11.53c4.15,0.6,8.4,1.13,13.79,1.13c5.54,0,9.86-0.4,13.79-0.95V3.15l0.02-0.05H3.09z"/>
  <path class="dt0" d="M213.49,104.65v95.2c4.28-0.39,8.63-0.76,13.79-0.76c4.92,0,9.39,0.37,13.79,0.78v-95.05
    c-4.26-0.6-8.57-1.13-13.79-1.13C221.74,103.7,217.41,104.09,213.49,104.65z"/>
  <path class="dt0" d="M213.49,244.91v11.65h27.58v-11.45c-4.21-0.62-8.5-1.16-13.79-1.16C221.74,243.96,217.41,244.36,213.49,244.91
    z"/>
</g>
</svg>

                </div>
                <h5>Materials</h5>
                <div class="col4-img">
                  <img class="lazy" src="<?php echo cdn ?>/img/common/placeholder.gif" data-lazy="/img/applications/img-materials-01a.jpg" alt="Materials" />
                  </div>

                  <p>From petrochemical based polymers to clothing, synthetic biology has the power to re-create our everyday materials in a more green and sustainable way.</p>
              </div>
              
            </div>

        </section>

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/main-contact-form.php'); ?>
           
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/quick-request.php'); ?>
<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script>
function init() {
  var vidDefer = document.getElementsByTagName('iframe');
  for (var i = 0; i < vidDefer.length; i++) {
    if (vidDefer[i].getAttribute('data-src')) {
      vidDefer[i].setAttribute('src', vidDefer[i].getAttribute('data-src'));
    }
  }
}
window.onload = init;
$(function() {
  var myWindow = $(window),
    winWidth = myWindow.width(),
    slideDots = [];
  $(".hero-section").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: !0,
    autoplay: !0,
    autoplaySpeed: 5E3,
    centerPadding: 0,
    pauseOnFocus: !1,
    pauseOnHover: !1
  });
  $.each($(".slick-dots li"), function(a) {
    slideDots[a] = $(this).attr("id")
  });
   $('#'+slideDots[0]+' button').html('');
      $('#'+slideDots[1]+' button').html('');
      $('#'+slideDots[2]+' button').html('');
  <?php if(!$detect->isMobile() && !$detect->isTablet()){ ?>
  var vids = ["hero-elegen-main-dna-01a", "hero-elegen-main-accuracy-02b"];
 vidId = ["slide-2", "slide-3"];
  heroClass = [".slide-2", ".slide-3"];
  elem = $("<video></video>");
  $('<source>')
    .attr('src', '<?php echo cdn; ?>/vid/hero-purigen-agbt-2021-03a.mp4')
    .attr('type', 'video/mp4')
    .appendTo(elem);
  elem
    .attr('id', 'slide-1')
    .attr('preload','auto')
    .attr('muted','')
    .attr('playsinline','');

  $('.slide-1').prepend(elem);
  stopVideos("#slide-1", "rgba(99,119,94,0.5)", "#e4e4e4", "0", "rgba(113, 193, 195, 1)");

  $.each(vids,function(i){
    var el = $('<video><\/video>');
    $('<source>')
      .attr('src', '<?php echo cdn; ?>/vid/'+vids[i]+'.mp4')
      .attr('type', 'video/mp4')
      .appendTo(el);
    el
      .attr('id', vidId[i])
      .attr('preload','auto')
      .attr('playsinline','');
      $(heroClass[i]).prepend(el);
      el[0].muted ^= 1;
  });

  $.each($('.slick-cloned video'),function(i){
    $(this).remove();
  });

  $('.hero-section').on('beforeChange', function(event, slick, currentSlide, nextSlide){
    if(nextSlide == 0){
       stopVideos('#slide-1', 'rgba(99,119,94,0.5)', '#e4e4e4', nextSlide, 'rgba(113, 193, 195, 1)');
    }
    if(nextSlide == 1){
      stopVideos('#slide-2', 'rgba(99,119,94,0.5)', '#e4e4e4', nextSlide, 'rgba(113, 193, 195, 1)');
    }
    if(nextSlide == 2){
       stopVideos('#slide-3', 'rgba(99,119,94,0.5)', '#e4e4e4', nextSlide, 'rgba(113, 193, 195, 1)');
    }
  });

  function stopVideos(vid, currBg, color, slide, bg){
    $('.hero-section').slick('slickPlay');
    $.each($('.animate video'),function(i){
      var id = this.id;
      $(this).get(0).load();
    });
    if(vid !== ''){
      var playPromise = $(vid).get(0).play();
      if(playPromise !== undefined){
        playPromise.then(_ => {

        })
        .catch(error => {
          console.log(error);
        });
      }
      $('.hero-section').slick('slickPause');
    }
    $.each($('.slick-dots li button'),function(i){
      $(this).css({'background':currBg,'color':color});
    });
    $('#slick-slide0'+slide+' button').css({'background':bg,'color':'#fff'});
  }

  $('#slide-2').get(0).addEventListener("ended", function(){
     $('.hero-section').slick('slickNext');
   }, false);

  $('#slide-1').get(0).addEventListener("ended", function(){
     $('.hero-section').slick('slickNext');
   }, false);

  $('#slide-3').get(0).addEventListener("ended", function(){
     $('.hero-section').slick('slickNext');
   }, false);

  $.each($(".animate"), function(a) {
    a = $(this).find($("img"));
    var b = $(this).find($("picture source")),
      d = a.attr("data-hero"),
      c = b.attr("data-hero");
    b.attr("srcset", c).attr("data-hero", "");
    a.attr("src", d).attr("data-hero", "")
 });
  <?php } ?>
  var myWindow = $(window),
    images = $(".lazy");
  myWindow.on("load", function() {
    maybeLoad(images)
  });
  myWindow.scroll(function() {
    maybeLoad(images)
  });

  function inView(b) {
    var c = myWindow.scrollTop() - 100,
      d = c + myWindow.height() + 100,
      a = $(b).height();
    b = $(b).offset().top;
    return 0 < a && b <= d && b + a >= c
  }

  function maybeLoad(b) {
    b.each(function(b, d) {
      var a = $(d);
      if (a.attr("data-lazy") && inView(a)) {
        var c = a.attr("data-lazy");
        "lazy srcset" == a.attr("class") ? a.attr("srcset", c) : a.attr("src", c);
        a.attr("data-lazy", "")
      }
    })
  }

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
});
</script>
</body>
</html>