<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Paiements extends Eloquent{
    protected $table = 'paiements';
  	protected $key = 'id';
   	public $timestamps = false;

   	public static function addPaiement($donnees, $id){
   		$paiement = new Paiements();
   		$paiement->prix = $donnees['prix'];
      $paiement->mode_paiements = $donnees['mode_paiements'];
      $paiement->id_vente = $id;
   		if($paiement->save()){
   			return $paiement->id;
   		}
   		else{
   			return false;
   		}
   	}

}

?>
