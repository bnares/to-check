<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\NewCategories;
use \App\Flash;



class NowaKategoria extends \Core\Controller {
	
	
	public function IncomeCategoryAction() {
		
		View::renderTemplate('NowaKategoria/newIncomeCategory.html');
	}
	
	public function ExpenseCategoryAction(){
		
		View::renderTemplate('NowaKategoria/newExpenseCategory.html');
	}
	
	public function PaymentCategoryAction(){
		
		View::renderTemplate('NowaKategoria/newPayment.html');
	}
	
	
	public function newIncomeValidation(){
		
		$category = $_POST['income'];
		if(strlen($category)>1){
			$allUsedCategories = NewCategories::getAllIncomeCategories($_SESSION['user_id']);
			
			foreach( $allUsedCategories as $cat){
				
				if(strtoupper($cat[0])==strtoupper($category)){
					Flash::addMessage("Category: $category has already been added before", Flash::INFO);
					View::renderTemplate('NowaKategoria/newIncomeCategory.html');
					exit;
				}
			}
			
			if(NewCategories::addNewIncomeCategory($category, $_SESSION['user_id'])){	
				
				Flash::addMessage("Category: $category has been added");
				View::renderTemplate('Ustawienia/ustawienia.html');
				exit;
				
			}else{
				Flash::addMessage("sth went wrong. Category- $category coudnt have been added", Flash::WARNING);
				View::renderTemplate('NowaKategoria/newIncomeCategory.html');
				exit;
			}
		
		}else{
			
			Flash::addMessage("Can't add empty category", Flash::INFO);
			View::renderTemplate('NowaKategoria/newIncomeCategory.html');
			exit;
		}
		
	}
	
	
	
	public function newExpenseValidation(){
		
		$category = $_POST['expense'];
		if(strlen($category)>1){
			$allUsedCategories = NewCategories::getAllExpenseCategories($_SESSION['user_id']);
			
			foreach( $allUsedCategories as $cat){
				
				if(strtoupper($cat[0])==strtoupper($category)){
					Flash::addMessage("Category: $category has already been added before", Flash::INFO);
					View::renderTemplate('NowaKategoria/newIncomeCategory.html');
					exit;
				}
			}
			
			if(NewCategories::addNewExpenseCategory($category, $_SESSION['user_id'])){	
				
				Flash::addMessage("Category: $category has been added");
				View::renderTemplate('Ustawienia/ustawienia.html');
				exit;
				
			}else{
				Flash::addMessage("sth went wrong. Category- $category coudnt have been added", Flash::WARNING);
				View::renderTemplate('NowaKategoria/newIncomeCategory.html');
				exit;
			}
		
		}else{
			
			Flash::addMessage("Can't add empty category", Flash::INFO);
			View::renderTemplate('NowaKategoria/newExpenseCategory.html');
			exit;
		}
		
	}
	
	
	public function newPaymentValidation(){
		
		$category = $_POST['payment'];
		if(strlen($category)>1){
			$allUsedCategories = NewCategories::getAllPaymentCategories($_SESSION['user_id']);
			
			foreach( $allUsedCategories as $cat){
				
				if(strtoupper($cat[0])==strtoupper($category)){
					Flash::addMessage("Category: $category has already been added before", Flash::INFO);
					View::renderTemplate('NowaKategoria/newPayment.html');
					exit;
				}
			}
			
			if(NewCategories::addNewPaymentCategory($category, $_SESSION['user_id'])){	
				
				Flash::addMessage("Category: $category has been added");
				View::renderTemplate('Ustawienia/ustawienia.html');
				exit;
				
			}else{
				Flash::addMessage("sth went wrong. Category- $category coudnt have been added", Flash::WARNING);
				View::renderTemplate('NowaKategoria/newPayment.html');
				exit;
			}
		
		}else{
			
			Flash::addMessage("Can't add empty category", Flash::INFO);
			View::renderTemplate('NowaKategoria/newPayment.html');
			exit;
		}
		
	}
	
	
	
	
	
	
}