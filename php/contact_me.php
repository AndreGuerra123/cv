<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$subject = 'New Curriculum Vitae Message;'
$fields = array('firstname' => 'First Name', 'lastname' => 'Last Name', 'email' => 'Email', 'subject' => 'Subject', 'message' => 'Message');
$okMessage = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

error_reporting(0);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty.');
            
    $emailTextHtml = "<h1>You have a new message from your contact form</h1><hr>";
    $emailTextHtml .= "<table>";

    foreach ($_POST as $key => $value) {
    // If the field exists in the $fields array, include it in the email
       if (isset($fields[$key])) {
           $emailTextHtml .= "<tr><th>$fields[$key]</th><td>$value</td></tr>";
       }
    }

    $emailTextHtml .= "</table><hr>";

    // All the neccessary headers for the email.
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Host = gethostbyname(gentenv('SMTP_HOST'));
    $mail->Port = getenv('SMTP_PORT')
    $mail->Username = getenv('SMTP_USERNAME')
    $mail->Password = getenv('SMTP_PASSWORD');
    $mail->setFrom(getenv('SMTP_EMAIL'),"Curriculum Vitae Mailer");
    $mail->addAddress(getenv('EMAIL'));
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->msgHTML($emailTextHtml); 
    $mail->Debugoutput = 'html';
    $mail->send();
    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage.);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}

else {
    echo $responseArray['message'];
}

?>