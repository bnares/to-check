<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\GetFilterData;

class Filter extends \Core\Controller{
	
	public function newAction(){
		//var_dump($this->displayFilteredIncome());
		//$filteredData = $this->displayFilteredIncome();
		View::renderTemplate('Filtr\filtr.html');
	}
	
	
	public function defaultIncomeFilter($id, $date_first, $date_second){
		
		return GetFilterData::getAllIncomeUser($id, $date_first, $date_second);
		
	}
	
	public function defaultExpenseFilter($id, $date_first, $date_second){
		
		return GetFilterData::getAllExpenseUser($id, $date_first, $date_second);
	}
	
	public function displayFilteredIncome(){
		
		//var_dump($_POST['firstDate']);
		//var_dump($_POST);
		
			$filteredDataIncome =$this->defaultIncomeFilter($_SESSION['user_id'], $_POST['firstDate'], $_POST['secondDate']);
			$filteredDataExpense = $this-> defaultExpenseFilter($_SESSION['user_id'], $_POST['firstDate'], $_POST['secondDate']);
			
			//var_dump($filteredData);
			View::renderTemplate('Filtr\result.html', ['filteredDataIncome'=>$filteredDataIncome, 'filteredDataExpense'=>$filteredDataExpense]);
			
		}
	
}




//$filteredData = $this->displayFilteredIncome();
		//View::renderTemplate('Filtr\result.html', ['filteredData'=>$filteredData]);