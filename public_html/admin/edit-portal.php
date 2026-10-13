<?php
include_once('../../lcmodel/loadRegister.inc.php');
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
if(isset($_SESSION['user']) && !empty($_SESSION['user']) && is_int($_SESSION['user'])){
  $pkid = $_SESSION['user'];
  if($pkid == 0){
    header('Location: /admin/');
    exit;
  }else{
   $username = $dbhelper->selectOne('SELECT id FROM admin WHERE pkid = ?', 'i', $pkid);
   if(!empty($username)){
     $PageUrl = "/admin/edit-portal";
     $PageCode = "000000";
     $bodyid = "manager";
     $FirstPageCode = substr($PageCode, 0, 2);
     $SecodeCode = substr($PageCode, 2, 2);
     $ThirdCode = substr($PageCode, 4, 2);
     $sql = "SELECT email, firstname, lastname FROM admin WHERE pkid = ".$pkid;
     $member = $dbhelper->RunSQLReturnOneRow($sql);
     $fullname = $member['firstname'].' '.$member['lastname'];
     if(array_key_exists('change', $_POST)){
         $missing = array();
         $error=array();
         $expected = array('oldPass', 'newPass', 'confirmNewPass');
         $required = array('oldPass', 'newPass', 'confirmNewPass');
         $cnt = 0;
         $input='';
         $data = array();
         $update = false;
         foreach($_POST as $key => $value){
           $temp = is_array($value) ? $value : trim($value);
           if($key != 'change'){
             if(empty($temp) && in_array($key, $required)){
              array_push($missing, $key);
             }
             elseif(in_array($key, $expected)){
              ${$key} = $temp;
             }
             if(!empty($value)){
               $input = $webhelper->RequestFilter($key, 30, false);
               if($key == 'oldPass'){ 
                 $oldSalt = $dbhelper->selectOne('SELECT salt FROM admin WHERE pkid = ?', 'i', $pkid);
                 $oldPass = sha1($input.$oldSalt);
                 $userId = $dbhelper->numOfRows('SELECT pkid FROM admin WHERE pass = ?', 's', $oldPass);
                 if($userId == 0){
                    $error[] = "Incorrect current password";
                 }
               }
               if($key == 'newPass'){
                 if(!$webhelper->validPwd($input)){
                    $error[] = "Password must be at least 8 characters, contain at least one letter and one number.";
                 }
               }
               if($key == 'confirmNewPass'){
                  if($input != $_POST['newPass']) $error[] = "New Passwords do not match.";
               }
             }
             else{
               $input = "";
             }
             $data[$cnt] = $input;
             $cnt++;
           }
          }

        if($missing) $error[] = "All fields are required";

        if(empty($missing) && !$error){
          if($data[1] == $data[2]){
             $salt = time();
             $newpwd = sha1($data[1].$salt);
             $update = $dbhelper->updateAll("UPDATE admin SET pass = '$newpwd', salt = '$salt' WHERE pkid = '$pkid'");
             if($update){
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
                header('Location: '.$_SESSION['return']);
                exit; 
             }else{
                $error[] = "Something went wrong. Try again.";
             }
           }
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
<title>Admin Portal User Account | ELEGEN</title>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-head-section.php'); ?> 
</head>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/header.php')?>
<main role="main">
  
    <section class="wide-section" id="admin-section">

     <div class="page-inner">

        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/left-sidebar.php')?>

         <div id="admin-panel">

            <h2>CHANGE YOUR PASSWORD</h2>

            <form method="post" name="registerFrm" id="enter-data">

            <?php
            if(isset($error)){
               echo '<ul id="upload-warning">';
               foreach($error as $item) {
                  echo "<li>$item</li>";
               }
               echo '</ul>';
            }
            if(!empty($_GET['success']) && $_GET['success'] == 'true' && isset($_SESSION['processPass'])){
               echo '<h4>Your password has been changed.</h4>';
               unset($_SESSION['processPass']);
            }
             ?>

             <fieldset id="field-one">
                <label for="Current Password">Current Password<span>*</span></label>
                <input type="password" name="oldPass" id="old-pass" placeholder="*Current Password" maxlength="20" tabindex="1" />
            </fieldset>

            <fieldset id="new-pass-field">
                <label for="New Password">New Password<span>*</span></label>
                <input type="password" name="newPass" id="new-pass" placeholder="*New Password" maxlength="20" tabindex="2" />
                <p>Must be at least 8 characters, contain at least one letter and one number</p>
            </fieldset>

            <fieldset id="confirm-pass-field">
                <label for="Confirm Password">Confirm New Password<span>*</span></label>
                <input type="password" name="confirmNewPass" id="confirm-pass" placeholder="*Confirm New Password" maxlength="20" tabindex="3" />
            </fieldset>

            <fieldset id="user-submit">
                <input type="submit" name="change" value="CHANGE PASSWORD" class="green-btn smooth-hover" id="submit-btn" tabindex="4" />
            </fieldset>

        </form>

    </div>

</section>

</main>

<footer id="admin-footer">
   <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/footer.php'); ?>
</footer>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/admin/includes/admin-scripts.php'); ?>

