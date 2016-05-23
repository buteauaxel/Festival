<?php

include("_debut.inc.php");

// AFFICHER L'ENSEMBLE DES ÉTABLISSEMENTS
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR
// ÉTABLISSEMENT

if ($_SESSION ['nom'] != 'invité') {

    echo "
    <br>
    <table width='55%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>

       <tr class='enTeteTabNonQuad'>
          <td colspan='4'><strong>Etablissements</strong></td>
       </tr>";

    $rsEtab = obtenirIdNomEtablissements($connexion);
    //$rsEtab = mysql_query($req, $connexion);

    // BOUCLE SUR LES ÉTABLISSEMENTS
    while ($lgEtab = $rsEtab->fetch(PDO::FETCH_ASSOC)) {
        $id = $lgEtab['id'];
        $nom = $lgEtab['nom'];
        echo "
    		<tr class='ligneTabNonQuad'>
             <td width='52%'>$nom</td>
             
             <td width='16%' align='center'> 
             <a href='cGestionEtablissements.php?action=detailEtab&id=$id'>
             Voir détail</a></td>
             
             <td width='16%' align='center'> 
             <a href='cGestionEtablissements.php?action=demanderModifierEtab&id=$id'>
             Modifier</a></td>";

        // S'il existe déjà des attributions pour l'établissement, il faudra
        // d'abord les supprimer avant de pouvoir supprimer l'établissement
        if (!existeAttributionsEtab($connexion, $id)) {
            echo "
                <td width='16%' align='center'> 
                <a href='cGestionEtablissements.php?action=demanderSupprimerEtab&id=$id'>
                Supprimer</a></td>";
        } else {
            echo "
                <td width='16%'>&nbsp; </td>";
        }
        echo "
          </tr>";
    }
    echo "
    </table>
    <br>
    <a href='cGestionEtablissements.php?action=demanderCreerEtab'>
    Création d'un établissement</a >";

} else if ($_SESSION ['nom'] == 'invité') {
    echo "<br /><br /><div class = 'alert alert-info' style = 'font-size: 14px !important;'>Vous n'avez pas les droits ! Veuillez vous connecter.</div>";
}

include("_fin.inc.php");

