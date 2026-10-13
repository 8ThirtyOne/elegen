<?php
include_once('../../../lcmodel/loadRegister.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
$PageUrl = "/admin/";
$PageCode = "000000";
$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
include_once('../../../lcmodel/configMail.php'); 
require ZENDDIR.'vendor/autoload.php';
use Laminas\Validator\EmailAddress;
$validator = new EmailAddress();
if(array_key_exists('login', $_POST)){
  $update = false;
  $expected = array('email', 'user');
  $required = array('email', 'user');
  $missing = array();
  $error=array();
  $cnt = 0;
  $input='';
  $isValid = false;
  $data = array();
  foreach($_POST as $key => $value){
   $temp = is_array($value) ? $value : trim($value);
   if($key != 'login' && $key != 'returnUrl'){
     if(empty($temp) && in_array($key, $required)){
      array_push($missing, $key);
     }
     elseif(in_array($key, $expected)){
      ${$key} = $temp;
     }
     if(!empty($value)){
         $input = trim($_POST[$key]);
         if($key == 'email'){ 
            if ($validator->isValid($input)) {
            $id = strpos($input, '@') ? 'email' : 'id';
            $userId = $dbhelper->selectOne('SELECT pkid FROM admin WHERE '.$id.' = ?', 's', $input);
            if($userId > 0){
              $member = $dbhelper->RunSQLReturnOneRow("SELECT id, pass, salt, isAdministrator, status 
                                                       FROM admin WHERE pkid = $userId");
            }
            else{
              $note = $id == 'email' ? 'Email' : 'Username';
              $error[] = "This ".$note." is not registered with Elegen.";
            }
           }else{
            $error[] = "Not good.";
           }
         }
     }
     else{
       $input = "";
     }
     $data[$cnt] = $input;
     $cnt++;
   }
  }

  if($missing) $error[] = "Both fields are required";

}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>ADMIN PORTAL | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<body id="admin-login">
<main role="main">
  
    <section class="wide-section" id="login-page">
 
        <div class="page-inner narrow-section">

            <div class="center-paragraph">

               <div id="login-form-wrap">

                 <div class="center-icon">
                   <svg version="1.1" id="elegen-logo-icon-green" xmlns:serif="http://www.serif.com/"
                       xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 574.8 576" style="enable-background:new 0 0 574.8 576;" xml:space="preserve">
                    <style type="text/css">
                      .zt0{fill:url(#vision-svg);}
                    </style>
                    <linearGradient id="vision-svg" gradientUnits="userSpaceOnUse" x1="-12.5738" y1="13.1433" x2="-11.5738" y2="13.1433" gradientTransform="matrix(-1.823066e-05 419.0167 -419.0167 -1.823066e-05 5794.5913 5375.3486)">
                      <stop  offset="0" style="stop-color:#27C9D0"/>
                      <stop  offset="0.42" style="stop-color:#4DCAA4"/>
                      <stop  offset="1" style="stop-color:#82C953"/>
                    </linearGradient>
                    <path class="zt0" d="M271.4,0.4v195.8c0,19.7,0.6,17.5-10.4,33.8c-28.2,42.9-28.2,35.1,26.4,35.1c49,0,51.1,3.6,39.3-14.9
                      c-19.2-30.1-23.4-28.5-23.4-54.1V0.4C298,0.2,292.7,0,287.4,0C282,0,276.7,0.2,271.4,0.4z M330.3,190.9c0,18.8-1,14.7,9.5,30.2
                      c27.6,40.8,15.3,49.3,74.3-39.5c23.1-34.7,46.2-69.9,68.9-105c-41.4-38.4-94.2-64.8-152.7-73.5L330.3,190.9L330.3,190.9z M91.7,76.7
                      c26.6,41,53.8,81.9,81,123.3c45.3,69,36.7,58.9,62.2,21.1c10.5-15.5,9.5-11.4,9.5-30.2V3.2C185.9,11.9,133.1,38.3,91.7,76.7
                      L91.7,76.7z M2.7,244.2h121.1c32.1,0,26.1,0.3,55,12.1L72.7,96.1C36.3,136.7,11.3,187.8,2.7,244.2z M395.9,256.3
                      c28.8-11.8,22.8-12.1,55-12.1H572c-8.6-56.4-33.6-107.5-70-148.1C466.6,149.5,431.3,202.8,395.9,256.3L395.9,256.3z M455.7,271.5
                      c-74.1,0.2-74.1,32.8,0,32.9l119.1,0.2v-33.4L455.7,271.5z M-0.1,304.6l119.1-0.2c74.1-0.2,74.1-32.8,0-32.9l-119.1-0.2
                      C-0.1,271.3-0.1,304.6-0.1,304.6z M261,345.8c11,16.3,10.4,14.1,10.4,33.8v195.8c10.8,0.6,21,0.6,31.9,0V379.6
                      c0-25.6,4.2-24,23.4-54.1c11.8-18.5,9.7-14.9-39.3-14.9c-14.5,0-25.2-0.6-32.5-0.6C234.8,310.1,240.3,314.3,261,345.8L261,345.8z
                       M502,479.8c36.4-40.7,61.4-91.7,70-148.1H450.9c-32.1,0-26.1-0.3-55-12.1C431.3,373.1,466.6,426.4,502,479.8z M123.9,331.7H2.7
                      c8.6,56.4,33.6,107.5,70,148.1l106.1-160.2C150,331.4,156,331.7,123.9,331.7L123.9,331.7z M362.5,325.2c-6.1,0-10.6,11.7-22.6,29.6
                      c-10.5,15.6-9.5,11.4-9.5,30.2v187.7c58.5-8.8,111.3-35.1,152.7-73.5c-22.7-35.1-45.8-70.2-68.9-105
                      C381,344.3,370.3,325.2,362.5,325.2L362.5,325.2L362.5,325.2z M212.2,325.2c-6.8,0-15.7,14.4-39.6,50.7
                      c-27.2,41.4-54.4,82.2-81,123.3c41.4,38.4,94.2,64.8,152.7,73.5V385c0-18.8,1-14.7-9.5-30.2C222.8,336.9,218.4,325.2,212.2,325.2
                      L212.2,325.2L212.2,325.2z"/>
                    </svg>


                    <svg version="1.1" id="elegen-logo-green" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 591 75" style="enable-background:new 0 0 591 75;" xml:space="preserve">
                    <style type="text/css">
                        .st0{fill:#231F20;}
                    </style>
                    <g>
                        <path class="st0" d="M13.32,15.09H53.3V2.07H0v13.02H13.32z M53.3,60.15H13.32V44.08h38.55V31.57H13.32H0v41.8h53.3V60.15z"/>
                        <polygon class="st0" points="104.35,2.07 104.35,73.37 154.39,73.37 154.39,60.96 117.78,60.96 117.78,2.07    "/>
                        <path class="st0" d="M217.65,15.09h39.97V2.07h-53.3v13.02H217.65z M257.62,60.15h-39.97V44.08h38.55V31.57h-38.55h-13.32v41.8
                            h53.3V60.15z"/>
                        <path class="st0" d="M369.91,11.02c-7.32-7.22-16.88-10.88-26.45-10.88c-25.12,0-37.63,18.51-37.63,38.55
                            c0,18.72,10.88,36.31,37.63,36.31c12.51,0,21.36-4.78,28.38-12.82V32.18h-30.51v12h18.21v12.61c-5.59,4.48-10.48,5.7-16.07,5.7
                            c-17.7,0-24.51-12.1-24.51-23.8c0-14.65,9.26-26.24,24.51-26.24c6.2,0,13.32,2.54,18.11,7.12L369.91,11.02z"/>
                        <path class="st0" d="M436.62,15.09h39.97V2.07h-53.3v13.02H436.62z M476.6,60.15h-39.97V44.08h38.55V31.57h-38.55H423.3v41.8h53.3
                            V60.15z"/>
                        <polygon class="st0" points="576.57,46.28 541.69,2.07 530.8,2.07 530.8,73.37 544.23,73.37 544.23,25.3 581.66,73.37 590,73.37 
                            590,2.07 576.57,2.07    "/>
                    </g>
                    </svg>


                <h2>Test</h2>
            </div>

            <form method="post" name="loginFrm">

                    <?php
                        if(isset($error)) {
                           echo '<ul id="error-box">';
                           foreach($error as $item) {
                              echo "<li>$item</li>";
                           }
                           echo '</ul>';
                        } 
                    ?>

                    <fieldset>
                        <label for="Email">Email Address<span>*</span></label>
                        <input type="text" name="email" placeholder="Email Address" maxlength="60" />
                    </fieldset>

                    <fieldset>
                        <label for="Email">Email Address<span>*</span></label>
                        <input type="text" name="user" placeholder="User" maxlength="60" />
                    </fieldset>

                    <fieldset id="login-submit">
                        <input type="submit" name="login" value="LOGIN" class="btn lime-btn smooth-hover" />
                    </fieldset>

                    <fieldset>
                      <a href="/admin/forgot-password" class="smooth-hover">Forgot your password?</a>
                    </fieldset>
                </form>

               </div>
 
            </div>

        </div>
 
      </section>
           
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer-scripts.php'); ?>
</body>
</html>
 