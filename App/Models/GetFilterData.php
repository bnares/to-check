<?php

namespace App\Models;
use PDO;

class GetFilterData extends \Core\Model{
	
	public static function getAllIncomeUser($id, $date_first, $date_second){
		
		
		$db = static::getDB();
		
		
		//$sql = "SELECT * FROM incomes WHERE user_id = :user_id AND date_of_income>:date_first AND date_of_income<:date_second ORDER BY date_of_income DESC";
		
		//$sql = "SELECT incomes_category_asigned_to_user.name AS 'NAZWA', sum(incomes.amount) AS 'SUMA' FROM incomes_category_asigned_to_user INNER JOIN incomes ON incomes.income_category_asigned_to_user_id = incomes_category_asigned_to_user.id WHERE incomes.user_id = :user_id GROUP BY incomes_category_asigned_to_user.name";
		
		$sql = "SELECT incomes_category_asigned_to_user.name AS 'NAZWA', sum(incomes.amount) AS 'SUMA' FROM incomes_category_asigned_to_user INNER JOIN incomes ON incomes.income_category_asigned_to_user_id = incomes_category_asigned_to_user.id WHERE incomes.user_id = :user_id AND incomes.date_of_income>=:date_first AND incomes.date_of_income<=:date_second GROUP BY incomes_category_asigned_to_user.name";
		
		
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':date_first', $date_first, PDO::PARAM_STR);
		$stmt->bindValue(':date_second', $date_second, PDO::PARAM_STR);
		if($stmt->execute()){
			//var_dump($stmt->fetchAll());
			return $stmt->fetchAll();
		}else{
			return false;
		}
	}
	
	
	public static function getAllExpenseUser($id, $date_first, $date_second){
		
		$db = static::getDB();
		$sql = "SELECT expenses_category_asigned_to_users.name AS 'NAZWA', sum(expenses.amount) AS 'SUMA' FROM expenses_category_asigned_to_users INNER JOIN expenses ON expenses.expense_category_asigned_to_user_id = expenses_category_asigned_to_users.id WHERE expenses.user_id = :user_id AND expenses.date_of_expense>=:date_first AND expenses.date_of_expense<=:date_second GROUP BY expenses_category_asigned_to_users.name";
		
		
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':date_first', $date_first, PDO::PARAM_STR);
		$stmt->bindValue(':date_second', $date_second, PDO::PARAM_STR);
		if($stmt->execute()){
			//var_dump($stmt->fetchAll());
			return $stmt->fetchAll();
		}else{
			return false;
		}
		
		
	}
}