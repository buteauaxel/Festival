<?php

   include ("_debut.inc.php"); 
   require ("fonctions.inc.php");

   use modele\dao\Connexion;

   include_once 'modele/dao/EtablissementDAO.class.php';
    include_once 'modele/dao/TypeChambreDAO.class.php';
    include_once 'modele/dao/AttributionDAO.class.php';
    include_once 'modele/dao/OffreDAO.class.php';
    include_once 'modele/dao/GroupeDAO.class.php';

   use modele\metier\Groupe;
   use modele\dao\GroupeDAO;

   // SÉLECTIONNER LE NOMBRE DE CHAMBRES SOUHAITÉES

   if ($_SESSION ['nom'] != 'invité') {

      echo "
      <form method='POST' action='cAttributionChambres.php'>
         <input type='hidden' value='validerModifierAttrib' name='action'>
         <input type='hidden' value='$idEtab' name='idEtab'>
         <input type='hidden' value='$idTypeChambre' name='idTypeChambre'>
         <input type='hidden' value='$idGroupe' name='idGroupe'>";
      $nomGroupe = GroupeDAO:: obtenirNomGroupe($connexion, $idGroupe);
      echo "
         <br><center>Combien de chambres de type $idTypeChambre souhaitez-vous pour le 
         groupe $nomGroupe ?";
      echo "<br><br><br>";

      echo "<select name='nbChambres'>";
      for ($i = 0; $i <= $nbChambres; $i++) {
          echo "<option>$i</option>";
      }
      echo "</select></center>";
      echo "<br>";
      echo "<input type='submit' value='Valider' name='valider'>&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;<input type='reset' value='Annuler' name='Annuler'>
         <br><br>
         <a href='cAttributionChambres.php?action=demanderModifierAttrib'>Retour</a>
      </form>";

   } else if ($_SESSION ['nom'] == 'invité') {
      echo "<br /><br /><div class = 'alert alert-info' style = 'font-size: 14px !important;'>Vous n'avez pas les droits ! Veuillez vous connecter.</div>";
   }

   include("_fin.inc.php");

?>