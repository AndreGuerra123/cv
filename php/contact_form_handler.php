<?php
if(isset($_POST['email'])) {

    $email_to = getenv('EMAIL')
    $email_subject = "Curricuum Vitae Contact Request";

    function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }

    if(!isset($email_to)){
        //Just a safety check
        echo "Fatal error. Host email not found. Please try later..."
        die()   
    }
 
    // validation expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['company']) ||
        !isset($_POST['email']) ||
        !isset($_POST['message'])) {
        died('I am sorry, but there appears to be a problem with the form you submitted. Please, fill the form completely.');       
    }
 
    $name = $_POST['name']; // required
    $company = $_PORT['company']
    $email_from = $_POST['email']; // required
    $message = $_POST['message']; // required
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The email you entered does not appear to be valid.<br />';
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$name)) {
    $error_message .= 'The name you entered does not appear to be valid.<br />';
  }

  if(!preg_match($string_exp,$company)) {
        $error_message .= 'The name you entered does not appear to be valid.<br />';
      }
 
  if(strlen($message) < 10) {
    $error_message .= 'The message you entered do not appear to be complete.<br />';
  }
 
  if(strlen($error_message) > 0) {
    died($error_message);
  }
 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Company: ".clean_string($company)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Message: ".clean_string($message)."\n";
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!-- include your own success html here -->
 
Thank you for contacting me. I will be in touch with you very soon. A.C.G.
 
<?php
 
}
?>