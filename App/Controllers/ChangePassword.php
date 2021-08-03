<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\ResetPassword;

class ChangePassword extends \Core\Controller {
	
	
	
	public function newAction(){
		
		
		View::renderTemplate('ResetPassword/new.html');
	}
	
	
	public function requireEmail(){
		
		if(!isset($_SESSION['email'])){
			View::renderTemplate('Login/new.html', ['error'=>"Can't acces this page"]);
			
			exit;
		}
		
	}
	
	protected function before(){
		
		$this->requireEmail();   //sprawdzam czy uzytkownik moze wejsc na stone glowne zalogowanego uzytkownika np mainWindow.html. robie to w metodzie before ktora wykonuje sie przed wywolaniem kazdej metody z klasy ktorej uzycie jest przeznaczone tylko dla zalogowanych uzytkownikow
		
	}
	
	protected function after(){    //funkcja stworzona pod prezentacje formularza zmieniajacego haslo po jego wyswietleniu nastepuje usuniecie  zmiennej email aby nie mozna bylo ponownie do tej strony wejsc
		
		/*
		if(isset($_SESSION['email'])){
			
			Auth::logout();
		}
		*/
	}
	
	public function resetPassword(){
		
		//var_dump($_POST);
		
		$this->validateDataFromForm();
		
	}
	
	public static function validateDataFromForm() {
		
		$errors = 0;
		if(strlen($_POST['password'])<6){
			$errors++;
			Flash::addMessage('Password must be at least 6 letters long.',Flash::INFO);
			View::renderTemplate('/ResetPassword/new.html');
			exit;
			
		}
		
		if(preg_match('/[a-z]+/i', $_POST['password'])==0){
			$errors++;
			Flash::addMessage('Password must haveast one letter.',Flash::INFO);
			View::renderTemplate('/ResetPassword/new.html');
			exit;
		}
		
		
		if(preg_match('/[0-9]+/', $_POST['password'])==0){
			
				$errors++;
				Flash::addMessage('Password must contain of at least 1 number', Flash::INFO);
				View::renderTemplate('ResetPassword/new.html');
				exit;
			
		}
		
		if($_POST['password'] != $_POST['passwordConfirm']){
				
				$errors++;
				Flash::addMessage('Passwords are difrent. try again', Flash::INFO);
				View::renderTemplate('ResetPassword/new.html');
				exit;
		}
		
		if($errors==0){
			
			
			
			if(ResetPassword::changePassword($_SESSION['email'], $_POST['password']))
			{
				
				Flash::addMessage('Password has been changed', Flash::SUCCESS);
				View::renderTemplate('Login/new.html');
				if(isset($_SESSION['email'])){
			
					Auth::logout();
				}
				exit;
				
			}else{
				
				
				Flash::addMessage('something went wrong. Password cant be changed', Flash::WARNING);
				View::renderTemplate('Login/new.html');
				exit;
				
			}
		}
		
		
	}
	
	
}