<?php
	
	include '_debut.inc.php';

  if ($_SESSION ['nom'] != 'invité') {

	$nbEtab = obtenirNbEtab($connexion);
  	$nbTypesChambres = obtenirNbTypesChambres($connexion);

  	if ($nbEtab != 0 && $nbTypesChambres != 0) {

      	$rsEtab = obtenirIdNomEtablissements($connexion);
      
      	while ($lgEtab = $rsEtab->fetch(PDO::FETCH_ASSOC)) {

	        $idEtab = $lgEtab['id'];
	        $nom = $lgEtab['nom'];

          	echo "<center><strong>$nom</strong><br>
        <a href='cOffreHebergement.php?action=demanderModifierOffre&idEtab=$idEtab'>
        Modifier</a>
     
        <table width='45%' cellspacing='0' cellpadding='0' class='tabQuadrille'>";

          	echo "
           	<tr class='enTeteTabQuad'>
              	<td width='30%'>Type</td>
              	<td width='35%'>Capacité</td>
              	<td width='35%'>Nombre de chambres</td> 
           	</tr>";

          	$rsTypeChambre = obtenirTypesChambres($connexion);

          	while ($lgTypeChambre = $rsTypeChambre->fetch(PDO::FETCH_ASSOC)) {

              	$idTypeChambre = $lgTypeChambre['id'];
              	$libelle = $lgTypeChambre['libelle'];

              	echo "<tr class='ligneTabQuad'><td>$idTypeChambre</td><td>$libelle</td>";
              	$nbOffre = obtenirNbOffre($connexion, $idEtab, $idTypeChambre);
              	echo "<td>$nbOffre</td></tr>";
              
          	}

          	echo "</table><br>";

      	}

  	}

  	echo "

        <br>
        <a href='cOffreHebergement.php?action=demanderAjouterOffre'>
        Ajouter</a>

    ";

  } else if ($_SESSION ['nom'] == 'invité') {
        echo "<br /><br /><div class = 'alert alert-info' style = 'font-size: 14px !important;'>Vous n'avez pas les droits ! Veuillez vous connecter.</div>";
    }

  	include("_fin.inc.php");

?>