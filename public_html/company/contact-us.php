<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/company/contact-us";
$PageCode = "060101";
$bodyid = "company";
$PageName = "Request Info";
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

              <form method="post" name="askDnaFrm" id="home-form" class="right-paragraph" role="form">
                <input type="hidden" name="refpage"  value="<?php echo $PageName; ?>" />
                   <div id="form-note">

                      <h4>* Required</h4>

                    </div>

                     <fieldset id="field-one">
                        <label for="First Name" class="visually-hidden">First Name<span>*</span></label>
                        <input type="text" name="first" id="first" class="get-value" placeholder="*First Name" pattern="[A-Za-z\s]{1,50}" title="Only letters are allowed." aria-required="true" maxlength="40" tabindex="1" />

                        <label for="Email Address" class="visually-hidden">Email Address<span>*</span></label>
                        <input type="email" name="email" class="get-value" id="email" placeholder="*Email Address" maxlength="100" tabindex="3" />
  
                        <label for="Zip Code" class="visually-hidden">Zip Code<span>*</span></label>
                        <input type="text" name="zip" id="zip" class="get-value" placeholder="*Zip Code" maxlength="20" pattern="[a-zA-Z0-9\-\s]+" title="Only valid zip codes are allowed." aria-required="true" tabindex="5" />

                        <label for="Phone" class="visually-hidden">Phone<span>*</span></label>
                        <input type="text" name="phone" id="phone" placeholder="Phone" maxlength="50" pattern="[0-9\(\)\-\s]+" title="Only valid phone numbers allowed." tabindex="7" />

                    </fieldset>

                    <fieldset>

                        <label for="Last Name" class="visually-hidden">Last Name<span>*</span></label>
                        <input type="text" name="last" id="last" class="get-value" placeholder="*Last Name" maxlength="40" pattern="[A-Za-z\s]{1,50}" title="Only letters are allowed." aria-required="true" tabindex="2" />

                        <label for="Company Name" class="visually-hidden">Company Name<span>*</span></label>
                        <input type="text" name="organization" id="organization" class="get-value" placeholder="*Company Name" maxlength="100" pattern="[a-zA-Z0-9\-\.\s]+" title="No special characters allowed." aria-required="true" tabindex="4" />

                        <label for="Country" class="visually-hidden">Country<span>*</span></label>
                        <input type="text" name="country" id="country" class="get-value" placeholder="*Country" maxlength="80" pattern="[A-Za-z\s]{1,50}" title="Only letters are allowed." aria-required="true" tabindex="6" />

                    </fieldset>

                    <fieldset>
                      
                    <label for="Questions / Requests" class="visually-hidden">Questions / Requests</label>
                   <textarea name="questions" id="questions" placeholder="*Questions / Requests" rows="1" cols="1" minlength="10" maxlength="799" aria-required="true" class="get-value" tabindex="8"></textarea>

                    <!--<div class="g-recaptcha" data-sitekey="<?php echo $webhelper->invCaptchaPublic; ?>" data-size="invisible" data-callback="formSubmit"></div>-->

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

<footer id="page-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
</body>
</html>