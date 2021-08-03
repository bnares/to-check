<?php

namespace App\Models;

use PDO;

class Chars extends \Core\Model{

	public static function getSumIncome($user_id){
		
		$db = static::getDB();
		$sql = "SELECT SUM(amount) AS 'SUMA' FROM incomes WHERE user_id = :user_id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		
	}
	
	
	public static function getSumExpense($user_id){
		
		$db = static::getDB();
		$sql = "SELECT SUM(amount) AS 'SUMA' FROM expenses WHERE user_id=:user_id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO:: PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public static function getNumberOfIncomeCategoryAsigned($user_id){
		
		$db = static::getDB();
		$sql = "SELECT COUNT(user_id) AS 'SUMA' FROM incomes_category_asigned_to_user WHERE user_id=:user_id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue('user_id', $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}
	
	
	public static function getNumberOfExpenseCategoryAsigned($user_id){
		
		$db = static::getDB();
		$sql = "SELECT COUNT(user_id) AS 'SUMA' FROM expenses_category_asigned_to_users WHERE user_id=:user_id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
	}
	
	public static function getNumberOfPaymentMethodAsigned($user_id){
		
		$db = static::getDB();
		$sql = "SELECT COUNT(user_id) AS 'SUMA' FROM payment_methods_asigned_to_users WHERE user_id=:user_id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		
	}
	
	public static function topUsedExpenseID($user_id){
		
		$db = static::getDB();
		$sql = "SELECT expense_category_asigned_to_user_id AS 'CATEGORY_ID', COUNT(*) AS 'WYSTAPIENIA' FROM expenses WHERE user_id = :user_id GROUP BY expense_category_asigned_to_user_id ORDER BY COUNT(*) DESC LIMIT 3";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	public static function topUsedNameCategories($user_id){
		
		$names = [];
		$idNumbers = static::topUsedExpenseID($user_id);
		//var_dump($idNumbers);
		foreach( $idNumbers as $num){
		
			$db = static::getDB();
			$sql = "SELECT name FROM expenses_category_asigned_to_users WHERE id = :id";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':id', $num['CATEGORY_ID'], PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch();
			$number = $num['WYSTAPIENIA'];
			$names[] = ['nazwa'=>$result['name'], 'liczba'=>$number];
			
			}
			//var_dump('--------------------------------');
			//var_dump($names);
		return $names;
		
	}
	
	
	public static function topUsedIncomeID($user_id){
		
		$db = static::getDB();
		$sql = "SELECT income_category_asigned_to_user_id AS 'CATEGORY_ID', COUNT(*) AS 'WYSTAPIENIA' FROM incomes WHERE user_id = :user_id GROUP BY income_category_asigned_to_user_id ORDER BY COUNT(*) DESC LIMIT 3";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
	
	public static function topUsedNameCategoriesIncome($user_id){
		
		$names = [];
		$idNumbers = static::topUsedIncomeID($user_id);
		//var_dump($idNumbers);
		foreach( $idNumbers as $num){
		
			$db = static::getDB();
			$sql = "SELECT name FROM incomes_category_asigned_to_user WHERE id = :id";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':id', $num['CATEGORY_ID'], PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch();
			$number = $num['WYSTAPIENIA'];
			$names[] = ['nazwa'=>$result['name'], 'liczba'=>$number];
			
			}
			//var_dump('--------------------------------');
			//var_dump($names);
		return $names;
		
	}
	

}	