<?php

namespace App\Controllers;
use \App\Models\AddIncome;
use \Core\View;
use \App\Flash;

class Income extends \Core\Controller {
	
	
	public static function addDefaultIncomeCategory($id){
		
		$category = array('Sallary', 'e-commerce', 'interest');
		AddIncome::addDefaultCategories($id, $category);
		
		
	}
	
	
	public static function displayIncomes($id){
		
		//var_dump(AddIncome::getAllAsignedIncomes($id));
		//var_dump("id do displayIncome: ".$id);
		return AddIncome::getAllAsignedIncomes($id);
	}
	
	
	public function newAction(){
		
		static::requireLogin();
		$data = static::displayIncomes($_SESSION['user_id']);
		View::renderTemplate('DodajPrzychod/przychod.html', ['info'=>$data]);
	}
	
	public function processIncomeFormData(){
		
		//var_dump($_POST);
		if(!isset($_POST['incomeOption'])){
			
			$info = static::displayIncomes($_SESSION['user_id']);
			Flash::addMessage("Select income category");
			View::renderTemplate('DodajPrzychod/przychod.html', ['info'=>$info]);
			exit;
			
		}else{
			$categoryOption = $_POST['incomeOption'];
			$cash = $_POST['kwota'];
			$date = $_POST['data'];
			$comment = $_POST['kom'];
			
			//echo $categoryOption.' '.$cash.' '.$date.' '.$comment;
			if(AddIncome::insertIncomeIntoDataBase($_SESSION['user_id'],$categoryOption, $cash, $date, $comment)){
				
				Flash::addMessage("Income has been successfully added");
				View::renderTemplate('MenuGlowne/mainWindow.html');
				exit;
				
			}
		
		}
	}
	
}