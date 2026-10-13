<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/resources/literature";
$PageCode = "040102";
$bodyid = "resources";
$resources = $dbhelper->selectAll("SELECT * FROM literatures WHERE status = 1 ORDER BY created DESC");
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'literatures'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Literature | ELEGEN</title>
<meta name="description" content="ELEGEN Literature" />
<meta name="keywords" content="synthetic biology, dna, gene, sequence, molecules" />
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
              <h3>View and download our content</h3>
              <h1>Literature</h1>
          </section>
 
    </section>

    <section class="wide-section related-resources">

        <?php if($resources != null && count($resources) > 0){
           $total = count($resources);
           $narrow = $total < 4 ? ' narrow-section' : '';
           $col = $total > 4 ? 4 : $total;
        ?>

        <div class="page-inner<?php echo $narrow; ?>">

             <div class="docs-wrap docs-wrap-<?php echo $col; ?>col left">

              <h3>Literature</h3>

              <?php 
              $num=0;
              foreach ($resources as $row){
                $title = $webhelper->CurRightString($row["title"], "107");
                $fullTitle = $row["title"];
                $gtmUrl = str_replace(" ","-",$fullTitle);
                $thmb = $row["thumbnail"];
                switch($row["type"]){
                    case 1:
                        $type = 'Brochure';
                        break;
                   case 2:
                        $type = 'Document';
                        break;
                    case 3:
                        $type = 'Publication';
                        break;
                }
                ?>

                <div class="docs col<?php echo $col; ?>-docs left">

                  <div class="docs-section left">
                    <div class="thmb-with-shadow">
                     <a href="/inc/lib/download_literatures?pkid=<?php echo $row["pkid"]; ?>&title=<?php echo $gtmUrl; ?>" class="brochures-btn hover-thmb">
                       <picture>
                          <source srcset="<?php echo cdn ?>/files/literatures/<?php echo $thmb; ?>" media="(min-width: 760px)">
                          <source srcset="<?php echo cdn ?>/files/literatures/<?php echo $thmb; ?>">
                          <img src="<?php echo cdn ?>/files/literatures/<?php echo $thmb; ?>" alt="Elegen High Fidelity DNA" class="shadow-bg"/>
                        </picture>
                      <span class="download-hover"><em>DOWNLOAD PDF</em></span></a>
                    </div>
                     <div class="brochures-text left">
                       <p><?php echo $type; ?></p>
                       <h4><?php echo $title; ?></h4>
                       <p><?php if(!empty($row['body']) && $row['body'] != 'none') echo $row['body'];?></p>
                     </div>
                  </div>

                </div>

             <?php
                  }
              ?>

          </div>

        <?php } ?>

     </section>
           
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/quick-request.php'); ?>
<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
</body>
</html>