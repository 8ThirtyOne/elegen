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
$insert = false;

if(!empty($_POST['first']) && !empty($_POST['email']) && !empty($_POST['questions'])){
  $email = $webhelper->RequestFilter("email", 95, false);
  if(!$webhelper->validEmail($email)){
    echo "2";
  }else{
   $first = $webhelper->RequestFilter("first", 101, false);
   $last = $webhelper->RequestFilter("last", 101, false);
   $fullname = $first.' '.$last;
   $company = $webhelper->RequestFilter("organization", 120, false);
   $country = $webhelper->RequestFilter("country", 150, false);
   $zip = $webhelper->RequestFilter("zip", 20, false);
   $phone = $webhelper->RequestFilter("phone", 30, false);
   $inquiry = $webhelper->RequestFilter("questions", -1, true);
   $news = $webhelper->RequestFilter("newsletters", 0, false);
   $subscriber = isset($_POST['newsletters']) ? 1 : 0;
   if($subscriber == 1){
   $emailExists = $dbhelper->numOfRows('SELECT pkid FROM web_subscribers WHERE email = ?', 's', $email);
   $status = 1;
   if($emailExists == 0) $webSub = $dbhelper->webSubscriber($first, $last, $email, $status);
   }
  /*if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) $captcha = $_POST['g-recaptcha-response'];
      $response = file_get_contents(
          'https://www.google.com/recaptcha/api/siteverify?'.http_build_query([
              'secret'   => $webhelper->invCaptchaPrivate,
              'response' => $captcha,
              'remoteip' => $_SERVER['REMOTE_ADDR'],
          ])
      );
      $obj = json_decode($response);
      if($obj->success == true){*/
        $removeEmail = "(gmail|yahoo|outlook|hotmail)";
        $removeInq = "(Cleaners|cleaners|janitorial)";
        if(preg_match($removeEmail, $email) || preg_match($removeInq, $inquiry)){
         echo "4";
        }else{
          $insert = $dbhelper->visitorRequest($first, $last, $email, $company, $country, $zip, $phone, $inquiry, $news);
         if($insert){
            $content = "
            <!DOCTYPE html>
            <html lang='en'>
              <head>
                <title>Request Info | ELEGEN</title>
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
                          <img src='https://www.elegenbio.com/img/common/logo-elegen-main-500.png' width='200' height='124' style='height:124px;max-width:200px;width:200px;min-width:124px;text-align:center;'>
                          </p>
                          <h1 style='margin-top:30px;color:black;font-size:18px;font-weight:bold;line-height:20px;'>Dear $fullname,</h1>
                          <p style='margin:10px 0 30px 0;'>Thank you for your interest in Elegen. Our representative will get in touch soon.</p>
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
            $message->addTo($email, $fullname);
            $message->setSubject('Thank you for your interest in Elegen');
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
            //send email to Elegen
            $subject= "New Request from Website";
            $content =  "First Name: " . $first . "\n" .
                      "Last Name: " . $last . "\n" .
                      "Company: " . $company . "\n" .
                      "Country: " . $country . "\n" .
                      "Zip Code: " . $zip . "\n" .
                      "Phone: " . $phone . "\n" .
                      "Questions/Requests: " . $inquiry . "\n" .
                      "Email: " . $email . "\n" .
                      "I would like to receive the latest news and updates: " . $webhelper->MakeSelectedValue("1", $news, "YES") . "\n";
            $mail = new Message();
            $mail->setBody($content);
            $mail->addFrom(REPLYEMAIL, REPLYNAME);
            $mail->addTo(BAKIR, 'Elegen-NoReply');
            $mail->setSubject($subject);
            $transport->send($mail);
            $_SESSION['request'] = true;
            echo "1";
         }else{
          echo "0";
         }
        } //block generic emails
      /*}else{
        echo "3"; //recaptcha wrong
      }*/
   }// 2 email not valid
}else{
 echo "Nothing Here.";
}

