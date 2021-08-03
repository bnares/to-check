<?php

namespace App\Models;
use PDO;

class BalanceData extends \Core\Model {
	
	
	public static function getUserIncome($user_id){
		
		$sql = "SELECT sum(amount) AS SUMA FROM incomes WHERE user_id = :user_id";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT );
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	
	public static function getUserExpense($user_id){
		
		$sql = "SELECT sum(amount) AS SUMA FROM expenses WHERE user_id = :user_id";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT );
		$stmt->execute();
		return $stmt->fetchAll();
		
	}
	
	public static function getSortedCategoryIncome($user_id){
		
		
		
		$sql = "SELECT incomes_category_asigned_to_user.name AS 'NAZWA', sum(incomes.amount) AS 'SUMA' FROM incomes_category_asigned_to_user INNER JOIN incomes ON incomes.income_category_asigned_to_user_id = incomes_category_asigned_to_user.id WHERE incomes.user_id = :user_id GROUP BY incomes_category_asigned_to_user.name";
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
		
	}
	
	
	public static function getSortedCategoryExpense($user_id){
		
		$sql = "SELECT expenses_category_asigned_to_users.name AS 'NAZWA', sum(expenses.amount) AS 'SUMA' FROM expenses_category_asigned_to_users INNER JOIN expenses ON expenses_category_asigned_to_users.id = expenses.expense_category_asigned_to_user_id WHERE expenses.user_id = :user_id GROUP BY expenses_category_asigned_to_users.name";
		
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
		
	}
	
}