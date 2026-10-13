<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
if(isset($_GET['slugurl']) && basename($_GET['slugurl']) == $_GET['slugurl']){
  $urlName = trim($_GET['slugurl']);
  $dbhelper = new dbHelper('user');
  $webhelper = new WebHelper();
  $id = $dbhelper->selectOne("SELECT pkid FROM employee_profile WHERE slugurl = ?", 's', $urlName);
  if($id == 0){
    header('Location: /admin/company/elegen-team'); 
    exit;
  }else{
    $dbhelper = new dbHelper('user');
    $webhelper = new WebHelper();
    $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM employee_profile WHERE pkid = $id ");
    $PageUrl = "/admin/company/elegen-team/profile";
    $PageCode = "060101";
    $bodyid = "company";
    $FirstPageCode = substr($PageCode, 0, 2);
    $SecodeCode = substr($PageCode, 2, 2);
    $ThirdCode = substr($PageCode, 4, 2);
  }
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Meet <?php echo $ViewData['first'].' '.$ViewData['last']; ?> | ELEGEN ADMIN</title>
<meta name="description" content="Admin Elegen Team Profile Preview" />
<link rel="canonical" href="https://elegen.8romans.com/admin/company/elegen-team/preview?slugurl=<?php echo $ViewData['slugurl']; ?>" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">

    <section class="hero-section" id="spotlight-hero">

    <div class="page-inner narrow-section">

          <section class="left-hero-content">
           <p><svg class="quote left-quote" viewBox="2 6 10 5"><path d="M7.066 6.76A1.665 1.665 0 0 0 4 7.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 0 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 7.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 0 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z"/></svg></p>
              <h1><?php echo stripslashes($ViewData['quote']); ?><span><svg class="quote right-quote" viewBox="3 6 10 5"><path d="M7.066 6.76A1.665 1.665 0 0 0 4 7.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 0 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 7.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 0 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z"/></svg></span></h1>

              <h2><?php echo $ViewData['first'].' '.$ViewData['last']; ?></h2>

              <h3><?php echo $ViewData['job_title']; ?></h3>

          </section>

          <div class="right-hero-content" id="employee-headshot">

            <img src="/files/team/<?php echo $ViewData['headshot']; ?>" />

          </div>
 
    </section>

    <section id="leadership-section" class="wide-section">

        <div class="page-inner narrow-section">

             <?php echo stripslashes($ViewData['body']); ?>
          
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