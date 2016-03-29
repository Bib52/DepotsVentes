<?php
/*
*   Classe Ventes : représente la table ventes de la base de données
*/
use Illuminate\Database\Eloquent\Model as Eloquent;

class Ventes extends Eloquent{
  	protected $table = 'ventes';
	protected $key = 'id';
	public $timestamps = false;

    /*
    *   function produit : représente la relation (hasmany) de ventes avec produits
    */
	public function produit(){
		return $this->hasMany('Produits', 'id', 'id_vente');
	}

    /*
    *   function createVente : permet de créer une vente de l'enregistrer dans la basee de données
    *   @return id : id de la vente créé  
    */
	public static function createVente()
    {
        $vente = new Ventes();
        $vente->etat = "En cours";
        $vente->date = date("Y-m-d");
        $vente->save();
        return $vente->id;
    }

    /*
    *   function addCoordonnees : permet d'ajouter les coordonnées de l'acheteur à la vente
    *   @param $id : id de la vente concernée
    *   @param $donnees : données à enregistrer
    *   @return true si c'est enregistré sinon false  
    */
    public static function addCoordonnees($id, $donnees){
    	$vente = Ventes::where('id', '=', $id)
        ->update(['nom' => $donnees['nom'], 
        	'prenom' => $donnees['prenom'], 
        	'adresse' => $donnees['adresse'],
        	'ville' => $donnees['ville'],
        	'email' => $donnees['email'],
        	'telephone' => $donnees['telephone']]);
    	if($vente){
        	return true;
        }
        else{
        	return false;
        }
    }
}

?>
