<!DOCTYPE HTML>

<html lang = "FR">

	<head>

		<title>Test Connexion</title>
		<meta charset = "UTF-8">

	</head>

	<body>

		<?php

			require_once ("../modele/dao/Connexion.class.php");
			use modele\dao\Connexion;

			$connexion = Connexion:: seConnecter ();
			echo var_dump ($connexion);

		?>

	</body>

</html>