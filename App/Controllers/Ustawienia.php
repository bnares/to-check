<?php


namespace App\Controllers;
use \Core\View;
use \App\Models\ResetPassword;
use \App\Flash;



class Ustawienia extends \Core\Controller{
	
	public function newAction(){
		
		View::renderTemplate('Ustawienia\ustawienia.html');
	}
	
	
	public function changePasswordFormAction(){
		
		view::renderTemplate('Ustawienia\zmienHaslo.html');
	}
	
	public function precessFormData(){
		//var_dump($_POST['oldPass']);
		try{
			
			if(ResetPassword::findPassword($_POST['oldPass'])){
				
				if(static::validateDataFromForm()){
					ResetPassword::changePassword($_SESSION['email'], $_POST['newPass']);
					Flash::addMessage("Password has been changed");
					View::renderTemplate('Ustawienia\ustawienia.html');
				}
			}
			else{
				
				Flash::addMessage("Wrong Old Password try again", Flash::INFO);
				View::renderTemplate('Ustawienia\zmienHaslo.html');
			}
			
		}catch(Exception $e){
			
			$mess = "Your error ".$e;
			var_dump($mess);
		}
	}
	
	
	
	
	public static function validateDataFromForm() {
		
		$errors = 0;
		if(strlen($_POST['newPass'])<6){
			$errors++;
			Flash::addMessage('Password must be at least 6 letters long.',Flash::INFO);
			View::renderTemplate('/Ustawienia/zmienHaslo.html');
			exit;
			
		}
		
		if(preg_match('/[a-z]+/i', $_POST['newPass'])==0){
			$errors++;
			Flash::addMessage('Password must haveast one letter.',Flash::INFO);
			View::renderTemplate('/Ustawienia/zmienHaslo.html');
			exit;
		}
		
		
		if(preg_match('/[0-9]+/', $_POST['newPass'])==0){
			
				$errors++;
				Flash::addMessage('Password must contain of at least 1 number', Flash::INFO);
				View::renderTemplate('/Ustawienia/zmienHaslo.html');
				exit;
			
		}
		
		if($_POST['newPass'] != $_POST['confirmPass']){
				
				$errors++;
				Flash::addMessage('Passwords are difrent. try again', Flash::INFO);
				View::renderTemplate('/Ustawienia/zmienHaslo.html');
				exit;
		}
		
		if($errors==0){
			
			return true;
			
		}
		return false;
		
		
	}
	
	
	
}