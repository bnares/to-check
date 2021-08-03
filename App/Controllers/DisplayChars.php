<?php


namespace App\Controllers;

use \App\Models\Chars;


class DisplayChars extends \Core\Controller {
	
	
	public static function pieChar($user_id)
	{
		
		$sumIncome = Chars::getSumIncome($user_id);
		$sumExpense = Chars::getSumExpense($user_id);
		
		if($sumExpense['SUMA'] ===NULL){
			$sumExpense['SUMA']=1;
		}
		if($sumIncome['SUMA']===NULL){
			$sumIncome['SUMA'] = 1;
		}
		//echo "<script>alert($sumExpense[SUMA])</script>";
		return ['income'=>$sumIncome['SUMA'], 'expense'=>$sumExpense['SUMA']];
		
	}
	
	public static function NumberOfCategoriesAsigned($user_id){
		
		$income = Chars::getNumberOfIncomeCategoryAsigned($user_id);
		$expense = Chars::getNumberOfExpenseCategoryAsigned($user_id);
		$payment = Chars::getNumberOfPaymentMethodAsigned($user_id);
		
		return ['income'=>$income['SUMA']+1, 'expense'=>$expense['SUMA']+1, 'payment'=>$payment['SUMA']+1];
	}
	
	
	public static function topUsedExpenseName($user_id){
		
		return Chars::topUsedNameCategories($user_id);
	}
	
	public static function topUsedIncomeName($user_id){
		
		return Chars::topUsedNameCategoriesIncome($user_id);
	}
	
}