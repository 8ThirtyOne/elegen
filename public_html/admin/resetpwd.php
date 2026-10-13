<?php
include_once('../../lcmodel/loadPage.inc.php');
use lcmodel\processDB\dbHelper;
use lcmodel\webTools\webHelper;
$dbhelper = new dbHelper('user');
$webhelper = new WebHelper();
include_once('../../lcmodel/configMail.php'); 
require ZENDDIR.'vendor/autoload.php';
use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Mime;
use Laminas\Mime\Part as MimePart;
$PageUrl = "/admin/";
$PageCode = "000000";

if(isset($_GET['c']) && !empty($_GET['c'])){
  $token = $webhelper->RequestFilter('c', 255, false);
  if($token == ''){
     header('Location: /admin/');
     exit;
  }
  $PageUrl = "/admin/resetpwd";
  $PageCode = "000000";
  $update = false;
  $delete = false;
  $error = array();
  $missing = array();

  $id = $dbhelper->selectOne('SELECT user_id FROM admin_confirm WHERE token = ? AND expired > NOW()','s', $token);
  if($id == 0 || $id ==''){
    header('Location: /admin/');
    exit;
  }else{
    $sql = "SELECT email, firstname, lastname FROM admin WHERE pkid = ".$id;
    $member = $dbhelper->RunSQLReturnOneRow($sql);
  }

  if(array_key_exists('reset', $_POST)){ 
    if(!empty($_POST['new_pass'])){
       $new = $webhelper->RequestFilter('new_pass', 30, false);
       if(!$webhelper->validPwd($new)){
          $error[] = "Password does not meet requirements";
       }
      }

     if(!empty($_POST['confirm_new'])){
       $confirm = $webhelper->RequestFilter('confirm_new', 30, false);
       if($new != $confirm){
         $error[] = "Your passwords do not match";
       }
      }
     if($missing){
        $error[] = "Both fields are required";
     }
   if(empty($missing) && !$error){
      $salt = time();
      $newpwd = sha1($new.$salt);
      $update = $dbhelper->updateAll("UPDATE admin SET pass = '$newpwd', salt = '$salt' WHERE pkid = '$id'");
      if($update){
         $delete = $dbhelper->deleteOne("DELETE FROM admin_confirm WHERE user_id = ?", 'i', $id);
         if(!$delete){
            header('Location: /admin/index?error=del');
         }
       unset($missing);
       $fullname = $member['firstname'].' '.$member['lastname'];
       $content = "
          <!DOCTYPE html>
          <html lang='en'>
            <head>
              <title>ADMIN PORTAL RESET SUCCESSFUL | ELEGEN</title>
              <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
              <meta name='viewport' content='width=device-width, initial-scale=1'>
              <meta http-equiv='X-UA-Compatible' content='IE=edge' />
              <style type='text/css'>
                  /* CLIENT-SPECIFIC STYLES */
                  body, table, td, a {-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}
                  table, td{mso-table-lspace:0pt;mso-table-rspace:0pt;}
                  img{-ms-interpolation-mode:bicubic;}

                  /* RESET STYLES */
                  img{border:0;height:auto;line-height:100%;outline:none;text-decoration:none;}
                  table{border-collapse:collapse !important;}
                  body{height:100% !important;margin:0 !important;padding:0 !important;width:100% !important;}
              </style>
            </head>
            <body style='background-color:#eeeeee;margin:0 !important;padding:60px 0 60px 0 !important;'>
              <table border='0' cellspacing='0' cellpadding='0' role='presentation' width='100%'>
                <tr>
                    <td bgcolor='#eeeeee'></td>
                    <td class='content' bgcolor='white' width='600' style='border-radius:4px;color:#7d868c;font-family:sans-serif;font-size:17px;line-height:28px;padding:20px 30px;'>
                      <article>
                        <p style='text-align: center;'>
                        <img src='https://www.elegenbio.com/img/common/logo-elegen-main-500.png' width='300' height='67' style='height:auto;max-width:300px;width:30%;min-width:200px;text-align:center;'>
                        </p>
                        <h1 style='margin-top:30px;color:black;font-size:18px;font-weight:bold;line-height:20px;'>Hi $fullname,</h1>
                        <p style='margin:10px 0 10px 0;'>You have recently changed password for your ELEGEN Admin Account. You can now login to Admin Portal using your new password.</p>
                        <p style='margin:10px 0 30px 0;'>
                          If you did not reset your password, please contact Administrator/Developer immediately.
                        </p>
                        <p style='margin:20px 0 0 0;'>Kind Regards,</p>
                        <p style='margin:0;font-weight:bold; color:rgba(0,0,0,1.00);'>Elegen Team</p>
                        <p style='margin:20px 0 2px 0;font-size:13px;line-height:15px;'>
                        Please do not reply directly to this e-mail as it has been sent from a notification-only email address that cannot accept incoming email. We exclude any responsibility and liability for emails being sent notwithstanding.
                        </p>
                      </article>
                    </td>
                    <td bgcolor='#eeeeee'></td>
                </tr>
                <tr>
                <td bgcolor='#eeeeee'></td>
                <td bgcolor='#33393e' width='600' style='margin:20px 0;border-bottom-left-radius:4px;border-bottom-right-radius:4px;color:#bababa;font-family:sans-serif;font-size:12px;line-height:15px; padding:10px 30px;'>
                <p>
                 This message is intended only for the recipient. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.
                </p>
                </td>
                <td bgcolor='#eeeeee'></td>
                </tr>
                <tr>
                <td bgcolor='#eeeeee'></td>
                <td bgcolor='#eeeeee' width='600' height='50'>
                <td bgcolor='#eeeeee'></td>
                </tr>
              </table>
            </body>
          </html>";

          $textContent = "Please do not reply directly to this email. Thank you for your interest with Elegen. Kind Regards, Elegen Team. This message is intended only for the use of the named recipient(s) and may contain confidential, personal and/or privileged information. If you are not the intended recipient, please delete this message. Any unauthorized use of the information contained in this message is prohibited.";

            $text = new MimePart($textContent);
            $text->type = Mime::TYPE_TEXT;
            $text->charset = 'utf-8';
            $text->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
            $html = new MimePart($content);
            $html->type = Mime::TYPE_HTML;
            $html->charset = 'utf-8';
            $html->encoding = Mime::ENCODING_QUOTEDPRINTABLE;
            $body = new MimeMessage();
            $body->setParts([$text, $html]);
            $message = new Message();
            $message->setBody($body);
            $contentTypeHeader = $message->getHeaders()->get('Content-Type');
            $contentTypeHeader->setType('multipart/alternative');
            $message->setSender(REPLYEMAIL, 'Elegen NoReply');
            $message->addReplyTo(REPLYEMAIL, 'Elegen NoReply');
            $message->addTo($member['email'], $fullname);
            $message->setSubject('Elegen Admin Password Changed');
            $transport = new SmtpTransport();
            $options   = new SmtpOptions([
                'name'              => SERVER,
                'host'              => SERVER,
                'port'              => 587,
                'connection_class'  => 'login',
                'connection_config' => [
                    'username' => EUSER,
                    'password' => EPASS,
                    'ssl'      => 'tls',
                ],
            ]);
            $transport->setOptions($options);
            $transport->send($message);
            header('Location: /admin/');
            exit;
      }else{
        $error[] = "We are having some technical difficulties. Please try again.";
      }
    }
  }
}else{
 header('Location: /');
 exit();
}

$FirstPageCode = substr($PageCode, 0, 2);
$SecodeCode = substr($PageCode, 2, 2);
$ThirdCode = substr($PageCode, 4, 2);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<title>ADMIN PORTAL RESET | ELEGEN</title>
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


                <h2>Admin Reset Password</h2>
            </div>

            <form method="post" name="resetFrm">

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
                        <label for="Password">New Password<span>*</span></label>
                        <input type="password" name="new_pass" id="new-pass" placeholder="Password" maxlength="30" tabindex="1" />
                        <p>Must be at least 8 characters and contain at least one letter and one number.</p>
                    </fieldset>

                    <fieldset>
                        <label for="Password">Confirm New Password<span>*</span></label>
                        <input type="password" name="confirm_new" placeholder="Confirm New Password" maxlength="30" tabindex="2" />
                    </fieldset>

                    <fieldset id="login-submit">
                        <input type="submit" name="reset" value="RESET" class="btn lime-btn smooth-hover" />
                    </fieldset>

                </form>

               </div>
 
            </div>

        </div>
 
      </section>
           
</main>
 
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>
</body>
</html>