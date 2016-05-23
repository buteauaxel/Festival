<?php

    /* Fonctions relatives aux Etablissements */

    /* Fonctions relatives aux Etablissements */

    /*
     * Obtenir le Nom et l'Identifiant d'un Etablissement
     * @Prends : PDO
     * @Retourne : ID, Nom
     */

    function obtenirIdNomEtablissements ($connexion) {

        $req = "SELECT id, nom FROM Etablissement ORDER BY id";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt;

    }

    /*
     * Obtenir le Nom et l'Identifiant des Etablissements offrant une Chambre
     * @Prends : PDO
     * @Retourne : ID, Nom
     */

    function obtenirIdNomEtablissementsOffrantChambres ($connexion) {

        $req = "SELECT DISTINCT id, nom FROM Etablissement e 
                    INNER JOIN Offre o ON e.id = o.idEtab 
                    ORDER BY id";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt;

    }

    /*
     * Obtenir le Nom des Etablissements offrant une Chambre
     * @Prends : PDO
     * @Retourne : Nom
     */

    function obtenirNomEtablissementsOffrantChambres ($connexion) {

        $req = "SELECT DISTINCT nom FROM Etablissement e 
                    INNER JOIN Offre o ON e.id = o.idEtab 
                    ORDER BY id";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt;

    }

    /*
     * Obtenir l'ID des Etablissements offrant une Chambre
     * @Prends : PDO
     * @Retourne : ID
     */

    function obtenirIdEtablissementsOffrantChambres ($connexion) {

        $req = "SELECT DISTINCT id FROM Etablissement e 
                    INNER JOIN Offre o ON e.id = o.idEtab 
                    ORDER BY id";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt;

    }

    /*
     * Obtenir le détail d'un Etablissement
     * @Prends : PDO, un ID
     * @Retourne : Attributs
     */

    function obtenirDetailEtablissement ($connexion, $id) {

        $req = "SELECT * FROM Etablissement WHERE id=?";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute (array ($id));
        return $stmt -> fetch (PDO::FETCH_ASSOC);

    }

    /*
     * Supprime un Etablissement
     * @Prends : PDO, un ID
     * @Retourne : Booleen
     */

    function supprimerEtablissement ($connexion, $id) {

        $req = "DELETE FROM Etablissement WHERE id=?";
        $stmt = $connexion -> prepare ($req);
        $ok = $stmt -> execute (array ($id));
        return $ok;

    }

    /*
     * Supprime un Etablissement
     * @Prends : PDO, un Mode, un ID, un Nom, une Adresse, un Code Postal, une Ville, un Numéro, une Adresse Mail, un Type, le Genre, le Nom du Responsable, le Prénom du Responsable
     * @Retourne : Booleen
     */

    function creerModifierEtablissement ($connexion, $mode, $id, $nom, $adresseRue, $codePostal, $ville, $tel, $adresseElectronique, $type, $civiliteResponsable, $nomResponsable, $prenomResponsable) {
        
        if ($mode == 'C') {
            $req = "INSERT INTO Etablissement VALUES  (:id, :nom, :rue, :cdp, :ville, :tel, :email, :type, :civ, :nomResp, :prenomResp)";
        } else {

            $req = "UPDATE Etablissement SET nom=:nom, adresseRue=:rue,
               codePostal=:cdp, ville=:ville, tel=:tel,
               adresseElectronique=:email, type=:type,
               civiliteResponsable=:civ, nomResponsable=:nomResp, prenomResponsable=:prenomResp 
               WHERE id=:id";

        }

        $stmt = $connexion -> prepare ($req);
        $stmt -> bindParam (':id', $id);
        $stmt -> bindParam (':nom', $nom);
        $stmt -> bindParam (':rue', $adresseRue);
        $stmt -> bindParam (':cdp', $codePostal);
        $stmt -> bindParam (':ville', $ville);
        $stmt -> bindParam (':tel', $tel);
        $stmt -> bindParam (':email', $adresseElectronique);
        $stmt -> bindParam (':type', $type);
        $stmt -> bindParam (':civ', $civiliteResponsable);
        $stmt -> bindParam (':nomResp', $nomResponsable);
        $stmt -> bindParam (':prenomResp', $prenomResponsable);

        $ok = $stmt -> execute ();

        return $ok;

    }

    /*
     * Compte le Nombre d'Etablissements avec le même ID
     * @Prends : PDO, un ID
     * @Retourne : Nombre
     */

    function estUnIdEtablissement ($connexion, $id) {

        $req = "SELECT COUNT(*) FROM Etablissement WHERE id=?";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute (array ($id));
        return $stmt -> fetchColumn ();

    }

    /*
     * Compte le Nombre d'Etablissements avec le même Nom
     * @Prends : PDO, Mode, ID, Nom
     * @Retourne : Nombre
     */

    function estUnNomEtablissement ($connexion, $mode, $id, $nom) {

        $nom = str_replace ("'", "''", $nom);

        if ($mode == 'C') {

            $req = "SELECT COUNT(*) FROM Etablissement WHERE nom=?";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute (array ($nom));

        } else {

            $req = "SELECT COUNT(*) FROM Etablissement WHERE nom=? AND id<>?";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute (array ($nom, $id));

        }

        return $stmt -> fetchColumn ();

    }

    /*
     * Compte le Nombre d'Etablissements
     * @Prends : PDO
     * @Retourne : Nombre
     */

    function obtenirNbEtab ($connexion) {

        $req = "SELECT COUNT(*) FROM Etablissement";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt -> fetchColumn ();

    }

    /*
     * Compte le Nombre d'Etablissement offrant des Chambres
     * @Prends : PDO
     * @Retourne : Nombre
     */

    function obtenirNbEtabOffrantChambres ($connexion) {

        $req = "SELECT COUNT(DISTINCT idEtab) FROM Offre";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt -> fetchColumn ();

    }

    /* Fonctions relatives aux Types de Chambres */

    /*
     * Compte le Nombre d'Etablissement offrant des Chambres
     * @Prends : PDO
     * @Retourne : Nombre
     */

    function obtenirTypesChambres ($connexion) {

        $req = "SELECT * FROM TypeChambre";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt;

    }

    /*
     * Obtenir les ID des Types de Chambres
     * @Prends : PDO
     * @Retourne : ID
     */

    function obtenirIdTypesChambres ($connexion) {

        $req = "SELECT id FROM TypeChambre";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt;

    }

    /*
     * Obtenir les libellés des Types de Chambres
     * @Prends : PDO
     * @Retourne : Libellés
     */

    function obtenirLibelleTypesChambres ($connexion) {

        $req = "SELECT libelle FROM TypeChambre ORDER BY id";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt;

    }

    /*
     * Obtenir le Libellé d'un Type de Chambre
     * @Prends : PDO, ID
     * @Retourne : Libellé
     */

    function obtenirLibelleTypeChambre ($connexion, $id) {

        $req = "SELECT libelle FROM TypeChambre WHERE id = ?";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute (array ($id));
        return $stmt -> fetchColumn ();

    }

    /*
     * Obtenir le Nombre de Types de Chambres
     * @Prends : PDO
     * @Retourne : Nombre
     */

    function obtenirNbTypesChambres ($connexion) {

        $req = "SELECT COUNT(*) FROM TypeChambre";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt -> fetchColumn ();

    }

    /*
     * Supprimer un Type de Chambre
     * @Prends : PDO, ID
     * @Retourne : Booleen
     */

    function supprimerTypeChambre ($connexion, $id) {

        $req = "DELETE FROM TypeChambre WHERE id=?";
        $stmt = $connexion -> prepare ($req);
        $ok = $stmt -> execute (array ($id));
        return $ok;

    }

    /*
     * Obtenir le Détail d'un Type de Chambre
     * @Prends : PDO, ID
     * @Retourne : Booleen
     */

    function obtenirDetailTypeChambre ($connexion, $id) {

        $req = "SELECT * FROM TypeChambre WHERE id=?";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute (array ($id));
        return $stmt;

    }

    function creerModifierTypeChambre ($connexion, $mode, $id, $libelle) {

        $libelle = str_replace ("'", "''", $libelle);

        if ($mode == 'C') {
            $req = "INSERT INTO TypeChambre VALUES  (:id, :lib)";
        } else {
            $req = "UPDATE TypeChambre SET libelle=:lib WHERE id=:id";
        }

        $stmt = $connexion -> prepare ($req);
        $stmt -> bindParam (':id', $id);
        $stmt -> bindParam (':lib', $libelle);
        $ok = $stmt -> execute ();

        return $ok;

    }

    /*
     * Obtenir le Nom et l'Identifiant d'un Etablissement
     * @Prends : PDO
     * @Retourne : ID, Nom
     */

    function estUnIdTypeChambre ($connexion, $id) {

        $req = "SELECT COUNT(*) FROM TypeChambre WHERE id=?";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute (array ($id));
        return $stmt -> fetchColumn ();

    }

    /*
     * Obtenir le Nom et l'Identifiant d'un Etablissement
     * @Prends : PDO
     * @Retourne : ID, Nom
     */

    function estUnLibelleTypeChambre ($connexion, $mode, $id, $libelle) {

        $libelle = str_replace ("'", "''", $libelle);

        if ($mode == 'C') {

            $req = "SELECT COUNT(*) FROM TypeChambre WHERE libelle=:lib";
            $stmt = $connexion -> prepare ($req);
            $stmt -> bindParam (':lib', $libelle);

        } else {

            $req = "SELECT COUNT(*) FROM TypeChambre WHERE libelle=:lib and id <> :id";
            $stmt = $connexion -> prepare ($req);
            $stmt -> bindParam (':lib', $libelle);
            $stmt -> bindParam (':id', $id);

        }

        $stmt -> execute ();
        return $stmt -> fetchColumn ();

    }

    /* Fonctions relatives aux Groupes */

    /*
     * Obtenir le Nom et l'Identifiant d'un Etablissement
     * @Prends : PDO
     * @Retourne : ID, Nom
     */

    function obtenirIdNomGroupesAHeberger ($connexion) {

        $req = "SELECT id, nom FROM Groupe WHERE hebergement='O' ORDER BY id";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt;

    }

    /*
     * Obtenir le Nom et l'Identifiant d'un Etablissement
     * @Prends : PDO
     * @Retourne : ID, Nom
     */

    function obtenirNomGroupe ($connexion, $id) {

        $req = "SELECT nom FROM Groupe WHERE id=?";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute (array ($id));
        return $stmt -> fetchColumn ();

    }

    /* Fonctions relatives aux Offres */

    /*
     * Obtenir le Nom et l'Identifiant d'un Etablissement
     * @Prends : PDO
     * @Retourne : ID, Nom
     */

    function modifierOffreHebergement ($connexion, $idEtab, $idTypeChambre, $nbChambresDemandees) {

        if ($nbChambresDemandees == 0) {

            $req = "DELETE FROM Offre WHERE idEtab=:idEtab and idTypeChambre=
               :idTypeCh";
            $stmt = $connexion -> prepare ($req);
            $stmt -> bindParam (':idEtab', $idEtab);
            $stmt -> bindParam (':idTypeCh', $idTypeChambre);

        } else {

            $req2 = "SELECT NombreChambres FROM Offre WHERE idEtab=:idEtab AND 
            idTypeChambre=:idTypeCh";
            $stmt2 = $connexion -> prepare ($req2);
            $stmt2 -> bindParam (':idEtab', $idEtab);
            $stmt2 -> bindParam (':idTypeCh', $idTypeChambre);
            $stmt2 -> execute ();
            $lgOffre = $stmt2 -> fetchColumn ();

            if ($lgOffre != 0) {
                $req = "UPDATE Offre SET NombreChambres=:nb WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
            } else {
                $req = "INSERT INTO Offre VALUES (:idEtab, :idTypeCh, :nb)";
            }

            $stmt = $connexion -> prepare ($req);
            $stmt -> bindParam (':idEtab', $idEtab);
            $stmt -> bindParam (':idTypeCh', $idTypeChambre);
            $stmt -> bindParam (':nb', $nbChambresDemandees);

        }

        $ok = $stmt -> execute ();
        return $ok;

    }

    /*
     * Obtenir le Nom et l'Identifiant d'un Etablissement
     * @Prends : PDO
     * @Retourne : ID, Nom
     */

    function obtenirNbOffre ($connexion, $idEtab, $idTypeChambre) {

        $req = "SELECT NombreChambres FROM Offre WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";

        $stmt = $connexion -> prepare ($req);
        $stmt -> bindParam (':idEtab', $idEtab);
        $stmt -> bindParam (':idTypeCh', $idTypeChambre);
        $stmt -> execute ();

        $ok = $stmt -> fetchColumn ();

        if ($ok) {
            return $ok;
        } else {
            return 0;
        }

    }

    /*
     * Obtenir le Nom et l'Identifiant d'un Etablissement
     * @Prends : PDO
     * @Retourne : ID, Nom
     */

    function estModifOffreCorrecte ($connexion, $idEtab, $idTypeChambre, $NombreChambres) {

        $nbOccup = obtenirNbOccup ($connexion, $idEtab, $idTypeChambre);
        return  ($NombreChambres >= $nbOccup);

    }

    /* Fonctions relatives aux Attributions */

    /*
     * Compte le Nombre d'Attribution d'un Etablissement
     * @Prends : PDO, ID
     * @Retourne : Nombre
     */

    function existeAttributionsEtab ($connexion, $id) {

        $req = "SELECT COUNT(*) FROM Attribution WHERE idEtab=?";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute (array ($id));
        return $stmt -> fetchColumn ();

    }

    /*
     * Obtenir le Nombre d'Attributions selon le Type de Chambre
     * @Prends : PDO, ID
     * @Retourne : Nombre
     */

    function existeAttributionsTypeChambre ($connexion, $id) {

        $req = "SELECT COUNT(*) FROM Attribution WHERE idTypeChambre=?";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute (array ($id));
        return $stmt -> fetchColumn ();

    }

    /*
     * Obtenir le Nombre d'Occupants
     * @Prends : PDO, ID, ID
     * @Retourne : lNombre
     */

    function obtenirNbOccup ($connexion, $idEtab, $idTypeChambre) {

        $req = "SELECT IFNULL (SUM(NombreChambres), 0) AS totalChambresOccup FROM 
            Attribution WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
        $stmt = $connexion -> prepare ($req);
        $stmt -> bindParam (':idEtab', $idEtab);
        $stmt -> bindParam (':idTypeCh', $idTypeChambre);
        $stmt -> execute ();
        $nb = $stmt -> fetchColumn ();
        return $nb;

    }

?>