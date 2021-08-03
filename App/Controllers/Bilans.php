<?php

namespace App\Controllers;
use \Core\View;
use \App\Models\BalanceData;

class Bilans extends \Core\Controller{
	
	public function newAction(){
		
		$sumIncome = $this->displaySumUserIncome();
		$sumExpense = $this->displaySumUserExpense();
		$dividedIncome = $this->displaySortedIncome();
		$dividedExpense = $this->displaySortedExpense();
		
		View::renderTemplate('Bilans/bilans.html', ['sumIncome'=>$sumIncome, 'sumExpense'=>$sumExpense, 'dividedIncome'=>$dividedIncome, 'dividedExpense'=>$dividedExpense]);
		
		
	}
	
	public function displaySumUserIncome(){
		
		$sumIncome = BalanceData::getUserIncome($_SESSION['user_id']);
		return $sumIncome[0][0];
	}
	
	public static function displaySumUserExpense(){
		
		$sumExpense = BalanceData::getUserExpense($_SESSION['user_id']);
		return $sumExpense[0][0];
	}
	
	public static function displaySortedIncome(){
		
		$sumIncome = BalanceData::getSortedCategoryIncome($_SESSION['user_id']);
		return $sumIncome;
	}
	
	public static function displaySortedExpense(){
		$sumExpense = BalanceData::getSortedCategoryExpense($_SESSION['user_id']);
		return $sumExpense;
	}
	
}