<?php

namespace App\Controllers;
use \Core\View;
use \App\Flash;
use \App\Models\User;
use \App\SendMail;
use \App\Auth;
use \App\Mail;
use \App\Controllers\ChangePassword;
//require ('/App/SendMail.php');

//require("C:\\xampp\htdocs\BudgetMVC\PHPMailer\src\PHPMailer.php");
//require("C:\\xampp\htdocs\BudgetMVC\PHPMailer\src\SMTP.php");
//require("C:\\xampp\htdocs\BudgetMVC\PHPMailer\src\Exception.php");

//require(__DIR__ .'/../../'.'PHPMailer\src\PHPMailer.php');

class ForgetPassword extends \Core\Controller{
	
	
	public function newAction(){
		
		View::renderTemplate('ForgetPassword\new.html');
		
	}
	
	public function newPasswordAction(){
		
		$this->email = $_POST['email'];
		
		$email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		
			
			if(User::emailExist($email)){
				
				//phpinfo();

				
				$_SESSION['email'] = $_POST['email'];
				$eamil = $_SESSION['email'];
				
				$to = $_SESSION['email'];
				$subject = "My Budget - reset password";
				$message = "Hello, click on the link below to reset the password<br>"."<a href = ".$_SERVER['HTTP_HOST']."/BudgetMVC/public/?change-password/new> click on me to reset the password</a>";
				$other = [];
				
				$mail = Mail::send($to, $subject, $message, $other);
					
				
			}else{
				
				Flash::addMessage('email does not exist. Try again', Flash::INFO);
				View::renderTemplate('ForgetPassword/new.html', [
				'email'=>$email
				]);
			}
		
		}else{
			
				Flash::addMessage('Wrong email. Try again', Flash::WARNING);
				View::renderTemplate('ForgetPassword/new.html', [
				'email'=>$email
				]);
		}
	}
	
	
	
	
}