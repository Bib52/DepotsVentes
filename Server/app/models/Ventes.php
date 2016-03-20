<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Ventes extends Eloquent{
  	protected $table = 'ventes';
	protected $key = 'id';
	public $timestamps = false;

	public function produit(){
		return $this->hasMany('Produits', 'id', 'id_vente');
	}

	public static function createVente()
    {
        $vente = new Ventes();
        $vente->etat = "En cours";
        $vente->save();
        return $vente->id;
    }

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
