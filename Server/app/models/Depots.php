<?php
/*
*   Classe Depots : représente la table depots de la base de données
*/
use Illuminate\Database\Eloquent\Model as Eloquent;

class Depots extends Eloquent{
  	protected $table = 'depots';
	protected $key = 'id';
 	public $timestamps = false;

    /*
    *   function produit : représente la relation (hasmany) de depots avec produits
    */
    public function produit(){
        return $this->hasMany('Produits', 'id', 'id_type');
    }

    /*
    *   function addDepot : permet de créer un dépôts et de l'enregistrer dans la basee de données
    *   @param $donnees : données à enregistrer
    *   @return id : id du dépôt créer  
    */
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
