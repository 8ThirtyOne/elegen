<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/news-events/events";
$PageCode = "030102";
$bodyid = "company";
$hero = $dbhelper->RunSQLReturnOneRow("SELECT * FROM hero_images WHERE page_name = 'events'");
if(!empty($hero["desktop"])) $ext = pathinfo($hero["desktop"], PATHINFO_EXTENSION);

//Parameter
$page = $webhelper->RequestFilter("page", 0, false);
$searchYear = $webhelper->RequestFilter("searchYear", 0, false);

//check parameter
if($webhelper->isNull($page)) $page = 1;
if($webhelper->isNull($searchYear)) $searchYear = date("Y");

$Parameter = "&searchYear=$searchYear";
$PageSize = 10;

$sql = "SELECT pkid, type, year, startmonth, startday, endmonth, endday, title, subtitle, location1, url, body, booth, thumbnail, DATEDIFF(STR_TO_DATE(concat(year, '-', startmonth, '-', startday), '%Y-%m-%d'), CURDATE()) AS diff
    FROM events WHERE status = 1 ";  
$sql .= "ORDER by year ASC, startmonth ASC, startday ASC";

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

<title>Events | Elegen</title>
<meta name="description" content="Elegen Upcoming Events." />
<link rel="canonical" href="https://elegenbio.com/news-events/events" />
<?php  include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-sectionB.php'); ?>  
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
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/headerF.php'); ?>
 
<main role="main">
 
   <section class="hero-section short-hero" id="press-hero">

    <div class="page-inner">

          <section class="left-hero-content white-text">
              <h3>Visit us at our upcoming events</h3>
              <h1>Events</h1>
          </section>
 
    </section>
 
      <section class="wide-section"></section>

    <?php 
     if($List != null && count($List) > 0){
        foreach ($List as $row){ 
          $type = $row['type'];
          if($type == 1){
            $url = $row['url'] != 'none' ? "target='_blank' href='" . $row['url'] . "'" : "href='/" .$row['eventurl'] . "'";
          }
        ?>
     <section class="wide-section no-margin" id="press-section">

        <div class="page-inner narrow-section">

           <div class="event-list">

              <div class="event-thmb">
                <a class="zoom-img" <?php echo $url; ?>>
                  <img class="shadow-bg" src="/files/events/<?php echo $row["thumbnail"]?>" alt="<?php echo $row["title"]; ?>" />
                </a>
                <p><svg viewBox="0 0 24 24"><g><rect fill="none"/></g><g><path d="M19,4h-1V2h-2v2H8V2H6v2H5C3.89,4,3.01,4.9,3.01,6L3,20c0,1.1,0.89,2,2,2h14c1.1,0,2-0.9,2-2V6C21,4.9,20.1,4,19,4z M19,20 H5V10h14V20z M19,8H5V6h14V8z M9,14H7v-2h2V14z M13,14h-2v-2h2V14z M17,14h-2v-2h2V14z M9,18H7v-2h2V18z M13,18h-2v-2h2V18z M17,18 h-2v-2h2V18z"/></g></svg>
                <?php 
                   $startMonth = $webhelper->GetMonthShortName($row["startmonth"]);
                   $endMonth = $webhelper->GetMonthShortName($row["endmonth"]);
                   $date = $row["startday"] == $row["endday"] ? $row["startday"].', '.$row["year"] : $row["startday"].' - '.$row["endday"].', '.$row["year"];
                   if($row["endmonth"] > $row["startmonth"]){
                      echo $startMonth.' '.$row["startday"].' - '.$endMonth.' '.$row["endday"];
                   }else{
                      echo $startMonth.' '.$date; 
                   } ?>
                </p>

              </div>
                 
              <article class="press-article">

                  <a class="press-title smooth-hover" <?php echo $url; ?>><?php echo $row["title"]; ?></a>
                  <p class="event-sub"><?php echo $webhelper->CurRightString($row["subtitle"], "400"); ?></p>
                  <h4><?php echo $row["booth"]; ?></h4>
                  <h5><?php echo $row["location1"]; ?></h5>
                  <p class="event-body"><?php echo nl2br(stripcslashes($row["body"])); ?></p>
                  <?php echo "<a class='press-btn btn smooth-hover'".$url.">LEARN MORE</a>"; ?>

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
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scriptsB.php'); ?>
</body>
</html>