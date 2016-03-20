<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Produits extends Eloquent{
  	protected $table = 'produits';
	protected $key = 'reference';
 	public $timestamps = false;

 	public function depots(){
 		return $this->belongsTo('Depots', 'id_depot', 'id');
 	}

 	public function vente(){
 		return $this->belongsTo('Ventes', 'id_vente', 'id');
 	}

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

    public static function addToVente($id, $idVente){
    	$produit = Produits::where('reference', '=', $id)
        ->update(['etat' => 'En cours de vente',
        	'id_vente' => $idVente]);
    	if($produit){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
}

?>
