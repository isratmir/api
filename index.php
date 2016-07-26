<?php 
       header('Content-Type: application/json');
	require __DIR__ . '/vendor/autoload.php';

	use Illuminate\Database\Capsule\Manager as Capsule;
/*
error_reporting(E_ALL);
ini_set("display_errors", 1);
*/
	$capsule = new Capsule();
	$capsule->addConnection([
	    'driver'    => 'mysql',
	    'host'      => 'localhost',
	    'database'  => 'api',
	    'username'  => 'root',
	    'password'  => '12345',
	    'charset'   => 'utf8',
	    'collation' => 'utf8_unicode_ci',
	    'prefix'    => '',
	]);
	$capsule->setAsGlobal();
	$capsule->bootEloquent();

	$q='';
	$req = explode('/', trim($_SERVER['REQUEST_URI']));
	$method = $_SERVER['REQUEST_METHOD'];

	if($req[1] === 'date'){
		$date = new DateTime('NOW');
		$q = $date->format('Y-m-d h:i:s');
	}
	elseif($req[1]==='expenses'){
		if($method==='PUT'){
			$insert = Capsule::table('expenses')->insert(
				['title'=>$req[2],'price'=>$req[3]]
			);
			$q = $insert;
		}
		elseif($method==='GET'){
			$q = Capsule::table('expenses')->get();
		}
	}

	$res = array('status'=>'success', 'result'=>$q);

	echo json_encode($res);
