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
    $PageUrl = "/admin/company/elegen-team/registerFrm";
    $PageCode = "000000";
    $bodyid = "company";
    $FirstPageCode = substr($PageCode, 0, 2);
    $SecodeCode = substr($PageCode, 2, 2);
    $ThirdCode = substr($PageCode, 4, 2);
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
<title>Add New Employee Spotlight | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2>ADD NEW EMPLOYEE SPOTLIGHT</h2>

            <?php
                if(isset($_GET['error'])) {
                    $error = $webhelper->RequestFilter("error", 100, false);
                    $error = strtoupper($error);
                    echo '<ul id="display-error">';
                      echo "<li>$error</li>";
                    echo '</ul>';
                } 
            ?>

            <form method="post" name="regFrm" action="/admin/company/elegen-team/register" id="enter-data" enctype="multipart/form-data">

            <fieldset>
                <label for="First Name">First Name<span>*</span></label>
                <input type="text" name="first" id="first" class="get-value" placeholder="*First Name" maxlength="50" tabindex="1" />
            </fieldset>

            <fieldset>
                <label for="Last Name">Last Name<span>*</span></label>
                <input type="text" name="last" id="last" class="get-value" placeholder="*Last Name" maxlength="50" tabindex="2" />
            </fieldset>

            <fieldset>
                <label for="Job Title">Job Title<span>*</span></label>
                <input type="text" name="jobtitle" id="job-title" class="get-value" placeholder="*Job Title" maxlength="250" tabindex="3" />
            </fieldset>

            <fieldset>
                <label for="Quote">Employee Quote<span>*</span></label>
                <textarea name="quote" class="get-value" id="quote" placeholder="*Enter employee quote text without quotes" rows="1" cols="1" minlength="50" maxlength="500" class="get-value" tabindex="4"></textarea>
            </fieldset>

            <fieldset class="upload-field">
            <label for="HEADSHOT IMAGE"><span>*</span>HEADSHOT IMAGE</label>
            <input type="file" name="headshot_img" tabindex="5" />
            </fieldset>

            <fieldset>
             <p class="field-eg">Use h3 tag for Question and p tag for an Answer.</p>
             <label for="Page Body">Page Body</label>
               <textarea name="pagebody" id="page-body" placeholder="* eg. <h3>Question</h3> <p>Answer</p>" rows="1" cols="1" minlength="100" class="get-value" tabindex="6"></textarea>
            </fieldset>

            <fieldset>
             <label for="Hobby Text">Favorite hobbies</label>
               <textarea name="hobbytext" id="hobby-text" placeholder="Favorite hobbies" rows="1" cols="1" minlength="100" maxlength="500" tabindex="7"></textarea>
            </fieldset>

            <fieldset class="upload-field">
            <label for="HEADSHOT IMAGE">HOBBY IMAGE</label>
            <input type="file" name="hobby_img" tabindex="8" />
            </fieldset>

            <fieldset id="doc-submit">
                <input type="submit" name="create" value="SAVE" class="green-btn smooth-hover" id="submit-btn" tabindex="9" />
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
     $('#error-box').remove();
     var errorBox = $(document.createElement('fieldset'));
     var errorText = $(document.createElement('li'));
     var regField = [];
     $.each($('.get-value'),function(){
       regField.push($('#'+this.id).val());
         if($('#'+this.id).val() === ''){
           $(this).css('border','1px solid red');
           isValid = false;
         }
     });
     if(isValid){
       $('#submit-btn').prop('disabled', true);
       $('#submit-btn').val('Please Wait').css('background','#7d868c');
       var f = document.regFrm;
       f.submit();
     }
 });
});
</script>
</body>
</html>
