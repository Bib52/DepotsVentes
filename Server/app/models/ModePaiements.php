<?php
/*
*   Classe ModePaiements : représente la table modepaiements de la base de données
*/
use Illuminate\Database\Eloquent\Model as Eloquent;

class ModePaiements extends Eloquent{
    protected $table = 'modepaiements';
  	protected $key = 'id';
   	public $timestamps = false;

    /*
    *   function addModePaiement : permet d'ajouter un mode de paiement et de l'enregistrer
    *   @param $donnees : données à enregistrer
    *   @return $modePaiement : mode de paiement enregistré  
    */
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

    /*
    *   function updateModePaiement : permet de modifier un mode de paiement
    *   @param $id : id du mode de paiement à modifier
    *   @param $donnees : données à modifier et à enregistrer
    *   @return modePaiement : mode de paiement enregistré
    */
    public static function updateModePaiement($id, $donnees){
        $modePaiement = ModePaiements::find($id);
        $modePaiement->nom = $donnees['nom'];       
        $modePaiement->etat = $donnees['etat'];          
        if($modePaiement->save()){
            return $modePaiement;
        }
        else{
            return false;
        }
    }

}

?>
