<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/company/contact-us";
$PageCode = "060101";
$bodyid = "company";
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<title>Request Info | ELEGEN</title>
<meta name="description" content="Contact Us" />
<meta name="keywords" content="synthetic biology, dna, gene, sequence, molecules" />
<link rel="canonical" href="https://www.elegenbio.com/company/contact-us" />
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head-section.php'); ?>
<style>
 @media all and (max-width: 845px) {
  .left-paragraph {text-align: center}
  }
</style>
	
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'); ?>
 
<main role="main">


<section id="contact-form" class="wide-section hero-section ask-dna-form">
 
            <div class="page-inner">

              <div class="left-paragraph">

                <img src="/img/common/Icon-Elegen-Full.svg" class="hero-logo" />
                <p><span class="line-break elegen-green-text">How can we help?</span></p>
                <h1>REQUEST INFO</h1>
                <p>We're happy to answer your questions about our products, sales, customer support, careers, or investor relations. Please fill out the form and submit, and we will get back to you as soon as we can.</p>

              </div>

              <form method="post" name="askDnaFrm" id="home-form" class="right-paragraph">

                    <?php
                        if(isset($error)) {
                           echo '<ul id="error-box">';
                           foreach($error as $item) {
                              echo "<li>$item</li>";
                           }
                           echo '</ul>';
                    } ?>

                    <h4>* Required</h4>

                     <fieldset id="field-one">
                        <label for="First Name" class="visually-hidden">First Name<span>*</span></label>
                        <input type="text" name="first" id="first" class="get-value" placeholder="*First Name" maxlength="50"
                            <?php if(isset($missing)) {
                              echo 'value="'.htmlentities($_POST['first']).'"';
                             } ?> tabindex="1" />

                        <label for="Email Address" class="visually-hidden">Email Address<span>*</span></label>
                        <input type="email" name="email" class="get-value" id="email" placeholder="*Email Address" maxlength="100"
                            <?php if(isset($missing)) {
                              echo 'value="'.htmlentities($_POST['email']).'"';
                             } ?> tabindex="3" />
  
                        <label for="Zip Code" class="visually-hidden">Zip Code<span>*</span></label>
                        <input type="text" name="zip" id="zip" class="get-value" placeholder="*Zip Code" maxlength="50"
                            <?php if(isset($missing)) {
                              echo 'value="'.htmlentities($_POST['zip']).'"';
                             } ?> tabindex="5" />

                        
                    </fieldset>

                    <fieldset>
          <label for="Last Name" class="visually-hidden">Last Name<span>*</span></label>
            <input type="text" name="last" id="last" class="get-value" placeholder="*Last Name" maxlength="50"
                <?php if(isset($missing)) {
                  echo 'value="'.htmlentities($_POST['last']).'"';
                 } ?> tabindex="2" />

            <label for="Company / Organization" class="visually-hidden">Company / Organization<span>*</span></label>
            <input type="text" name="organization" id="organization" class="get-value" placeholder="*Company / Organization" maxlength="150"
                  <?php if(isset($missing)) {
                  echo 'value="'.htmlentities($_POST['organization']).'"';
                 } ?> tabindex="4" />

            <label for="Country" class="visually-hidden">Country<span>*</span></label>
            <input type="text" name="country" id="country" class="get-value" placeholder="*Country" maxlength="50"
                <?php if(isset($missing)) {
                  echo 'value="'.htmlentities($_POST['country']).'"';
                 } ?> tabindex="5" />

                    </fieldset>

                    <fieldset>
                      
                    <label for="Questions / Requests" class="visually-hidden">Questions / Requests</label>
                   <textarea name="questions" id="questions" placeholder="*Questions / Requests" rows="1" cols="1" minlength="10" aria-required="true" class="get-value" tabindex="6"><?php if(isset($missing)){
                    echo htmlentities($_POST['questions']);
                    }?></textarea>

                    <div class="g-recaptcha" data-sitekey="<?php echo $webhelper->invCaptchaPublic; ?>" data-size="invisible" data-callback="formSubmit"></div>

                        <div id="request-checkboxes" class="request-checkboxes">
                          <input type="checkbox" name="newsletters" id="newsletters" value="1" tabindex="7" /><label for="Elegen newsletters">I would like to receive the latest news and updates from Elegen.</label>
                      </div>

                      <input type="submit" name="register" value="Submit" class="btn green-btn smooth-hover" id="register-btn" tabindex="7" />

                      <p>Elegen <a href="/company/privacy-policy">Privacy Policy</a></p>
                    </fieldset>

                </form>
              
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