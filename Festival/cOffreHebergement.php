<!-- Controlleur de l'Offre d'Hébergement -->

<?php 

    include '_gestionErreurs.inc.php';
    include 'gestionDonnees/_connexion.inc.php';
    include 'gestionDonnees/_gestionBaseFonctionsCommunes.inc.php';

    require_once 'modele/dao/Connexion.class.php';
    use modele\dao\Connexion;

    if (!isset ($_REQUEST ['action'])) {
        $_REQUEST ['action'] = 'initial';
    }

    $action = $_REQUEST ['action'];
   
    switch  ($action) {

        case 'initial' :

            include 'vues/OffreHebergement/vConsulterOffreHebergement.php';
            break;

        case 'demanderModifierOffre':

            $idEtab = $_REQUEST ['idEtab'];
            include 'vues/OffreHebergement/vModifierOffreHebergement.php';
            break;

        case 'validerModifierOffre':

            $idEtab = $_REQUEST ['idEtab'];
            $idTypeChambre = $_REQUEST ['idTypeChambre'];
            $nbChambres = $_REQUEST ['nbChambres'];
            $nbLignes = $_REQUEST ['nbLignes'];

            $err = false;

            for ($i = 0; $i < $nbLignes; $i ++) {

                $entier = estEntier ($nbChambres [$i]);
                $modifCorrecte = estModifOffreCorrecte ($connexion, $idEtab, $idTypeChambre [$i], $nbChambres [$i]);

                if (!$entier || !$modifCorrecte) {
                    $err = true;
                } else {
                    modifierOffreHebergement ($connexion, $idEtab, $idTypeChambre [$i], $nbChambres [$i]);
                }
                
            }

            if ($err) {

                ajouterErreur ('Valeurs non entières ou inférieures aux attributions effectuées');
                include 'vues/OffreHebergement/vModifierOffreHebergement.php';
                
            } else {
                include 'vues/OffreHebergement/vConsulterOffreHebergement.php';
            }

            break;

        case 'demanderAjouterOffre':

            include 'vues/OffreHebergement/vAjouterOffreHebergement.php';
            break;

    }

    Connexion:: SeDeconnecter ();

?>