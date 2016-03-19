<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Depots extends Eloquent{
  	protected $table = 'depots';
	protected $key = 'id';
 	public $timestamps = false;

    public function produit(){
        return $this->hasMany('Produits', 'id', 'id_type');
    }

 	public static function addDepot($donnees)
    {
        $depots = new Depots();
        $depots->nom = $donnees['nom'];
        $depots->prenom = $donnees['prenom'];
        $depots->adresse = $donnees['adresse'];
        $depots->email = $donnees['email'];
        $depots->telephone = $donnees['telephone'];
        $depots->save();
        return $depots->id;
    }
}

?>
