<?php
include_once('../../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $input = $_SESSION['user'];
  if($input == 0){
    header('Location: /admin/');
    exit;
  }else{
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $input);
   if(!empty($username)){
      $PageUrl = "/admin/manager/list";
      $PageCode = "000000";
      $bodyid = "manager";
      $FirstPageCode = substr($PageCode, 0, 2);
      $SecodeCode = substr($PageCode, 2, 2);
      $ThirdCode = substr($PageCode, 4, 2);
      if(isset($_GET['pkid']) && !empty($_GET['pkid'])){
       $pkid = $webhelper->RequestFilter('pkid', 0, false);   
       $exists = $dbhelper->numOfRows('SELECT id FROM admin WHERE pkid = ?', 'i', $pkid); 
       if($exists > 0){
        //Parameter
        $page = $webhelper->RequestFilter("page", 0, false);
        $searchKey = $webhelper->RequestFilter("searchKey", -1, false);
        $filter = $webhelper->RequestFilter("filter", 0, false);
        $order = $webhelper->RequestFilter("order", 0, false);
        $Parameter = "&searchKey=$searchKey&filter=$filter&order=$order";
        $ViewData = $dbhelper->RunSQLReturnOneRow("SELECT pkid, id, firstname, lastname, pass, email, 
                    status, isAdministrator, isEditor, isHR, company, country, providence, city, 
                    postcode, phone FROM admin WHERE pkid = $pkid ");
       }else{
        header('Location: /admin/manager/list');
        exit;
       }
      }
    }else{
        header('Location: /admin/');
        exit;
    }
  }
}else{
  header('Location: /admin/');
  exit;
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>Modify Manager User | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2>EDIT ACCOUNT INFO</h2>

            <form method="post" name="registerFrm" id="enter-data">
             <input type="hidden" name="pkid"  value="<?php echo $pkid; ?>" />

             <fieldset id="field-one">
                <label for="Username">Username<span>*</span></label>
                <input type="text" name="username" id="username" class="get-value" placeholder="*Username" maxlength="50"
                    <?php 
                      echo 'value="'.htmlentities($ViewData["id"]).'"';
                    ?> tabindex="1" />
                <p>Must be at least 5 characters and no spaces.</p>
            </fieldset>

            <fieldset>
                <label for="Email Address">Email Address<span>*</span></label>
                <input type="email" name="email" class="get-value" id="email" placeholder="*Email Address" maxlength="50" 
                    <?php
                      echo 'value="'.htmlentities($ViewData["email"]).'"';
                    ?> tabindex="2" />
            </fieldset>

            <fieldset class="request-checkboxes">

                <?php $active = $ViewData["status"] == 1 ? "checked='checked'" : ''; 
                      $blocked = $ViewData["status"] == 0 ? "checked='checked'" : ''; 
                ?>

                <div>
                <input type="radio" name="status" <?php echo $blocked; ?> value="0" tabindex="5" /><label for="Blocked">Blocked</label>
                </div>
                <div>
                <input type="radio" name="status" value="1" <?php echo $active; ?> tabindex="6" /><label for="Active">Active</label>
                </div>
             
            </fieldset>

            <fieldset class="request-checkboxes">
                <?php $admin = $ViewData["isAdministrator"] == 1 ? "checked='checked'" : ''; 
                      $editor = $ViewData["isEditor"] == 1 ? "checked='checked'" : ''; 
                      $hr = $ViewData["isHR"] == 1 ? "checked='checked'" : '';
                ?>
                <h4>ROLES</h4>
                <div>
                <input type="checkbox" name="type[0]" value="1" <?php echo $admin; ?> tabindex="7" /><label for="Administrator">Administrator</label>
                </div>
                <div>
                <input type="checkbox" name="type[1]" value="1" <?php echo $editor; ?> tabindex="8" /><label for="Editor of Content">Editor of Content</label>
                </div>
                <div>
                <input type="checkbox" name="type[2]" value="1" <?php echo $hr; ?>tabindex="8" /><label for="HR">HR</label>
                </div>
             
            </fieldset>

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
            <label for="State">State<span>*</span></label>
            <input type="text" name="state" id="state" class="get-value" placeholder="*State" maxlength="150"
                  <?php
                  echo 'value="'.htmlentities($ViewData["providence"]).'"';
                  ?> tabindex="13" />
            </fieldset>

            <fieldset>
            <label for="City">City<span>*</span></label>
            <input type="text" name="city" id="city" class="get-value" placeholder="*City" maxlength="50"
                <?php
                  echo 'value="'.htmlentities($ViewData["city"]).'"';
                ?> tabindex="14" />
            </fieldset>

            <fieldset>
            <label for="Zip">Zip<span>*</span></label>
            <input type="text" name="zip" id="zip" class="get-value" placeholder="*Zip" maxlength="20"
                  <?php 
                  echo 'value="'.htmlentities($ViewData["postcode"]).'"';
                   ?> tabindex="15" />
            </fieldset>

            <fieldset>
            <label for="Phone">Phone<span>*</span></label>
            <input type="text" name="phone" id="phone" class="get-value" placeholder="*Phone" maxlength="50"
                <?php
                  echo 'value="'.htmlentities($ViewData["phone"]).'"';
                ?> tabindex="16" />
            </fieldset>

            <fieldset id="user-submit">
                <input type="submit" name="create" value="SAVE" class="green-btn smooth-hover" id="submit-btn" tabindex="17" />
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
 $('form#enter-data').submit(function(){
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
      var regBtn = $('#submit-btn');
      regBtn.prop('disabled', true);
      regBtn.val('Please Wait').css('background','#377476');
      var f = $('#enter-data');
      var query = f.serializeArray();
      var param="<?php echo $pkid.'&page='.$page.$Parameter; ?>";
      $('#error-box').remove();
      var errorBox = $(document.createElement('fieldset'));
      var errorText = $(document.createElement('li'));
      var fieldOne = $('#user-submit');
      $.ajax({
         type:'POST',
         url:'/admin/manager/modify',
         data:query,
         success:function(data){
           if(data == 0){
              errorBox.attr('id','error-box').insertBefore(fieldOne);
              errorText.text('That did not go through. Please try again.').appendTo(errorBox);
              regBtn.prop('disabled', false);
              regBtn.val('SAVE').css('background','#80BC61');
           }else if(data == 2){
             errorBox.attr('id','error-box').insertBefore(fieldOne);
             errorText.text("Username and/or Email are not valid.").appendTo(errorBox);
             regBtn.prop('disabled', false);
             regBtn.val('SAVE').css('background','#80BC61');
           }else if(data == 3){
             errorBox.attr('id','error-box').insertBefore(fieldOne);
             errorText.text("Username and/or Email already exists").appendTo(errorBox);
             regBtn.prop('disabled', false);
             regBtn.val('SAVE').css('background','#80BC61');
           }else if(data == 4){
              errorBox.attr('id','error-box').insertBefore(fieldOne);
              errorText.text('Email already exists').appendTo(errorBox);
              regBtn.prop('disabled', false);
              regBtn.val('SAVE').css('background','#80BC61');
           }else if(data == 5){
              errorBox.attr('id','error-box').insertBefore(fieldOne);
              errorText.text('All fields are required.').appendTo(errorBox);
              regBtn.prop('disabled', false);
              regBtn.val('SAVE').css('background','#80BC61');
           }
           else if(data == 6){
             errorBox.attr('id','error-box').insertBefore(fieldOne);
             errorText.text("Must select at least one checkbox under Roles.").appendTo(errorBox);
             regBtn.prop('disabled', false);
             regBtn.val('SAVE').css('background','#80BC61');
           }
           else{
        document.location.href = "/admin/manager/list?pkid="+param;
           }
         },
         error:function(XMLHttpRequest, textStatus, errorThrown){
              errorBox.attr('id','error-box').insertBefore(fieldOne);
              errorText.text('We are having some technical issues. Contact Web Developer.').appendTo(errorBox);
              regBtn.prop('disabled', false);
              regBtn.val('CREATE ACCOUNT').css('background','#80BC61');
         }
      });
    }
    return false;
 });
});
</script>

