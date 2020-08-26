<?php
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

require "../vendor/autoload.php";

if( !$_POST || !isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
  echo "Invalid form input";
  die();
}

// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// helper funcitons
function sanitize(string $data): string {
  // <script>alert(adminPassword)</script>
  // " -> &quot;
  return htmlentities(strip_tags($data));
}


$mail  = new PHPMailer(true);

// capture user's POST data

$name = sanitize($_POST['name']);
$email = sanitize($_POST['email']);
$subject = sanitize($_POST['subject']);
$message = sanitize($_POST['message']);

try {
  $mail->isSMTP();
  $mail->Host       = '';                    // Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
  $mail->Username   = '';                     // SMTP username
  $mail->Password   = '';                               // SMTP password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
  $mail->Port       = 2525;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

  //Recipients
  $mail->setFrom($email, $name);
  $mail->addAddress('Your email', 'Your name');     // Add a recipient

  $mail->Subject = $subject ? $subject : "New contact form entry";
  $mail->Body    = $message;
  

  $mail->send();
  echo 'Message has been sent';
} catch(Exception $e) {
  die($mail->ErrorInfo);
}