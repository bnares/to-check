<?php 

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;
use \App\Controllers\DisplayChars;

class Login extends \Core\Controller {
	
	public function newAction(){
		
		View::renderTemplate('Login\new.html');
		
	}
	
	
	
	public function createAction(){
		
		$user = User::authenticate($_POST['email'], $_POST['password']);
		
		$remember_me = isset($_POST['remember_me']);
		
		if($user){
			
			$_SESSION['email'] = $_POST['email'];
			Auth::login($user, $remember_me);
			if(isset($_SESSION['return_to'])){
				$this->redirect(Auth::getReturnPage());
			}
			
			//$balance = DisplayChars::pieChar($_SESSION['user_id']);
			
			Flash::addMessage('Login sucessful');
			$this->redirect('BudgetMVC/public/?menu-glowne/mainWindow');
			
			
		}else{
				Flash::addMessage('Wrong email or Password. Try again', Flash::WARNING); //komunikat ktory bedzie wyswietlany bo bledzie i typ komunikatu. od typu komunikatu zalezy kolor wiadomosci wyswietlanej
				View::renderTemplate('Login/new.html', [
				'email'=>$_POST['email'],
				'remember_me'=>$remember_me
				]);                //zmienna prezentowana w twigu jesli logowanie nie wyjdzie 
				
			}
	}
	
	
	public function destroyAction(){
		
		
		Auth::logout();
		$this->redirect('BudgetMVC/public/?login/show-logout-message');
		
		
	}
	
	public function showLogoutMessage(){
		
		Flash::addMessage('Loging out succesfully');
		$this->redirect('BudgetMVC/public/');
	}
	
	
}