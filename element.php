<?php
header('Content-Type: application/json');

$m = new MongoClient(); // connexion
$db = $m->db_educ;
$collection=$db->val;
$cursor = $collection->find(array('numero_uai' => (string)$_GET["numero"]));


$dbloc = $m->db_educ;
$collectionloc=$dbloc->local;


$cursorloc = $collectionloc->find(array('numero_uai' => (string)$_GET["numero"]),array("appellation_officielle_uai"));





$arrX=array();


foreach ($cursorloc as $variable ) {
        $arrX[0]=$variable;
 		
}
foreach ($cursor as $variable ) {
        $arrX[1]=$variable;
 		}


		echo json_encode($arrX);
?>