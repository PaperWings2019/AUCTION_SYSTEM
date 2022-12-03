<?php include_once("utilities.php");
 

// Extract arguments from the POST variables:
 $mail_adress = $_POST['arguments'][0];
 

if(!filter_var($mail_adress, FILTER_VALIDATE_EMAIL)){
	$res = "Mailerror";
}else{
    try{
        $code = rand(1000,9999);
        $recipient = $mail_adress;
		$subject = "Your verification code";
		$content = "<h1>Your verification code is $code! </h1></br>";
		sendmail($recipient, $subject, $content);
        $res = $code;
    }catch(Exception $e){
        $res = "Senderror";
    }      
}            
 echo $res;
 
 ?>