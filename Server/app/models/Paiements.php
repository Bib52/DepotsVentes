<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Paiements extends Eloquent{
    protected $table = 'paiements';
  	protected $key = 'id';
   	public $timestamps = false;

   	public static function addPaiement($donnees){
   		$paiement = new Paiements();
   		$paiement->prix = $donnees['prix'];
   		if($paiement->save()){
   			return true;
   		}
   		else{
   			return false;
   		}
   	}

}

?>
