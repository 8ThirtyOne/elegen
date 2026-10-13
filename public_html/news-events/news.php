<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/news-events/news";
$PageCode = "030102";
$bodyid = "company";
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'articles'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);

//Parameter
$page = $webhelper->RequestFilter("page", 0, false);
$searchYear = $webhelper->RequestFilter("searchYear", 0, false);

//check parameter
if($webhelper->isNull($page)) $page = 1;
if($webhelper->isNull($searchYear)) $searchYear = date("Y");

$Parameter = "&searchYear=$searchYear";
$PageSize = 10;

$sql = "SELECT * FROM articles WHERE status = 1 ";  
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
<title>News | Elegen</title>
<meta name="description" content="Elegen News. Discover the latest articles about our company, our products, our policies, and our people" />
<meta name="keywords" content="articles, media, investors" />
<link rel="canonical" href="https://elegenbio.com/news-events/news" />
<?php 
}
if($page > 1 && $searchYear < date('Y')){ 
  if($searchYear == 0){ 
       echo "<title>News - Archive - Page ".$page." | Elegen </title>";
       echo "<meta name='description' content='Page $page of Elegen News - Archive. Discover the latest news about our company, our products, our policies, and our people.' />";
       echo "<meta name='keywords' content='High Fidelity DNA' />";
       echo "<link rel='canonical' href='https://www.elegenbio.com/news-events/news?page=".$page."&searchYear=0' />";
  }
  else{
       echo "<title>News ".$searchYear." - Page ".$page." | Elegen</title>";
       echo "<meta name='description' content='Page $page of Elegen News - Year $searchYear. Discover the latest news about our company, our products, our policies, and our people.' />";
       echo "<meta name='keywords' content='High Fidelity DNA' />";
       echo "<link rel='canonical' href='https://www.elegenbio.com/news-events/news?page=".$page."&searchYear=".$searchYear."' />";
  }
} 
if($page > 1 && $searchYear == date('Y')){ 
   echo "<title>News ".$searchYear." - Page ".$page." |Elegen</title>";
   echo "<meta name='description' content='Page $page of Elegen News - Year $searchYear. Discover the latest news about our company, our products, our policies, and our people.' />";
   echo "<meta name='keywords' content='High Fidelity DNA' />";
   echo "<link rel='canonical' href='https://www.elegenbio.com/news-events/news?page=".$page."&searchYear=".$searchYear."' />";
}
if($page == 1 && $keyword){
     if($searchYear == 0){ 
       echo "<title>News - Archive - Page ".$page." | Elegen</title>";
       echo "<meta name='description' content='Page $page of Elegen News - Archive. Discover the latest news about our company, our products, our policies, and our people.' />";
       echo "<meta name='keywords' content='High Fidelity DNA' />";
       echo "<link rel='canonical' href='https://www.elegenbio.com/news-events/news?page=".$page."&searchYear=0' />";
  }
  else{
       echo "<title>News ".$searchYear." - Page ".$page." | Elegen</title>";
       echo "<meta name='description' content='Page $page of Elegen News - Year $searchYear. Discover the latest news about our company, our products, our policies, and our people.' />";
       echo "<meta name='keywords' content='High Fidelity DNA' />";
       echo "<link rel='canonical' href='https://www.elegenbio.com/news-events/news?page=".$page."&searchYear=".$searchYear."' />";
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
              <h1>News</h1>
          </section>
 
    </section>
 
      <section class="wide-section"></section>

    <?php 
     if($List != null && count($List) > 0){
        foreach ($List as $row){ 
          $type = $row['type'];
          if($type == 1){
            $url = $row['filename'] == 'none' ? "target='_blank' href='" . $row['url'] . "'" : "href='/content/articles/" . $row['slugurl'] . "'";
            $btnClass = 'press-btn btn smooth-hover';
          }
          if($type == 2){
            if($row['filename'] == 'none'){
              $url = $row['filename'] == 'none' ? "target='_blank' href='" . $row['url'] . "'" : "href='/content/articles/" . $row['slugurl'] . "'";
              $btnClass = 'press-btn btn smooth-hover';
            }else{
              $url = "href='/files/news/" . $row['filename'] . "'";
              $btnClass = 'press-btn btn podcast-btn smooth-hover';
            }
          }
          $cta = $type == 1 ? 'READ' : 'LISTEN';
          $subtitle = $webhelper->CurRightString($row["subtitle"], "400");
        ?>
     <section class="wide-section no-margin" id="press-section">

        <div class="page-inner narrow-section">

           <div class="press-list">
                 
              <article class="press-article">

                 <h4><?php echo $webhelper->GetMonthShortName($row["month"]); ?> <?php echo $row["day"]; ?>, <?php echo $row["year"]; ?></h4>  
                  <h5>SOURCE: <?php echo $row["source"]; ?></h5>
                  <a class="press-title smooth-hover" <?php echo $url; ?>><?php echo $row["title"]; ?></a>
                  <p class="press-text"><?php echo stripcslashes($subtitle); ?></p>
                  <?php echo "<a class='".$btnClass."'".$url.">".$cta."</a>"; ?>

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
 
<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
<script>
document.querySelectorAll('.podcast-btn').forEach(btn => { 
  btn.addEventListener('click', function(e){
   e.preventDefault();
   let player = document.getElementById('audio-box');
   if(player) player.remove();
   player = document.createElement('div');
   player.setAttribute('id', 'audio-box');
   btn.parentNode.appendChild(player);
   processAudio(player, btn);
  });
});

function processAudio(elem, b){
   const audioElem = document.createElement('audio');
   //audioElem.setAttribute('controls', '');
   audioElem.setAttribute('id', 'audio-player');
   var source = document.createElement("source"); 
   source.src = b.getAttribute('href');
   source.type = "audio/mpeg";
   audioElem.appendChild(source);
   elem.prepend(audioElem);
   const a = new Audio(b.getAttribute('href'));
   if(b.text == 'LISTEN'){
     b.text = 'STOP';
     audioElem.setAttribute('autoplay', 'true');
   }else{
    elem.remove();
    document.querySelectorAll('.podcast-btn').forEach(btns => {btns.text = 'LISTEN'});
   }
}
</script>
</body>
</html>