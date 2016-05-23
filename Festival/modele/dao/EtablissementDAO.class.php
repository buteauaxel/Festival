<?php

    namespace modele\dao;
    
    use modele\metier\Etablissement;
    use modele\dao\DAO;
    require 'DAO.class.php';
    use \PDO;

    class EtablissementDAO implements DAO {
            
        public static function enregistrementVersObjet ($unEnregistrement) {

            $retour = new Etablissement($unEnregistrement['id'], $unEnregistrement['nom'], $unEnregistrement['adresseRue'], $unEnregistrement['codePostal'], $unEnregistrement['ville'], $unEnregistrement['tel'], $unEnregistrement['adresseElectronique'], $unEnregistrement['type'], $unEnregistrement['civiliteResponsable'], $unEnregistrement['nomResponsable'], $unEnregistrement['prenomResponsable']);
            return $retour;  

        }

        public static function objetVersEnregistrement ($objetMetier) {

            $retour = array(

                ':id' => $objetMetier->getId(),
                ':nom' => $objetMetier->getNom(),
                ':adresseRue' => $objetMetier->getAdresseRue(),
                ':codePostal' => $objetMetier->getCodePostal(),
                ':ville' => $objetMetier->getVille(),
                ':tel' => $objetMetier->getTel(),
                ':adresseElectronique' => $objetMetier->getAdresseElectronique(),
                ':type' => $objetMetier->getType(),
                ':civiliteResponsable' => $objetMetier->getCiviliteResponsable(),
                ':nomResponsable' => $objetMetier->getNomResponsable(),
                ':prenomResponsable' => $objetMetier->getPrenomResponsable()

            );

            return $retour;

        }
        
        public static function getAll () {

            $retour = null;
            $sql = "SELECT * FROM etablissement";

            try {
                
                $queryPrepare = Connexion::getPdo ()->prepare ($sql);
                
                if ($queryPrepare->execute ()) {
                   
                    $retour = array ();
                   
                    while ($enregistrement = $queryPrepare -> fetch (PDO::FETCH_ASSOC)) {
                        
                        $unObjetMetier = self::enregistrementVersObjet ($enregistrement);
                        $retour [] = $unObjetMetier;

                    }

                }

            } catch (PDOException $e) {
                echo get_class() . ' - ' . __METHOD__ . ' : ' . $e->getMessage();
            }

            return $retour;

        }

        public static function getOneById($valeurClePrimaire) {

            $retour = null;

            try {
                
                $sql = "SELECT * FROM etablissement WHERE id = ?";
                $queryPrepare = Connexion::getPdo()->prepare($sql);

                if ($queryPrepare->execute(array($valeurClePrimaire))) {
                    
                    $enregistrement = $queryPrepare->fetch(PDO::FETCH_ASSOC);
                    $retour = self::enregistrementVersObjet($enregistrement);

                }

            } catch (PDOException $e) {
                echo get_class() . ' - '.__METHOD__ . ' : '. $e->getMessage();
            }

            return $retour;
            
        }


        public static function insert($objetMetier) {
            return FALSE;
        }
        
        public static function update($idMetier, $objetMetier) {
            return FALSE;
        }

        public static function delete($idMetier) {
            
        }

        /*
         * Obtenir le Nom et l'Identifiant d'un Etablissement
         * @Prends : (PDO)
         * @Retourne : un résultat (ID, Nom)
         */

        function obtenirIdNomEtablissements ($connexion) {

            $req = "SELECT id, nom FROM Etablissement ORDER BY id";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute ();
            return $stmt;

        }

        /*
         * Obtenir le Nom et l'Identifiant des Etablissements offrant une Chambre
         * @Prends : (PDO)
         * @Retourne : le Nom et l'Identifiant des Etablissements offrant une Chambre
         */

        static function obtenirIdNomEtablissementsOffrantChambres ($connexion) {

            $req = "SELECT DISTINCT id, nom FROM Etablissement e 
                        INNER JOIN Offre o ON e.id = o.idEtab 
                        ORDER BY id";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute ();
            return $stmt;

        }

        /*
         * Obtenir le Nom des Etablissements offrant une Chambre
         * @Prends : (PDO)
         * @Retourne : les Noms des Etablissements
         */

        static function obtenirNomEtablissementsOffrantChambres ($connexion) {

            $req = "SELECT DISTINCT nom FROM Etablissement e 
                        INNER JOIN Offre o ON e.id = o.idEtab 
                        ORDER BY id";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute ();
            return $stmt;

        }

        /*
         * Obtenir l'ID des Etablissements offrant une Chambre
         * @Prends : (PDO)
         * @Retourne : l'ID de l'Etablissement
         */

        static function obtenirIdEtablissementsOffrantChambres ($connexion) {

            $req = "SELECT DISTINCT id FROM Etablissement e 
                        INNER JOIN Offre o ON e.id = o.idEtab 
                        ORDER BY id";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute ();
            return $stmt;

        }

        /*
         * Obtenir le détail d'un Etablissement
         * @Prends : (PDO), un ID
         * @Retourne : les Attributs de l'Etablissement
         */

        function obtenirDetailEtablissement ($connexion, $id) {

            $req = "SELECT * FROM Etablissement WHERE id=?";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute (array ($id));
            return $stmt -> fetch (PDO::FETCH_ASSOC);

        }

        /*
         * Supprime un Etablissement
         * @Prends : (PDO), un ID
         * @Retourne : un Booleen (Vrai si la Suppression a eu lieu)
         */

        function supprimerEtablissement ($connexion, $id) {

            $req = "DELETE FROM Etablissement WHERE id=?";
            $stmt = $connexion -> prepare ($req);
            $ok = $stmt -> execute (array ($id));
            return $ok;

        }

        /*
         * Supprime un Etablissement
         * @Prends : (PDO), un Mode, un ID, un Nom, une Adresse, un Code Postal, une Ville, un Numéro, une Adresse Mail, un Type, le Genre, le Nom du Responsable, le Prénom du Responsable
         * @Retourne : un Booleen (Vrai si la Création a eu lieu)
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
         * @Prends : (PDO), un ID
         * @Retourne : le Nombre d'Etablissements trouvés
         */

        function estUnIdEtablissement ($connexion, $id) {

            $req = "SELECT COUNT(*) FROM Etablissement WHERE id=?";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute (array ($id));
            return $stmt -> fetchColumn ();

        }

        /*
         * Compte le Nombre d'Etablissements avec le même Nom
         * @Prends : (PDO), un Mode, un ID, un Nom
         * @Retourne : le Nombre d'Etablissements trouvés
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
         * @Prends : (PDO)
         * @Retourne : le Nombre d'Etablissements trouvés
         */

        static function obtenirNbEtab ($connexion) {

            $req = "SELECT COUNT(*) FROM Etablissement";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute ();
            return $stmt -> fetchColumn ();

        }

        /*
         * Compte le Nombre d'Etablissement offrant des Chambres
         * @Prends : (PDO)
         * @Retourne : le Nombre d'Etablissements trouvés
         */

        static function obtenirNbEtabOffrantChambres ($connexion) {

            $req = "SELECT COUNT(DISTINCT idEtab) FROM Offre";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute ();
            return $stmt -> fetchColumn ();

        }

    }

?>