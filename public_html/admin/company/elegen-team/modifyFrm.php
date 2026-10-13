<?php
include_once('../../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
   $input = $_SESSION['user'];
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      $PageUrl = "/admin/company/elegen-team/modifyFrm";
      $PageCode = "000000";
      $bodyid = "company";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
       $pkid = $webhelper->RequestFilter('pkid', 0, false);   
       $exists = $dbhelper->numOfRows('SELECT first FROM employee_profile WHERE pkid = ?', 'i', $pkid); 
       if($exists > 0){
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        $Parameter = "&searchKey=$searchKey&order=$order";
        $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT * FROM employee_profile WHERE pkid = $pkid ");
       }else{
        header('Location:/admin/company/elegen-team/list');
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
<title>Edit Employee Spotlight | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel" class="modify-data">

            <h2>EDIT EMPLOYEE SPOTLIGHT</h2>

            <form method="post" name="modifyForm" action="/admin/company/elegen-team/modify" id="enter-data" enctype="multipart/form-data">
                <input type="hidden" name="pkid"  value="<?php echo $ViewData["pkid"]; ?>" />
                <input type="hidden" name="pkids[]"  value="<?php echo $ViewData["pkid"]; ?>" />
                <input type="hidden" name="page"  value="<?php echo $page; ?>" />
                <input type="hidden" name="searchKey"  value="<?php echo $searchKey; ?>" />
                <input type="hidden" name="order"  value="<?php echo $order; ?>" />
                <input type="hidden" name="oldheadshot" value="<?php echo $ViewData["headshot"]; ?>" />
                <input type="hidden" name="oldHobby" value="<?php echo $ViewData["hobby_thumb"]; ?>" />

            <fieldset>
                <label for="First Name"><span>*</span>First Name</label>
                <input type="text" name="first" id="first" value="<?php echo $ViewData['first']; ?>" class="get-value" placeholder="<?php echo $ViewData['first']; ?>" maxlength="50" tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="Last Name"><span>*</span>Last Name</label>
                <input type="text" name="last" id="last" value="<?php echo $ViewData['last']; ?>" class="get-value" placeholder="<?php echo $ViewData['last']; ?>" maxlength="50" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Job Title"><span>*</span>Job Title</label>
                <input type="text" name="jobtitle" id="job-title" value="<?php echo $ViewData['job_title']; ?>" class="get-value" placeholder="<?php echo $ViewData['job_title']; ?>" maxlength="250" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Quote"><span>*</span>Employee Quote</label>
                 <textarea name="quote" value="<?php echo $ViewData['quote']; ?>" class="get-value" id="quote" placeholder="*Enter employee quote text without quotes" rows="1" cols="1" minlength="50" maxlength="500" class="get-value" tabindex="4"><?php echo $ViewData['quote']; ?></textarea>
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Headshot"><span>*</span>HEADSHOT IMAGE</label>
            <input type="file" name="headshot_img" tabindex="11" />
            <?php 
             if(!empty($ViewData["headshot"]) && $ViewData["headshot"] != 'none'){
                 echo "<div>";
                 echo "<img src=\"/files/team/" . $ViewData["headshot"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset>
             <label for="Page Body">*Page Body</label>
             <textarea name="pagebody" id="page-body" placeholder="* eg. <h3>Question</h3> <p>Answer</p>" rows="1" cols="1" minlength="100" class="get-value" tabindex="6"><?php echo $ViewData['body']; ?></textarea>
            </fieldset>

            <fieldset>
             <label for="Hobby Text">Favorite hobbies</label>
               <textarea name="hobbytext" id="hobby-text" rows="1" cols="1" minlength="100" maxlength="500" tabindex="7"><?php echo $ViewData['hobby']; ?></textarea>
            </fieldset>

            <fieldset class="upload-field upload-tmb">
            <label for="Hobby Image"><span>*</span>HOBBY IMAGE</label>
            <input type="file" name="hobby_img" tabindex="11" />
            <?php 
             if(!empty($ViewData["hobby_thumb"]) && $ViewData["hobby_thumb"] != 'none'){
                 echo "<div>";
                 echo "<img src=\"/files/team/" . $ViewData["hobby_thumb"] . "\">";
                 echo "</div>";
                }
            ?>
            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="green-btn smooth-hover" id="submit-btn" tabindex="13" />
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
<script>
$(function(){
 $('#submit-btn').click(function(e){
     e.preventDefault();
     var isValid = true;
     var regField = [];
     $.each($('.get-value'),function(){
       regField.push($('#'+this.id).val());
         if($('#'+this.id).val() === ''){
           $(this).css('border','1px solid red');
           isValid = false;
         }
     });
     if(isValid){
       var f = document.modifyForm;
       f.submit();
     }
 });
});
</script>

