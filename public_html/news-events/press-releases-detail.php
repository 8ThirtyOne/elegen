<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['title']) && !empty($_GET['title'])){
$title = $_GET['title'];
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$pkid = $dbhelper->selectOne('SELECT pkid FROM press WHERE slugurl = ?', 's', $title);
if($pkid > 0){
  $PageUrl = "/news-events/press-releases-detail";
  $PageCode = "030102";
  $bodyid = "news";

  $sql = "SELECT * FROM press WHERE pkid = $pkid ";
  $ViewData = $dbhelper->RunSQLReturnOneRow($sql);
   //Prev
      $sql = "SELECT slugurl FROM press WHERE status = 1 AND pkid != $pkid 
              AND concat(year, month, day)  < '" . $ViewData["year"] . $ViewData["month"] . $ViewData["day"] . "' ";
      $sql .= " ORDER BY year desc, month desc, day desc, pkid desc";
      $Prev = $dbhelper->RunSQLReturnOneRow($sql);

      //Next 
      $sql = "SELECT slugurl FROM press WHERE status = 1 AND pkid != $pkid 
              and concat(year, month, day)  > '" . $ViewData["year"] . $ViewData["month"] . $ViewData["day"] . "' ";
      $sql .= " ORDER BY year, month, day, pkid";
      $Next = $dbhelper->RunSQLReturnOneRow($sql);
  $keyword = false;
  $keyword = !empty($_GET['searchYear']) || !empty($_GET['page']) ? true : false;
  if(isset($ViewData["maintitle"])){
    $pageTitle = $webhelper->CurRightString($ViewData["maintitle"], 100);
    $metaDesc = $webhelper->CurRightString($ViewData["body"], 200);
    $metaDesc = strip_tags($metaDesc);
  }        
  $FirstPageCode = substr($PageCode, 0, 2);
  $SecodeCode = substr($PageCode, 2, 2);
  $ThirdCode = substr($PageCode, 4, 2);
  }else{
     header('Location: /news-events/press-releases');
     exit;
  }
}else{
 header('Location: /news-events/press-releases');
 exit;
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?php echo $pageTitle; ?> - Press Release | ELEGEN</title>
<meta name="description" content="<?php echo $metaDesc; ?> - Press | ELEGEN" />
<?php 
echo "<link rel='canonical' href='https://www.elegenbio.com/news-events/". $ViewData['pressurl']."' />";
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); 
?>  
</head>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main">

      <section class="wide-section" id="single-press-page">
 
            <div class="page-inner">

                 <div class="center-paragraph">

                  <div id="page-nav">
                  <?php
                    if($Prev != null && !empty($Prev["pressurl"])){
                      echo '<a href="/news-events/'.$Prev["slugurl"].'" class="prev btn smooth-hover">Newer</a>';
                    }else{
                      echo '<a href="#" class="prev btn">Newer</a>';
                    }
                  ?>

                  <?php
                    if($Next != null && !empty($Next["pressurl"])){
                      echo '<a href="/news-events/'.$Next["slugurl"].'" class="next btn smooth-hover">Older</a>';
                    }else{
                      echo '<a href="#" class="next btn">Older</a>';
                    }
                  ?>
                  </div>

                    <div id="single-press-date">
                      <p><?php echo $webhelper->GetMonthName($ViewData["month"])?> <?=$ViewData["day"]?>, <?=$ViewData["year"]; ?></p>
                    </div>

                    <div id="press-share">
                    <ul>
                        <li>
                        <a href="http://linkedin.com/shareArticle?mini=true&url=https://<?php echo $webhelper->Domain; ?>/news-events/press-releases-detail?pkid=<?php echo $pkid; ?>&title=<?php echo $ViewData["maintitle"]; ?>" class="smooth-hover" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <li>
                        <a href="http://twitter.com/home?status=<?=$ViewData["maintitle"]?> https://<?php echo $webhelper->Domain; ?>/news-events/press-releases-detail?pkid=<?php echo $pkid; ?>" class="smooth-hover" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li>
                        <a href="http://www.facebook.com/sharer?s=100&p[url]=https://<?php echo $webhelper->Domain; ?>/news-events/press-releases-detail?pkid=<?php echo $pkid; ?>&p[title]=<?php echo $ViewData["maintitle"]; ?>" class="smooth-hover" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    </ul>
                    </div>

                    <article id="press-article">
            
                      <h4><?php echo $ViewData["maintitle"]; ?></h4>
                      <h5><?php echo $ViewData["subtitle"]; ?></h5>
                      <h6 id="press-source"><?php //echo $ViewData["source"]; ?></h6>
          
                      <div class="press-body">
                        <p><?php echo $ViewData["body"]; ?></p>
                      </div>

                    </article>

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