<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$webhelper = new WebHelper();
$dbhelper = new dbHelper('user');
$PageUrl = "/support/verify";
$PageCode = "050107";
$bodyid = "news";
$updOk = false;
$delOk = false;
$error = '';
if(isset($_GET['c'])){
  $token = trim($_GET['c']);
  if($token == ''){
     header('Location: /');
     exit();
  }

  $userId = $dbhelper->selectOne('SELECT user_id FROM web_subscribers_confirm WHERE token = ? AND expired > NOW()','s', $token);
  if($userId > 0){
     $name = $dbhelper->selectOne('SELECT firstname FROM web_subscribers WHERE pkid = ?','i', $userId);
     $updOk = $dbhelper->updateOne('UPDATE web_subscribers SET status = ? WHERE pkid = ?','ii',1, $userId);
     if($updOk){ 
        $sql = "DELETE FROM web_subscribers_confirm WHERE user_id = '$userId'";
        $dbhelper->RunSQL($sql);
     }else{
        $error = "Sorry, we are having some technical difficulties. Please try again later.";
     }
  }else{
    header('Location: /');
    exit();
  }
}else{
 header('Location: /');
 exit();
}

$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Confirm Email | ELEGEN</title>
<meta name="description" content="Subscriber Email Confirmation" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<?php 
 include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php');
?>   
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>

<main role="main">
  
    <section class="wide-section no-margin" id="thank-you-section">
 
           <div class="page-inner">

             <div class="center-paragraph">

                    <?php if(empty($error)){ ?>
                   <h2>Thank you</h2>
                   <h3>Hi <?php echo $name; ?>. Thank you for confirming your email. Keep an eye on your Inbox for the latest news from Elegen.</h3>
                <?php }else{ 
                   echo "<p>".$error."</p>";
                } ?>

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