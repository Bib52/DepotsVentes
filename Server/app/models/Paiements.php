<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Paiements extends Eloquent{
    protected $table = 'paiements';
  	protected $key = 'id';
   	public $timestamp = false;

}

?>
