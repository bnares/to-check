<?php

namespace App\Models;
use PDO;


class NewCategories extends \Core\Model{
	
	
	public static function getAllIncomeCategories($id){
		
		$db = static::getDB();
		$sql = "SELECT name FROM incomes_category_asigned_to_user WHERE user_id = :user_id";
		$stmt = $db->prepare($sql);
		$stmt ->bindValue(':user_id', $id, PDO::PARAM_INT);
		if($stmt->execute())
		{
			
			return $stmt->fetchAll();
		}else{
			
			return false;
		}
		
		
		
	}
	
	
	
	public static function getAllExpenseCategories($id){
		
		$db = static::getDB();
		$sql = "SELECT name FROM expenses_category_asigned_to_users WHERE user_id = :user_id";
		$stmt = $db->prepare($sql);
		$stmt ->bindValue(':user_id', $id, PDO::PARAM_INT);
		if($stmt->execute())
		{
			
			return $stmt->fetchAll();
		}else{
			
			return false;
		}
		
		
		
	}
	
	
	public static function getAllPaymentCategories($id){
		
		$db = static::getDB();
		$sql = "SELECT name FROM payment_methods_asigned_to_users WHERE user_id = :user_id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
		if($stmt->execute()){
		return $stmt->fetchAll();
		}else{
			return false;
		}
	}
	
	
	public static function addNewIncomeCategory($category, $asigned_id){
		
		$db = static::getDB();
		$sql = "INSERT INTO incomes_category_asigned_to_user VALUES (null, :asigned_id, :name)";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(":asigned_id", $asigned_id, PDO::PARAM_INT);
		$stmt->bindValue(":name", $category, PDO::PARAM_STR);
		return $stmt->execute();
	}
	
	
	public static function addNewExpenseCategory($category, $asigned_id){
		
		$db = static::getDB();
		$sql = "INSERT INTO expenses_category_asigned_to_users VALUES (null, :asigned_id, :name)";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(":asigned_id", $asigned_id, PDO::PARAM_INT);
		$stmt->bindValue(":name", $category, PDO::PARAM_STR);
		return $stmt->execute();
	}
	
	public static function addNewPaymentCategory($category, $asigned_id){
		
		$db = static::getDB();
		$sql = "INSERT INTO payment_methods_asigned_to_users VALUES (null, :asigned_id, :name)";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(":asigned_id", $asigned_id, PDO::PARAM_INT);
		$stmt->bindValue(":name", $category, PDO::PARAM_STR);
		return $stmt->execute();
		
	}
	
	
}