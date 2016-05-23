<?php

	include "_debut.inc.php";

	$myPDO = new PDO ("mysql:host=;dbname=abuteau_festival;charset=utf8", "root", "");
	$answer = $myPDO -> prepare ("INSERT INTO `offre`(`idEtab`, `idTypeChambre`, `nombreChambres`) VALUES (:IDEtablissement, :IDTypeChambre, :nombreChambre)");
	$answer -> execute (array (":IDEtablissement" => $_POST ["IDEtablissement"], ":IDTypeChambre" => $_POST ["IDTypeChambre"], ":nombreChambre" => $_POST ["nombreChambre"]));
    $result = $answer -> fetch ();

	echo "L'ajout a réussi' !";
	header ("refresh:3; index.php");

?>