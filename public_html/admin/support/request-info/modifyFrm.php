<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
   $input = trim($_SESSION['user']);
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      $PageUrl = "/admin/manager/list";
      $PageCode = "000000";
      $bodyid = "support";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
       $pkid = $webhelper->RequestFilter('pkid', 0, false);   
       $exists = $dbhelper->numOfRows('SELECT email FROM visitor WHERE pkid = ?', 'i', $pkid); 
       if($exists > 0){
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        $Parameter = "&searchKey=$searchKey&order=$order";
        $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT pkid, firstname, lastname, email,
                    company, country, zip, inquiry, newsletter FROM visitor WHERE pkid = $pkid ");
       }else{
        header('Location: /admin/support/request-info/list');
        exit;
       }
      }
    }else{
        header('Location: /admin/');
        exit;
    }
}else{
  header('Location: /admin/');
  exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>ADMIN PORTAL REQUEST INFO VISITORS | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2>REQUEST INFO VISITOR</h2>

            <form method="post" name="registerFrm" id="enter-data">
             <input type="hidden" name="pkid"  value="<?php echo $pkid; ?>" />

            <fieldset>
                <label for="First Name">First Name<span>*</span></label>
                <input type="text" name="first" id="first" class="get-value" placeholder="*First Name" maxlength="50"
                    <?php
                      echo 'value="'.htmlentities($ViewData["firstname"]).'"';
                    ?> tabindex="9" />
            </fieldset>

            <fieldset>
                <label for="Last Name">Last Name<span>*</span></label>
                <input type="text" name="last" id="last" class="get-value" placeholder="*Last Name" maxlength="50"
                    <?php
                      echo 'value="'.htmlentities($ViewData["lastname"]).'"';
                    ?> tabindex="10" />
            </fieldset>

                        <fieldset>
            <label for="Email Address">Email Address<span>*</span></label>
                <input type="email" name="email" class="get-value" id="email" placeholder="*Email Address" maxlength="50" 
                    <?php
                      echo 'value="'.htmlentities($ViewData["email"]).'"';
                    ?> tabindex="2" />
            </fieldset>

            <fieldset>
            <label for="Company / Organization">Company / Organization<span>*</span></label>
            <input type="text" name="organization" id="organization" class="get-value" placeholder="*Company / Organization" maxlength="150"
                  <?php
                  echo 'value="'.htmlentities($ViewData["company"]).'"';
                  ?> tabindex="11" />
            </fieldset>

            <fieldset>
            <label for="Country">Country<span>*</span></label>
            <input type="text" name="country" id="country" class="get-value" placeholder="*Country" maxlength="50"
                <?php
                  echo 'value="'.htmlentities($ViewData["country"]).'"';
                ?> tabindex="12" />
            </fieldset>

            <fieldset>
            <label for="Zip">Zip<span>*</span></label>
            <input type="text" name="zip" id="zip" class="get-value" placeholder="*Zip" maxlength="20"
                  <?php 
                  echo 'value="'.htmlentities($ViewData["zip"]).'"';
                   ?> tabindex="15" />
            </fieldset>

            <fieldset>
                <h4>I would like to receive the latest news and updates from Elegen.</h4>
                <?php $news = $ViewData["newsletter"] == 1 ? 'YES' : 'NO'; echo "<h3>$news</h3>"; ?>
            </fieldset>

            <fieldset id="user-submit">
                
            </fieldset>

        </form>

    </div>
    <!-- Page Inner -->

</section>

</main>

<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>

