<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/news-events/press-releases";
$PageCode = "030102";
$bodyid = "news";
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'press'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);

//Parameter
$page = $webhelper->RequestFilter("page", 0, false);
$searchYear = $webhelper->RequestFilter("searchYear", 0, false);

//check parameter
if($webhelper->isNull($page)) $page = 1;
if($webhelper->isNull($searchYear)) $searchYear = date("Y");

$Parameter = "&searchYear=$searchYear";
$PageSize = 4;

$sql = "SELECT * FROM press WHERE status = 1 ";
    
if($searchYear == 0){
    $sql .= " AND year <= 2008 ";
}else if($searchYear == 2019){
    $sql .= "AND year > 2016 ";
 }else{
    $sql .= " AND year = $searchYear ";
}
        
$sql .= "ORDER BY year desc, month desc, day desc";

$List = $dbhelper->RunSQLReturnRowsSub($sql, $page, $PageSize, $TotalCount);
$pageList = $webhelper->getPaging($TotalCount, $page, $PageSize);
$keyword = false;
$keyword = isset($_GET['page']) || isset($_GET['searchYear']) ? true : false;

$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<?php 
if($page == 1 && !$keyword){ ?>
<title>Press Releases | Elegen</title>
<meta name="description" content="Elegen Press Releases. Discover the latest news about our company, our products, our policies, and our people" />
<meta name="keywords" content="press, press releases, media, investors" />
<link rel="canonical" href="https://elegenbio.com/news-events/press-releases/" />
<?php 
}
if($page > 1 && $searchYear < date('Y')){ 
  if($searchYear == 0){ 
       echo "<title>Press Releases - Archive - Page ".$page." | Elegen </title>";
       echo "<meta name='description' content='Page $page of Elegen Press Releases - Archive. Discover the latest news about our company, our products, our policies, and our people.' />";
       echo "<meta name='keywords' content='High Fidelity DNA' />";
       echo "<link rel='canonical' href='https://www.elegenbio.com/news-events/press-releases?page=".$page."&searchYear=0' />";
  }
  else{
       echo "<title>Press Releases ".$searchYear." - Page ".$page." | Elegen</title>";
       echo "<meta name='description' content='Page $page of Elegen Press Releases - Year $searchYear. Discover the latest news about our company, our products, our policies, and our people.' />";
       echo "<meta name='keywords' content='High Fidelity DNA' />";
       echo "<link rel='canonical' href='https://www.elegenbio.com/news-events/press-releases?page=".$page."&searchYear=".$searchYear."' />";
  }
} 
if($page > 1 && $searchYear == date('Y')){ 
   echo "<title>Press Releases ".$searchYear." - Page ".$page." |Elegen</title>";
   echo "<meta name='description' content='Page $page of Elegen Press Releases - Year $searchYear. Discover the latest news about our company, our products, our policies, and our people.' />";
   echo "<meta name='keywords' content='High Fidelity DNA' />";
   echo "<link rel='canonical' href='https://www.elegenbio.com/news-events/press-releases?page=".$page."&searchYear=".$searchYear."' />";
}
if($page == 1 && $keyword){
     if($searchYear == 0){ 
       echo "<title>Press Releases - Archive - Page ".$page." | Elegen</title>";
       echo "<meta name='description' content='Page $page of Elegen Press Releases - Archive. Discover the latest news about our company, our products, our policies, and our people.' />";
       echo "<meta name='keywords' content='High Fidelity DNA' />";
       echo "<link rel='canonical' href='https://www.elegenbio.com/news-events/press-releases?page=".$page."&searchYear=0' />";
  }
  else{
       echo "<title>Press Releases ".$searchYear." - Page ".$page." | Elegen</title>";
       echo "<meta name='description' content='Page $page of Elegen Press Releases - Year $searchYear. Discover the latest news about our company, our products, our policies, and our people.' />";
       echo "<meta name='keywords' content='High Fidelity DNA' />";
       echo "<link rel='canonical' href='https://www.elegenbio.com/news-events/press-releases?page=".$page."&searchYear=".$searchYear."' />";
  }
}
      include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php');
?>  
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
 
   <section class="hero-section short-hero" id="press-hero">

    <div class="page-inner">

          <section class="left-hero-content white-text">
              <h3>The latest news and updates</h3>
              <h1>Press Releases</h1>
          </section>
 
    </section>
 
      <section class="wide-section">
 
            <div class="page-inner">

                 <!--<div class="center-paragraph">

                    <h2>Press Releases</h2>

                 </div>-->

            </div>

     </section>
    <?php 
     if($List != null && count($List) > 0){
                        foreach ($List as $row){ ?>
     <section class="wide-section no-margin" id="press-section">

        <div class="page-inner narrow-section">

           <div class="press-list">
                 

              <article class="press-article">

                 <h4><?php echo $webhelper->GetMonthShortName($row["month"]); ?> <?php echo $row["day"]; ?>, <?php echo $row["year"]; ?></h4>  

                  <a class="press-title smooth-hover" href="/news-events/<?php echo $row["slugurl"]; ?>"><?php echo $row["maintitle"]; ?></a>
                  <p class="press-text"><?php echo $webhelper->CurRightString($row["subtitle"], "400"); ?></p>
                  <a class="press-btn btn smooth-hover" href="/news-events/<?php echo $row["slugurl"]; ?>">READ</a>

              </article>
              </div>

            </div>

      </section>

        <?php 
            } 
        } ?>

        <section class="wide-section">
 
            <div class="page-inner">

                 <div class="center-paragraph">

        <?php if(!empty($List)) echo $webhelper->GetPageHtml($pageList, $page, $PageUrl, $Parameter, $PageSize); ?>

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