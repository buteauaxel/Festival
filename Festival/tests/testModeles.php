<!DOCTYPE HTML>

<html>

	<head>

	<title>Test Modèles</title>
		<meta charset = "UTF-8">

	</head>

	<body>

		<?php

	    /*
	     *  Associe les fichiers en fonction de leur espaces de noms
	     */

			require_once "..\modele\metier\Etablissement.class.php";
			require_once "..\modele\metier\Groupe.class.php";
			require_once "..\modele\metier\Offre.class.php";
			require_once "..\modele\metier\TypeChambre.class.php";
			require_once "..\modele\metier\Attribution.class.php";

			use modele\metier\Etablissement;
			use modele\metier\Groupe;
			use modele\metier\Offre;
			use modele\metier\TypeChambre;
			use modele\metier\Attribution;

			use modele\dao\EtablissementDAO;
			use modele\dao\GroupeDAO;
			use modele\dao\OffreDAO;
			use modele\dao\TypeChambreDAO;
			use modele\dao\AttributionDAO;
			use modele\dao\DAO;
            use modele\dao\Connexion;

            // Etablissements

			$etablissement = new Etablissement ("0350773A", "Collège Ste Jeanne d'Arc-Choisy", "3, avenue de la Borderie BP 32", 35404, "Paramé", 0299560159, "NULL", 1, "Madame", "Lefort", "Anne");
			echo $etablissement . "<br />";

			// Groupes

			$groupe = new Groupe ("g001", "Groupe folklorique du Bachkortostan", "NULL", "NULL", 40, "Bachkirie", 0);
			echo $groupe . "<br />";

			// Offres

			$offre = new Offre ("0350773A", "C2", 15);
			echo $offre . "<br />";

			// TypesChambres

			$typeChambre = new TypeChambre ("C1", "1 lit");
			echo $typeChambre . "<br />";

			// Attributions

			$attribution = new Attribution ("0350773A", "C2", "g004", 2);
			echo $attribution . "<br />";

		?>

	</body>

</html>