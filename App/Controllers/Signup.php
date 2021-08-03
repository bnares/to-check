<?php

namespace App\Controllers;

use \Core\View;

use \App\Models\User;
use \App\Controllers\Income;
use \App\Controllers\Expense;



class Signup extends \Core\Controller {
	
	public function newAction(){
		
		View::renderTemplate('Signup\new.html');
		//var_dump($_SERVER['HTTP_HOST']);
		
	}
	
	public function createAction(){
		//var_dump($_POST);
		$user = new User($_POST);
		$user->validate();
		
		if(empty($user->errors))
		{
		
			$user->save();
			
			$id = User::getUserID($_POST['email']);
			Income::addDefaultIncomeCategory($id);
			Expense::addDefaultExpensesCategory($id);
			//$user->success = "New user Has been Added";
			
			//header('Location: http://'.$_SERVER['HTTP_HOST'].'/BudgetMVC/public/?login/new');
			
			$this->redirect('BudgetMVC/public/?login/new');
		
		}else{
			//var_dump($user->errors);
			View::renderTemplate('Signup\new.html', ['user'=>$user]);
			$user->errors = [];
		}
		
	}
	
}