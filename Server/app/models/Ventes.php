<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Ventes extends Eloquent{
  	protected $table = 'ventes';
	protected $key = 'id';
	public $timestamps = false;

	public function produit(){
		return $this->hasMany('Produits', 'id', 'id_vente');
	}

	public static function addVente()
    {
        $vente = new Ventes();
        $vente->etat = "En cours";
        $vente->save();
        return $vente->id;
    }
}

?>
