<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['name']) && basename($_GET['name']) == $_GET['name']){
  $urlName = trim($_GET['name']);
  $dbhelper = new dbHelper('user');
  $webhelper = new WebHelper();
  $id = $dbhelper->selectOne("SELECT pkid FROM videos WHERE slugurl = ?", 's', $urlName);
  if($id == 0){
    header('Location: /resources/videos'); 
    exit;
  }else{
    $dbhelper = new dbHelper('user');
    $webhelper = new WebHelper();
    $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM videos WHERE pkid = $id ");
    $PageUrl = "/company/resources/videos";
    $PageCode = "040102";
    $bodyid = "resources";
    $FirstPageCode = substr($PageCode, 0, 2);
    $SecodeCode = substr($PageCode, 2, 2);
    $ThirdCode = substr($PageCode, 4, 2);
  }
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title><?php echo $ViewData['title']; ?> | ELEGEN</title>
<meta name="description" content="Watch <?php echo $ViewData['title']; ?> Video" />
<link rel="canonical" href="https://elegen.8romans.com/resources/vidoes/<?php echo $ViewData['slugurl']; ?>" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">

    <section id="videos-section" class="wide-section">

        <div class="page-inner">

          <div class="center-paragraph">

             <h4><?php echo $ViewData['title']; ?></h4>

             <div class="iframe-video">
               <iframe id="ytplayer"
              src="https://www.youtube.com/embed/<?php echo $ViewData['youtube_url']; ?>?rel=0"></iframe>
             </div>
          </div>

          <div class="center-paragraph">
             <p><?php echo $ViewData['body']; ?></p>

           </div>
          
        </div>

     </section>

</main>

<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
</body>
</html>