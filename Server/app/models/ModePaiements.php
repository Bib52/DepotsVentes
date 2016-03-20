<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class ModePaiements extends Eloquent{
    protected $table = 'modepaiements';
  	protected $key = 'id';
   	public $timestamps = false;

   	public static function addModePaiement($donnees){
   		$modePaiement = new ModePaiements();
   		$modePaiement->nom = $donnees['nom'];
   		if($modePaiement->save()){
   			return $modePaiement;
   		}
   		else{
   			return false;
   		}
   	}

}

?>
