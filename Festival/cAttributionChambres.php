<!-- Controlleur de l'Attribution des Chambres -->

<?php

    include "_gestionErreurs.inc.php";
    include "gestionDonnees/_connexion.inc.php";

    include_once 'modele/dao/EtablissementDAO.class.php';
    include_once 'modele/dao/TypeChambreDAO.class.php';
    include_once 'modele/dao/AttributionDAO.class.php';
    include_once 'modele/dao/OffreDAO.class.php';
    include_once 'modele/dao/GroupeDAO.class.php';
     
    use modele\dao\Connexion;

    use modele\metier\Attribution;
    use modele\metier\Etablissement;
    use modele\dao\EtablissementDAO;
    use modele\dao\AttributionDAO;
    use modele\dao\DAO;

    if (!isset ($_REQUEST ["action"])) {
        $_REQUEST ["action"] = "initial";
    }

    $action = $_REQUEST ["action"];

    switch ($action) {

        case "initial":

            include "vues/AttributionChambres/vConsulterAttributionChambres.php";
            break;

        case "demanderModifierAttrib":

            include "vues/AttributionChambres/vModifierAttributionChambres.php";
            break;

        case "donnerNbChambres":

            $idEtab = $_REQUEST ["idEtab"];
            $idTypeChambre = $_REQUEST ["idTypeChambre"];
            $idGroupe = $_REQUEST ["idGroupe"];
            $nbChambres = $_REQUEST ["nbChambres"];
            include "vues/AttributionChambres/vDonnerNbChambresAttributionChambres.php";
            break;

        case "validerModifierAttrib":
        
            $idEtab = $_REQUEST ["idEtab"];
            $idTypeChambre = $_REQUEST ["idTypeChambre"];
            $idGroupe = $_REQUEST ["idGroupe"];
            $nbChambres = $_REQUEST ["nbChambres"];
            AttributionDAO:: modifierAttribChamb($connexion, $idEtab, $idTypeChambre, $idGroupe, $nbChambres);
            include "vues/AttributionChambres/vModifierAttributionChambres.php";
            break;

    }

    Connexion:: SeDeconnecter ();

?>