<?php

namespace App\Controllers;
use \App\Models\AddExpense;
use \Core\View;
use \App\Flash;

class Expense extends \Core\Controller{
	
	
	public function newAction(){
		
		$data = static::displayExpensesAction();
		//var_dump($data[0]);
		$payment = static::displayPaymentMethods();
		View::renderTemplate('DodajWydatek/wydatek.html', ["expensesCategories"=>$data, "paymentMethods"=>$payment]);
	}
	
	public static function addDefaultExpensesCategory($id){
		
		
		$expenses = array('Transport', 'Books', 'Food', 'Flat', 'Telecommunications', 'Health', 'Clothing', 'Children', 'Recreation', 'Holiday', 'Children', 'Retirement', 'Other');
		
		$payment = array('Cash', 'Credit Card');
		
		AddExpense::AddDefaultPaymentMethod($id, $payment);
		AddExpense::AddDefaultCategories($id, $expenses);
		
	}
	
	
	
	
	public static function displayExpensesAction(){
		
		if(static::requireLogin()){
		//var_dump("Expense controller displayExpense method<br>: ");
		 //var_dump(AddExpense::getAllAsignedExpenses($_SESSION['user_id']));	
		 
			return AddExpense::getAllAsignedExpenses($_SESSION['user_id']);
		}else{
			
			Flash::addMessage("Can't acces that Page", Flash::WARNING);
			View::renderTemplate('Home\index.html');
			exit;
		}
		
	}
	
	public static function displayPaymentMethods(){
		
		if(!isset(($_SESSION['user_id']))){
			
			Flash::addMessage("Can't acces that Page", Flash::WARNING);
			View::renderTemplate('Home\index.html');
			exit;
		}
		
		return AddExpense::getAllAsignedPaymentMethods($_SESSION['user_id']);
	}
	
	public function processExpenseFormDataAction(){
		
		//var_dump($_POST['payment']);
		if(!isset($_POST['expense']) || !isset($_POST['payment'])){
			
			$expensesCategories = static::displayExpensesAction();
			$paymentMethods = static::displayPaymentMethods();
			
			Flash::addMessage('Select Expense category or payment method.');
			View::renderTemplate('DodajWydatek\wydatek.html', ['expensesCategories'=>$expensesCategories, 'paymentMethods'=>$paymentMethods]);
			exit;
			
		}else{
			//var_dump($_POST);
			$id = $_SESSION['user_id'];
			$categoryName = $_POST['expense'];
			$amount = $_POST['kwota'];
			$date_of_expense = $_POST['data'];
			$paymentMethod = $_POST['payment'];
			$expense_comment = $_POST['kom'];
			
			
			if(AddExpense::insertExpenseIntoDataBaseAction($id,$categoryName, $amount, $date_of_expense, $expense_comment, $paymentMethod)){
				
				Flash::addMessage('Expens has been sucessfully added');
				View::renderTemplate('MenuGlowne\mainWindow.html');
				exit;
			}
		
		}
		
	}
	
	
	
}