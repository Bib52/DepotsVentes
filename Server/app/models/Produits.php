<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Produits extends Eloquent{
  	protected $table = 'produits';
	protected $key = 'reference';
 	protected $timestamp = true;

}

?>
