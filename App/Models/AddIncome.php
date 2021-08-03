<?php


namespace App\Models;

use \App\Models\User;
use PDO;

class AddIncome extends \Core\Model {
	
	public static function addDefaultCategories($id ,$categories = []){
		
		try{
			$count = 0;
			foreach ($categories as $option){
			$sql = "INSERT INTO incomes_category_asigned_to_user (id, user_id, name) VALUES(NULL, :user_id, :name)";
			
			$db = static::getDB();
			
			$stmt = $db->prepare($sql);
			
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':name', $option, PDO::PARAM_STR);
			if($stmt->execute()==false){
				return false;
			}
			//$user = User::findByID($id);
			
			}
			return true;
		}catch (Exception $e){
			
			$error= "Your error ".$e;
			var_dump($error);
		}
		
	}
	
	
	public static function getAllAsignedIncomes($id){
		
		try{
			
			
			
		//$twig->addGlobal('user_id', $_SESSION['user_id']);
		//$twig->addGlobal('asignedIncomes', \App\Controllers\Income::displayIncomes('user_id'));
	
			
			
		$db = static::getDB();
		$sql = "SELECT name From incomes_category_asigned_to_user WHERE user_id = :id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		//$stmt->setFetchMode(PDO::FETCH_COLUMN);
		$stmt->execute();
		
		
		return $stmt->fetchAll();
		
		}catch (Exception $e){
			
			$error = "Your error ".$e;
			var_dump($error);
		}
		
	}
	
	
	public static function getIncomeCategoryIdAsisgnedToUser($name, $id){
		
		$sql = "SELECT id FROM incomes_category_asigned_to_user WHERE name = :name AND user_id = :user_id";
		$db = static::getDB();
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		
	}
	
	
	public static function insertIncomeIntoDataBase($id,$categoryOption, $cash, $date, $comment){
		
		try{
			$incomes_category_asigned_to_user_id = static::getIncomeCategoryIdAsisgnedToUser($categoryOption, $id);
			
			$db = static::getDB();
			$sql = "INSERT INTO incomes (id, user_id, income_category_asigned_to_user_id, amount, date_of_income, income_comment) VALUES (null, :user_id, :income_category_asigned_to_user_id, :amount, :date_of_income, :income_comment)";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':user_id', $id, PDO::PARAM_INT);
			$stmt->bindValue(':income_category_asigned_to_user_id',$incomes_category_asigned_to_user_id[0], PDO::PARAM_INT);  // [0] to jest bo funkcja zwraca liste a ci wystrczy tylko pierwszy element bo roszta sie powtarza
			$stmt->bindValue(':amount',strval($cash), PDO::PARAM_STR);
			$stmt->bindValue(':date_of_income', $date, PDO::PARAM_STR);
			$stmt->bindValue(':income_comment', $comment, PDO::PARAM_STR);
			
			return $stmt->execute();
			
			
		}catch (Exception $e){
			
			var_dump("Your error ".$e);
			
		}
		
	}
	
}