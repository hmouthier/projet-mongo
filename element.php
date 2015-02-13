<?php

header('Content-Type: application/json');


$m = new MongoClient(); // connexion
$db = $m->selectDB("db_educ");
$collection=$db->val;
$cursor = $collection->find({"numero_uai":$argv[1]});




		echo json_encode($cursor);
?>