<?php

namespace App;

use App\Config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use \App\Flash;
USE \Core\View;

// Load Composer's autoloader
//require 'vendor/sendgrid/vendor/autoload.php';


/**
 * 
 */
class Mail {
	
	public static function send($to, $subject, $message) {



		$mail = new PHPMailer();

		$mail->IsSMTP();
		$mail->CharSet="UTF-8";
		$mail->Host = ""; /* Zależne od hostingu poczty*/
		$mail->Port = 465 ; /* Zależne od hostingu poczty, czasem 587 */
		$mail->SMTPSecure = "ssl"; /* Jeżeli ma być aktywne szyfrowanie SSL */
		$mail->SMTPAuth = true;
		$mail->IsHTML(true);
		$mail->Username = "mybudget@piotrostrouch.pl"; /* login do skrzynki email często adres*/
		$mail->Password = ""; /* Hasło do poczty */
		$mail->setFrom('mybudget@piotrostrouch.pl', 'MyBudget'); /* adres e-mail i nazwa nadawcy */
		$mail->AddAddress($to); /* adres lub adresy odbiorców */
		
		$mail->Subject = $subject; /* Tytuł wiadomości */
		$mail->Body = $message;

		
		
		
		if(!$mail->Send()) {
				echo "Błąd wysyłania e-maila: " . $mail->ErrorInfo;
				} else {
					//echo "Wiadomość została wysłana!";
					Flash::addMessage('Message has been sent to your mailbox '.$_SESSION['email'], Flash::INFO);
					View::renderTemplate('Login\new.html');
					
					//header($_SERVER['HTTP_HOST'].'/BudgetMVC/public/?login/new');
					exit;
				
				}
		
		

		// $headers = 'From: kontakt@fiszki.it' . "\r\n" .
		// 	'Reply-To: kontakt@fiszki.it' . "\r\n" .
		// 	'X-Mailer: PHP/' . phpversion();

		// mail($to, $subject, $message, $headers);
	}
}
