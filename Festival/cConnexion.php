<?php


	include '_debut.inc.php';

	$myPDO = new PDO ('mysql:host=;dbname=abuteau_festival;charset=utf8', 'root', 'joliverie');
	$answer = $myPDO -> prepare ('SELECT * FROM Utilisateurs WHERE Nom = :nom');
	$answer -> execute (array (':nom' => $_POST ['nom']));
    $result = $answer -> fetch ();

	if ($result ['MotDePasse'] == ($_POST ['motDePasse'])) {

		$_SESSION ['nom'] = $result ['Nom'];
		$_SESSION ['organisation'] = $result ['Organisation'];
		$_SESSION ['privilèges'] = $result ['Privilège'];

		echo "<br /><br /><div class = 'alert alert-success'>La connexion a réussie !</div>";

		header ('refresh:3; index.php');

	} else {

		echo "<br /><br /><div class = 'alert alert-danger'>La connexion a échouée !</div>";

		header ('refresh:3; connexion.php');

	}

?>