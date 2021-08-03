<?php

namespace App\Models;
use PDO;


class AddExpense extends \Core\Model{
	
	public static function AddDefaultCategories($id, $categories = []){

			try{
				foreach($categories as $option){
					$db = static::getDB();
					$sql = "INSERT INTO expenses_category_asigned_to_users (id, user_id, name) VALUES (NULL, :user_id, :name)";
					
					$stmt = $db->prepare($sql);
					$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
					$stmt->bindValue(':name', $option, PDO::PARAM_STR);
					if($stmt->execute()==false)
					{
						
						return false;
					}
				
					
				}
				return true;

			}catch (Exception $e){
				$info = "Ypur error: ".$e;
				var_dump($info);
			}
	}
	
	
	
	public static function AddDefaultPaymentMethod($id, $categories= []){
		
		try{
			
			foreach($categories as $option){
				$sql = "INSERT INTO payment_methods_asigned_to_users (id, user_id, name) VALUES (NULL, :user_id, :name)";
				$db = static::getDB();
				$stmt = $db->prepare($sql);
				$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
				$stmt->bindValue(':name', $option, PDO::PARAM_STR);
				
				if($stmt->execute()==false){
					
					return false;
				}
				
			}
			return true;
			
		}catch (Exception $e){
				$info = "Ypur error: ".$e;
				var_dump($info);
			
		}
		
	}
	
	
	public static function getAllAsignedExpenses($id){
		
		try{
			
			$sql = "SELECT name FROM expenses_category_asigned_to_users WHERE user_id = :user_id";
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll();
			
		}catch (Exception $e){
			
			$info = "Your error: ".$e;
			var_dump($info);
		}
	}
	
	public static function getAllAsignedPaymentMethods($id){
		
		try{
			
			$db = static::getDB();
			$sql = "SELECT name FROM payment_methods_asigned_to_users WHERE user_id = :user_id";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->execute();
			return $stmt->fetchAll();
			
			
		}catch (Exception $e){
			
			$info = "Your error: ".$e;
			var_dump($info);
		}
		
	}
	
	
	public static function getExpensesCategoryAsignedToUsers($name, $id){
		
		$db = static::getDB();
		$sql = "SELECT id FROM expenses_category_asigned_to_users WHERE user_id = :user_id AND name = :name";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		if($stmt->execute()){
			return $stmt->fetchAll();
		}
		return false;
	}
	
	public static function getPaymentMethodsAsignedToUsers($id, $name){
		
		$db = static::getDB();
		$sql = "SELECT id FROM payment_methods_asigned_to_users WHERE user_id = :user_id AND name = :name";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		if($stmt->execute()){
			return $stmt->fetchAll();
		}
		return false;
	}
	
	public static function insertExpenseIntoDataBaseAction($id,$categoryName, $amount, $date_of_expense, $expense_comment,$paymentMethod){
		
		$expense_category_asigned_to_user_id = static::getExpensesCategoryAsignedToUsers($categoryName, $id);
		$payment_methods_asigned_to_user_id = static::getPaymentMethodsAsignedToUsers($id, $paymentMethod);
		
		
		
		$sql = "INSERT INTO expenses VALUES (null, :user_id, :expense_category_asigned_to_user_id, :payment_methods_asigned_to_user_id, :amount, :date_of_expense, :expense_comment)";
		
		$db= static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':expense_category_asigned_to_user_id',$expense_category_asigned_to_user_id[0][0], PDO::PARAM_INT);
		$stmt->bindValue(':payment_methods_asigned_to_user_id',$payment_methods_asigned_to_user_id[0][0], PDO::PARAM_INT);
		
		$stmt->bindValue(':amount', strval($amount), PDO::PARAM_STR);
		$stmt->bindValue(':date_of_expense', $date_of_expense, PDO::PARAM_STR);
		$stmt->bindValue(':expense_comment', $expense_comment, PDO::PARAM_STR);
		return $stmt->execute();
		
		
		
	}
	
	
	
}