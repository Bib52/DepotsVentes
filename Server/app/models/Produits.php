<?php
/*
*     Classe Produits : représente la table produits de la base de données
*/
use Illuminate\Database\Eloquent\Model as Eloquent;

class Produits extends Eloquent{
  	protected $table = 'produits';
	protected $key = 'reference';
 	public $timestamps = false;

    /*
    *   function depots : représente la relation (belongsto) de produits avec depots
    */
 	public function depots(){
 		return $this->belongsTo('Depots', 'id_depot', 'id');
 	}

    /*
    *   function vente : représente la relation (belongsto) de produits avec vente
    */
 	public function vente(){
 		return $this->belongsTo('Ventes', 'id_vente', 'id');
 	}

    /*
    *   function addProduit : permet d'ajouter un produit à un dépôts et de l'enregistrer dans la basee de données
    *   @param $donnees : données à enregistrer
    *   @param $depot : id du dépôt concerné
    *   @return true si c'est enregistré sinon false  
    */
 	public static function addProduit($donnees, $depot)
    {
        $produit = new Produits();
        $produit->reference = $donnees['reference'];
        $produit->prix = $donnees['prix'];
        $produit->description = $donnees['description'];
        $produit->etat = 'En stock';
        $produit->id_depot = $depot;
        if($produit->save()){
        	return true;
        }
        else{
        	return false;
        }
    }

    /*
    *   function updateProduit : permet de modifier un produit
    *   @param $id : reference du produit
    *   @param $donnees : données à enregistrer
    *   @return true si c'est modifié sinon false
    */
    public static function updateProduit($id, $donnees){
    	$produit = Produits::where('reference', '=', $id)
			        ->update(['prix' => $donnees['prix'], 
			        	'description' => $donnees['description'], 
			        	'etat' => $donnees['etat']]);
    	if($produit){
        	return true;
        }
        else{
        	return false;
        }
    }

    /*
    *   function addToVente : permet d'ajouter un produit à une vente (modification de son etat)
    *   @param $id : reference du produit
    *   @param $idVente : id de la vente
    *   @return true si c'est ajouté à la vente sinon false  
    */
    public static function addToVente($id, $idVente){
    	$produit = Produits::where('reference', '=', $id)
                            ->where('etat','=','En stock')->first();
    	if($produit){
            Produits::where('reference', '=', $id)
                    ->update(['etat' => 'En cours de vente',
                            'id_vente' => $idVente]);
    		return true;
    	}
    	else{
    		return false;
    	}
    }
}

?>
