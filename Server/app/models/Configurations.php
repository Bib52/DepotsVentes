<?php
/*
*	Classe Configurations : représente la table configurations de la base de données
*/
use Illuminate\Database\Eloquent\Model as Eloquent;

class Configurations extends Eloquent{
  	protected $table = 'configurations';
	protected $key = 'id';
 	public $timestamps = false;

}

?>
