<?php

	require __DIR__ . '/vendor/autoload.php';

	use Illuminate\Database\Capsule\Manager as Capsule;

	$capsule = new Capsule();
	$capsule->addConnection([
	    'driver'    => 'mysql',
	    'host'      => 'localhost',
	    'database'  => 'api',
	    'username'  => 'root',
	    'password'  => '',
	    'charset'   => 'utf8',
	    'collation' => 'utf8_unicode_ci',
	    'prefix'    => '',
	]);
	$capsule->setAsGlobal();
	$capsule->bootEloquent();

	$req = explode('/', trim($_SERVER['REQUEST_URI']));
	$method = $_SERVER['REQUEST_METHOD'];

	if($req[1] === 'date'){
		$date = new DateTime('NOW');
		$q = $date->format('Y-m-d h:i:s');

		$res = array('status'=>'success', 'result'=>$q);
		header('Content-Type: application/json');
		echo json_encode($res);
	}
	elseif($req[1]==='expenses'){
		if($method==='PUT'){
			$insert = Capsule::table('expenses')->insert(
				['title'=>$req[2],'price'=>$req[3]]
			);
			$q = $insert;

			$res = array('status'=>'success', 'result'=>$q);
			header('Content-Type: acpplication/json');
			echo json_encode($res);
		}
		elseif($method==='GET'){
			$q = Capsule::table('expenses')->get();

			$res = array('status'=>'success', 'result'=>$q);
			header('Content-Type: application/json');
			echo json_encode($res);
		}
		elseif ( $method === 'DELETE' ) {
			$q = Capsule::table('expenses')->where('id', '=', $req[2])->delete();

			$res = array('status'=>'success', 'result'=>$q);
			header('Content-Type: application/json');
			echo json_encode($res);
		}
	}
	elseif ( empty($req[1]) ){
?>
		<form action="" method="put">
			<input type="hidden" name="interface" value="true">
			<input type="text" name="title" id="" placeholder="Title">
			<input type="text" name="price" id="" placeholder="Price">
			<input type="submit" value="Save">
		</form>
<?php
	}

if(isset($_GET['interface']) && $_GET['interface'] === 'true'){
	$insert = Capsule::table('expenses')->insert(
			['title'=>$_GET['title'],'price'=>$_GET['price']]
	);
}