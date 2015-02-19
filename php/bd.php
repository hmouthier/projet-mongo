<?php


$m = new MongoClient(); // connexion
$db = $m->selectDB("db_educ");
$collection=$db->sortie;
$cursor = $collection->find();


$arrX=array();

$i=0;
foreach ($cursor as $variable ) {
        $arrX[$i]=$variable;
 		$i=$i+1;
}

header('Content-Type: application/json');
		echo json_encode($arrX);
?>