<?php
/*
*	Classe Staff : représente la table staff de la base de données
*/
use Illuminate\Database\Eloquent\Model as Eloquent;

class Staff extends Eloquent{
  	protected $table = 'staff';
	protected $key = 'id';
 	public $timestamps = false;

 	/*
    *   function addStaff : permet d'ajouter un membre du staff
    *   @param $donnees : données à enregistrer
    *   @return $staff : staff enregistré  
    */
 	public static function addStaff($donnees){
		$staff = new Staff();
		$staff->nom = $donnees['nom'];
		$staff->login = $donnees['login'];
		$staff->password = password_hash($donnees['password'], PASSWORD_DEFAULT);
		$staff->permission = $donnees['permission'];
		if($staff->save()){
			return $staff;
		}
		else{
			return false;
		}
	}

	/*
    *   function connexion : permet de se connecter
    *   @param $donnees : données de connexion (login, password)
    *   @return $staff : membre du staff à connecter  
    */
   	public static function connexion($donnees){
		$staff = Staff::where("login","=",$donnees['login'])->first();
		$hash = $staff->password;
		if (password_verify($donnees['password'], $hash)) {
			return $staff;
		} else {
			return false;
		}
   	}
}

?>
