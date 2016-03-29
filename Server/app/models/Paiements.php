<?php
/*
*   Classe Paiements : représente la table paiements de la base de données
*/
use Illuminate\Database\Eloquent\Model as Eloquent;

class Paiements extends Eloquent{
    protected $table = 'paiements';
  	protected $key = 'id';
   	public $timestamps = false;

    /*
    *   function addPaiement : permet d'ajouter un paiement à une vente
    *   @param $donnees : données à enregistrer
    *   @param $id : id de la vente
    *   @return id : id du paiement enregistré  
    */
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
