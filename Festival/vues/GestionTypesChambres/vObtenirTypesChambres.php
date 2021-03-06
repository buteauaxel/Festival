<?php

include("_debut.inc.php");

// AFFICHER L'ENSEMBLE DES TYPES DE CHAMBRES 
// CETTE PAGE CONTIENT UN TABLEAU CONSTITUÉ D'1 LIGNE D'EN-TÊTE ET D'1 LIGNE PAR 
// TYPE DE CHAMBRE

if ($_SESSION ['nom'] != 'invité') {

echo "
<br>
<table width='40%' cellspacing='0' cellpadding='0' class='tabNonQuadrille'>
   <tr class='enTeteTabNonQuad'>
      <td colspan='4'><strong>Types de chambres</strong></td>
   </tr>";

$rsTypeChambre = obtenirTypesChambres($connexion);


// BOUCLE SUR LES TYPES DE CHAMBRES
while ($lgTypeChambre = $rsTypeChambre->fetch(PDO::FETCH_ASSOC)) {
    $id = $lgTypeChambre['id'];
    $libelle = $lgTypeChambre['libelle'];
    echo "
      <tr class='ligneTabNonQuad'> 
         <td width='15%'>$id</td>
         <td width='33%'>$libelle</td>
         <td width='26%' align='center'>
         
         <a href='cGestionTypesChambres.php?action=demanderModifierTypeChambre&id=$id'>
         Modifier</a></td>";

    // S'il existe déjà des attributions pour le type de chambre, il faudra
    // d'abord les supprimer avant de pouvoir supprimer le type de chambre
    if (!existeAttributionsTypeChambre($connexion, $id)) {
        echo "
            <td width='26%' align='center'>
            <a href='cGestionTypesChambres.php?action=demanderSupprimerTypeChambre&id=$id'>
            Supprimer</a></td>";
    } else {
        echo "<td width='26%'>&nbsp; </td>";
    }
    echo "               
    </tr>";
}
echo "    
</table><br>
<a href='cGestionTypesChambres.php?action=demanderCreerTypeChambre'>
Création d'un type de chambre</a>";

} else if ($_SESSION ['nom'] == 'invité') {
        echo "<br /><br /><div class = 'alert alert-info' style = 'font-size: 14px !important;'>Vous n'avez pas les droits ! Veuillez vous connecter.</div>";
    }

include("_fin.inc.php");

