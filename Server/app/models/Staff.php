<?php
use Illuminate\Database\Eloquent\Model as Eloquent;

class Staff extends Eloquent{
  	protected $table = 'staff';
	protected $key = 'id';
 	public $timestamps = false;

}

?>
