<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/company/elegen-team/";
$PageCode = "060101";
$bodyid = "company";
$spotlights = $dbhelper->selectAll("SELECT * FROM employee_profile WHERE status = 1 ORDER BY created DESC");
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'team'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Elegen Team | ELEGEN</title>
<meta name="description" content="Elegen Leadership Team" />
<meta name="keywords" content="synthetic biology, dna, gene, sequence, molecules" />
<link rel="canonical" href="https://elegen.8romans.com/company/elegen-team" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">

    <section class="hero-section short-hero" id="leadership-hero">

    <div class="page-inner">

          <section class="left-hero-content white-text">
 
              <h1>Elegen Team</h1>

          </section>
 
    </section>

    <section id="leadership-section" class="wide-section">

        <div class="page-inner">

            <div class="center-paragraph">
              <h2>Our Leadership Team</h2>
            </div>

            <div class="col3 left">

                  <div class="col-box light-gray-box">
                  <div class="thmb-with-shadow">
                     <div class="center-icon">
                        <a class="leader-name hover-thmb" href="#hill"><img src="/img/company/pic-matt-circle-01b.png" /><span class="download-hover"><em>VIEW BIO</em></span></a>
                      </div>
                  </div>

                      <h4>Matt Hill, PhD</h4>
                      <h5>Founder &amp; CEO</h5>

                      <div class="green-box-desc">
                       <a href="https://www.linkedin.com/in/mhillphd/" class="social-icon" target="_blank"><svg class="smooth-hover" version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8 19h-3v-10h3v10zm11 0h-3v-5.342c0-1.392-.496-2.085-1.479-2.085-.779 0-1.273.388-1.521 1.165v6.262h-3s.04-9 0-10h2.368l.183 2h.062c.615-1 1.598-1.678 2.946-1.678 1.025 0 1.854.285 2.487 1.001.637.717.954 1.679.954 3.03v5.647z"/><ellipse cx="6.5" cy="6.5" rx="1.55" ry="1.5"/></svg></a>
                      </div>


                  </div>

               </div>

               <div class="col3 left">

                  <div class="col-box light-gray-box">

                      <div class="thmb-with-shadow">
                      <div class="center-icon">
                        <a class="leader-name hover-thmb" href="#unger"><img src="/img/company/pic-marc-circle-01b.png" /><span class="download-hover"><em>VIEW BIO</em></a>
                      </div>
                      </div>

                      <h4>Marc Unger, PhD</h4>
                      <h5>Chief Scientific Officer</h5>

                      <div class="green-box-desc">
                      <a href="https://www.linkedin.com/in/marcaunger/" class="social-icon" target="_blank"><svg class="smooth-hover" version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8 19h-3v-10h3v10zm11 0h-3v-5.342c0-1.392-.496-2.085-1.479-2.085-.779 0-1.273.388-1.521 1.165v6.262h-3s.04-9 0-10h2.368l.183 2h.062c.615-1 1.598-1.678 2.946-1.678 1.025 0 1.854.285 2.487 1.001.637.717.954 1.679.954 3.03v5.647z"/><ellipse cx="6.5" cy="6.5" rx="1.55" ry="1.5"/></svg></a>
                      </div>


                  </div>

               </div>

               <div class="col3 left">

                  <div class="col-box light-gray-box">

                      <div class="thmb-with-shadow">
                      <div class="center-icon">
                        <a class="leader-name hover-thmb" href="#caze"><img src="/img/company/pic-dan-circle-01b.png" /><span class="download-hover"><em>VIEW BIO</em></a>
                      </div>
                      </div>

                      <h4>Dan La Caze</h4>
                      <h5>Chief Business Officer</h5>

                      <div class="green-box-desc">
                      <a href="https://www.linkedin.com/in/dan-la-caze-842a23a/" class="social-icon" target="_blank"><svg class="smooth-hover" version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8 19h-3v-10h3v10zm11 0h-3v-5.342c0-1.392-.496-2.085-1.479-2.085-.779 0-1.273.388-1.521 1.165v6.262h-3s.04-9 0-10h2.368l.183 2h.062c.615-1 1.598-1.678 2.946-1.678 1.025 0 1.854.285 2.487 1.001.637.717.954 1.679.954 3.03v5.647z"/><ellipse cx="6.5" cy="6.5" rx="1.55" ry="1.5"/></svg></a>
                      </div>


                  </div>

               </div>

          
        </div>

     </section>

     <?php if($spotlights != null){ ?>

    <section class="wide-section slider section-slider hide-section bottom-space" id="main-slider" data-info="lazy-load">

      <div class="page-inner narrow-section">

        <?php 
           $cnt = 1;
           foreach($spotlights as $row){
             $employee = $row['first'].' '.$row['last'];
             $slide = $cnt > 1 ? ' slide-'.$cnt.' fade-out' : ' slide-'.$cnt.' playing';
        ?>

        <div class="left featured-slide">

          <div class="slide<?php echo $slide; ?>">
         
            <div class="center-paragraph">

                <h2><span class="featured">Our Latest Employee Spotlights</h2>

                <div class="left-paragraph">
                  <picture>
                   <source class="lazy" srcset="<?php echo cdn ?>/img/common/placeholder.gif" data-lazy="/files/team/<?php echo $row['headshot']; ?>" media="(min-width: 1200px)">
                   <source class="lazy" srcset="<?php echo cdn ?>/img/common/placeholder.gif" data-lazy="/files/team/<?php echo $row['headshot']; ?>">
                   <img class="lazy shadow-bg" src="<?php echo cdn ?>/img/common/placeholder.gif" data-lazy="/files/team/<?php echo $row['headshot']; ?>" alt="<?php echo $employee; ?>" />
                   </picture>

                </div>

                <div class="right-paragraph text-paragraph">
                  <p>
                   <?php echo $row['quote']; ?>
                  </p>
                  <a href="/company/elegen-team/<?php echo $row['slugurl']; ?>" class="global-btn light-green-btn smooth-hover">Meet <?php echo $employee; ?></a>

                </div>

              </div>

            </div>

          </div>

        <?php 
            $cnt++;
           }
        ?>

      </div>

      <div class="slide-nav"></div>

    </section>

    <?php } ?>

     <section id="hill" class="leadership-box mfp-with-anim mfp-hide">
       
	   <h4>Matt Hill, PhD<em>Founder &amp; CEO</em></h4>

       <p>Matt Hill is driven by a mission to create a lasting positive impact on the world. He holds a PhD in Genetics from Stanford, and was previously Vice President of Research and Development at Natera where he co-invented their core technology and led the commercialization of five precision molecular diagnostic products. This included Natera’s best-in-class noninvasive prenatal test, which has been used by millions to ensure healthy pregnancies, and which enabled Natera’s 2015 IPO. He founded Elegen to solve DNA writing and unlock the synthetic biology revolution.</p>
     </section>

     <section id="unger" class="leadership-box mfp-with-anim mfp-hide">
         <h4>Marc A. Unger, PhD<em>Chief Scienfitic Officer</em></h4>
		 
		 <p>Marc A. Unger received his PhD in Physical Chemistry at Caltech. During a postdoc in Applied Physics in Professor Steve Quake’s lab, he invented Multilayer Soft Lithography, the foundational technology of Fluidigm Corporation. The first paper describing the technology was published in Science and has now been cited more than 4,000 times. He joined Fluidigm and drove the development of the core technology, manufacturing, and product lines; he served as VP R&amp;D and Chief Scientific Officer. He also restructured and rebuilt the Marketing organization as EVP R&D and Marketing. During his tenure the company went public and achieved product revenues greater than $100M per year.</p>
     </section>

     <section id="caze" class="leadership-box mfp-with-anim mfp-hide">
	   <h4>Dan La Caze<em>Chief Business Officer</em></h4>
		 
       <p>Dan has over 16 years experience in corporate and business development roles at life science and molecular diagnostics companies, including Sequenom, Genoptix (Novartis), Natera and most recently Berkeley Lights. He has led over 100 strategic transactions, on both the buy- and sell-side, and has developed successful corporate strategies for small- and medium-sized biotechnology companies with disruptive technologies. He has a BS and MS in Biology from UCSD and a MBA from London Business School.</p>
     </section>

</main>

<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scriptsB.php'); ?>
<script>
function showWindow(id) {
  const bg = document.createElement('div');
  bg.setAttribute('id','overlay');
  document.getElementsByTagName('main')[0].append(bg);
  const popup = document.getElementById(id).childNodes[1];
  popup.classList.add('leadership-anim');
  document.getElementById(id).style.display = 'block';
  document.getElementById(id).style.zIndex = '1100';
}

function removeWindow(id) {
  const popup = document.getElementById(id).childNodes[1];
  const name = popup.classList;
  if(name.contains('leadership-anim')){
     name.remove('leadership-anim');
  }
  document.getElementById(id).style.display = 'none';
  const bg = document.getElementById('overlay');
  if(bg) bg.remove();
}

window.onload = () => {
  const links = document.querySelectorAll('.leader-name');
  links.forEach(link => {
    const name = link.getAttribute('href');
    let id = name.slice(1);
    const div = document.getElementById(id);
    const close = div.querySelector('.close-box');
    link.addEventListener('click',(e) => {
      e.preventDefault();
      showWindow(id);
    });
    close.addEventListener('click', (e) => {
      e.preventDefault();
      removeWindow(id);
    });
  });
};
</script>
</body>
</html>