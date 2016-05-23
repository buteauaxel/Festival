<!-- Controlleur de la Gestion des Etablissements -->

<?php

    include ("_gestionErreurs.inc.php");
    include ("gestionDonnees/_connexion.inc.php");
    include ("gestionDonnees/_gestionBaseFonctionsCommunes.inc.php");

    require_once ("modele/dao/Connexion.class.php");
    use modele\dao\Connexion;

    if (!isset ($_REQUEST ["action"])) {
        $_REQUEST ["action"] = "initial";
    }

    $action = $_REQUEST ["action"];

    switch  ($action) {

        case "initial" :
            include ("vues/GestionEtablissements/vObtenirEtablissements.php");
            break;

        case "detailEtab":
            $id = $_REQUEST ["id"];
            include ("vues/GestionEtablissements/vObtenirDetailEtablissement.php");
            break;

        case "demanderSupprimerEtab":
            $id = $_REQUEST ["id"];
            include ("vues/GestionEtablissements/vSupprimerEtablissement.php");
            break;

        case "demanderCreerEtab":
            include ("vues/GestionEtablissements/vCreerModifierEtablissement.php");
            break;

        case "demanderModifierEtab":
            $id = $_REQUEST ["id"];
            include ("vues/GestionEtablissements/vCreerModifierEtablissement.php");
            break;

        case "validerSupprimerEtab":
            $id = $_REQUEST ["id"];
            supprimerEtablissement ($connexion, $id);
            include ("vues/GestionEtablissements/vObtenirEtablissements.php");
            break;

        case "validerCreerEtab":case "validerModifierEtab":
            $id = $_REQUEST ["id"];
            $nom = $_REQUEST ["nom"];
            $adresseRue = $_REQUEST ["adresseRue"];
            $codePostal = $_REQUEST ["codePostal"];
            $ville = $_REQUEST ["ville"];
            $tel = $_REQUEST ["tel"];
            $adresseElectronique = $_REQUEST ["adresseElectronique"];
            $type = $_REQUEST ["type"];
            $civiliteResponsable = $_REQUEST ["civiliteResponsable"];
            $nomResponsable = $_REQUEST ["nomResponsable"];
            $prenomResponsable = $_REQUEST ["prenomResponsable"];

            if ($action == "validerCreerEtab") {

                verifierDonneesEtabC ($connexion, $id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable);
                if (nbErreurs () == 0) {
                    creerModifierEtablissement ($connexion, "C", $id, $nom, $adresseRue, $codePostal, $ville, $tel, $adresseElectronique, $type, $civiliteResponsable, $nomResponsable, $prenomResponsable);
                    include ("vues/GestionEtablissements/vObtenirEtablissements.php");
                } else {
                    include ("vues/GestionEtablissements/vCreerModifierEtablissement.php");
                }

            } else {

                verifierDonneesEtabM ($connexion, $id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable);
                if (nbErreurs () == 0) {
                    creerModifierEtablissement ($connexion, "M", $id, $nom, $adresseRue, $codePostal, $ville, $tel, $adresseElectronique, $type, $civiliteResponsable, $nomResponsable, $prenomResponsable);
                    include ("vues/GestionEtablissements/vObtenirEtablissements.php");
                } else {
                    include ("vues/GestionEtablissements/vCreerModifierEtablissement.php");
                }

            }

            break;

    }

    Connexion:: seDeconnecter ();

    function verifierDonneesEtabC ($connexion, $id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable) {

        if ($id == "" || $nom == "" || $adresseRue == "" || $codePostal == "" || $ville == "" || $tel == "" || $nomResponsable == "") {
            ajouterErreur ("Chaque champ suivi du caractère * est obligatoire");
        }

        if ($id != "") {

            if (!estChiffresOuEtLettres ($id)) {
                ajouterErreur ("L'identifiant doit comporter uniquement des lettres non accentuées et des chiffres");
            } else {
                if (estUnIdEtablissement ($connexion, $id)) {
                    ajouterErreur ("L'établissement $id existe déjà");
                }
            }
        }

        if ($nom != "" && estUnNomEtablissement ($connexion, "C", $id, $nom)) {
            ajouterErreur ("L'établissement $nom existe déjà");
        }

        if ($codePostal != "" && !estUnCp ($codePostal)) {
            ajouterErreur ("Le code postal doit comporter 5 chiffres");
        }

    }

    function verifierDonneesEtabM ($connexion, $id, $nom, $adresseRue, $codePostal, $ville, $tel, $nomResponsable) {

        if ($nom == "" || $adresseRue == "" || $codePostal == "" || $ville == "" ||
                $tel == "" || $nomResponsable == "") {
            ajouterErreur ("Chaque champ suivi du caractère * est obligatoire");
        }
        if ($nom != "" && estUnNomEtablissement ($connexion, "M", $id, $nom)) {
            ajouterErreur ("L'établissement $nom existe déjà");
        }
        if ($codePostal != "" && !estUnCp ($codePostal)) {
            ajouterErreur ("Le code postal doit comporter 5 chiffres");
        }

    }

    function estUnCp ($codePostal) {
        return strlen ($codePostal) == 5 && estEntier ($codePostal);
    }

?>