<?php
use Illuminate\Database\Capsule\Manager as DB;

class Configuration{
	public static function config(){
		$db = new DB();
		$db->addConnection(array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'depotsventes',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => ''
		));
		$db->setAsGlobal();
		$db->bootEloquent();
	}
}

?>
