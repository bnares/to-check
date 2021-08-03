<?php


namespace App\Models;
use PDO;
use \App\Models\User;



class ResetPassword extends \Core\Model {
	
	
	
	public static function changePassword($email, $password){
		
		$sql = 'UPDATE users SET password = :password_hash WHERE email = :email';
		$newPasswordHash = password_hash($password, PASSWORD_DEFAULT);
		$db = Static::getDB();
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':password_hash', $newPasswordHash, PDO::PARAM_STR);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		//$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		return $stmt->execute();
		
	}
	
	
	
	public static function authenticate($email, $password){
		$user = User::findByEmail($_SESSION['email']);
		if($user){
			
			if(password_verify($password, $user[0]->password)){
				return true;
				
			}
		}
		return false;
		
	}
	
	
	public static function findPassword($pass){
		
		
		
		if(static::authenticate($_SESSION['email'], $_POST['oldPass'])){
			return true;
			
		}else{
			
			return false;
			
			
		}
	}
	
	
}