<?php
if(isset($_POST['submit'])) {
    function errored($error) {
        echo "Sorry, the following error was found with the form you just submitted:"."\n".$error;
        die();
    }
    function success(){
        echo "Thank you. I will contact you shortly. Promise..."
        die();
    }
    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }

    $email_to = getenv('EMAIL')    
    if(!isset($email_to)){
        errored("Host email not found. Please contact site administration or try again later.")
    }
    
    $email_subject = "Curricuum Vitae Contact Request";

    // validation expected data exists
    if(!isset($_POST['name']){
        errored("Please insert your full name.")
    }elseif(!isset($_POST['company'])){
        errored("Please insert your company name.")
    }elseif(!isset($_POST['email'])){
        errored("Please inser an email subject.")
    }elseif(!isset($_POST['email'])){
        errored("Please insert your email.")
    }elseif(!isset($_POST['message'])){
        errored("Please insert your message.")
    }
         
    $name = $_POST['name']; // required
    $company = $_PORT['company'] //required
    $subject = $_PORT['subject'] //required
    $email_from = $_POST['email']; // required
    $message = $_POST['message']; // required
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    $string_exp = "/^[A-Za-z .'-]+$/";
    if(!preg_match($string_exp,$name)) {
      errored('The name you entered does not appear to be valid.');
    }elseif(!preg_match($string_exp,$company)) {
      errored('The company name you entered does not appear to be valid.');
    }elseif(!preg_match($string_exp,$subject)){
      errored('The email subject you entered does not appear to be valid.')   
    }elseif(!preg_match($email_exp,$email_from)) {
      errored('The email you entered does not appear to be valid.');
    }elseif(strlen($message) < 10) {
      errored('The message you entered do not appear to be complete.');
    } 
 
    $email_message = "Form details below:\n\n";  
    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Company: ".clean_string($company)."\n";
    $email_message .= "Subject: ".clean_string($subject)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Message: ".clean_string($message)."\n";
 
    // create email headers
    $headers = 'From: '.$email_from."\r\n".'Reply-To: '.$email_from."\r\n".'X-Mailer: PHP/'.phpversion();
    
    @mail($email_to, $email_subject, $email_message, $headers);  
    header("Location:".$_SERVER."index.html")
    success()
?>
 