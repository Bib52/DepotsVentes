<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Ventes extends Eloquent{
  	protected $table = 'ventes';
	protected $key = 'id';
 	public $timestamp = false;

}

?>
