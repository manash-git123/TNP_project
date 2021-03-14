<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require 'phpmailer/phpmailer/src/Exception.php';
  require 'phpmailer/phpmailer/src/PHPMailer.php';
  require 'phpmailer/phpmailer/src/SMTP.php';

  $mail = new PHPMailer();
  $mail->IsSMTP();

  $mail->SMTPDebug  = 0;  
  $mail->SMTPAuth   = TRUE;
  $mail->SMTPSecure = "tls";
  $mail->Port       = 587;
  $mail->Host       = "smtp.gmail.com";
  $mail->Username   = "mikiborah123@gmail.com";
  $mail->Password   = "mynameismandit@123";

  $mail->IsHTML(true);
  $mail->AddAddress("manditjyotiborah@gmail.com", "recipient-name");
  $mail->SetFrom("mikiborah123@gmail.com", "NIT-TNP-CELL");
//   $mail->AddReplyTo("reply-to-email", "reply-to-name");
//   $mail->AddCC("cc-recipient-email", "cc-recipient-name");
  $mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
  $content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";

  $mail->MsgHTML($content); 
  if(!$mail->Send()) {
    echo "Error while sending Email.";
    var_dump($mail);
  } else {
    echo "Email sent successfully";
  }
?>