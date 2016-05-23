<?php
	
	include '_debut.inc.php';

	echo "

		<form method='POST' action='cOffreHebergement.php'>
        <input type='hidden' value='validerModifierOffre' name='action'>

    ";

    $lgEtab = obtenirDetailEtablissement ($connexion, $idEtab);

    $i = 0;

    $nom = $lgEtab ['nom'];

    echo "

    	<br><strong>$nom</strong><br><br>
    	<table width='45%' cellspacing='0' cellpadding='0' class='tabQuadrille'>
    	<tr class='enTeteTabQuad'>
            <td width='30%'>Type</td>
            <td width='37%'>Capacité</td>
            <td width='33%'>Nombre de chambres</td> 
        </tr>

    ";

    $rsTypeChambre = obtenirTypesChambres ($connexion);

    while ($lgTypeChambre = $rsTypeChambre -> fetch (PDO:: FETCH_ASSOC)) {

        $idTypeChambre = $lgTypeChambre ['id'];
        $libelle = $lgTypeChambre ['libelle'];

        echo "

             	<tr class='ligneTabQuad'>
                <td>$idTypeChambre</td>
                <td>$libelle</td>

        ";

        if ($action == 'validerModifierOffre' &&  (!estEntier ($nbChambres[$i]) || !estModifOffreCorrecte ($connexion, $idEtab, $idTypeChambre, $nbChambres [$i]))) {

            echo "

                <td align='center'><input type='text' value='$nbChambres[$i]' 
                name='nbChambres[$i]' maxlength='3' class='erreur'></td>

			";

        } else {
            
            $nbOffre = obtenirNbOffre ($connexion, $idEtab, $idTypeChambre);

            echo "

                <td align='center'><input type='text' value='$nbOffre' 
                name='nbChambres[$i]' maxlength='3'></td>

            ";

        }
        
        echo "
                
            <input type='hidden' value='$idTypeChambre' 
            name='idTypeChambre[$i]'>
            </tr>

        ";

        $i = $i + 1;

    }

    echo "

    	</table>
    	<input type='hidden' value='$idEtab' name='idEtab'>    
       	<input type='hidden' value='$i' name='nbLignes'>
       
       	<table align='center' cellspacing='15' cellpadding='0'>
          	<tr>
             	<td align='right'><input type='submit' value='Valider' 
             	name='validerModifierOffre'></td>
             	<td align='left'><input type='reset' value='Annuler' name='annuler'>
             	</td>
          	</tr>
       	</table>
       	<a href='cOffreHebergement.php?'>Retour</a>
    </form>

   	";

    include '_fin.inc.php';

?>