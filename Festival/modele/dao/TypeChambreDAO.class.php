<?php

    namespace modele\dao;
    
    use modele\metier\TypeChambre;
    use \PDO;

    class TypeChambreDAO implements DAO {
            
        public static function enregistrementVersObjet ($unEnregistrement) {

            $retour = new TypeChambre ($unEnregistrement ['id'], $unEnregistrement ['libelle']);
            return $retour;   

        }

        public static function objetVersEnregistrement ($objetMetier) {

            $retour = array (':id' => $objetMetier -> getId (), ':libelle' => $objetMetier -> getLibelle ());
            return $retour;

        }
        
        public static function getAll () {

            $retour = null;
            $sql = "SELECT * FROM typechambre";

            try {
                
                $queryPrepare = Connexion:: getPdo () -> prepare ($sql);
                
                if ($queryPrepare -> execute ()) {
                    
                    $retour = array ();
                    
                    while  ($enregistrement = $queryPrepare -> fetch (PDO:: FETCH_ASSOC)) {
                       
                        $unObjetMetier = self:: enregistrementVersObjet ($enregistrement);
                        $retour [] = $unObjetMetier;

                    }

                }
                
            } catch (PDOException $e) {
                echo get_class () . ' - ' . __METHOD__ . ' : ' . $e -> getMessage ();
            }

            return $retour;

        }

        public static function getOneById ($valeurClePrimaire) {

            $retour = null;

            try {

                $sql = "SELECT * FROM typechambre WHERE id = ?";
                $queryPrepare = Connexion:: getPdo () -> prepare ($sql);

                if ($queryPrepare -> execute (array ($valeurClePrimaire))) {

                    $enregistrement = $queryPrepare -> fetch (PDO:: FETCH_ASSOC);
                    $retour = self:: enregistrementVersObjet ($enregistrement);

                }

            } catch (PDOException $e) {
                echo get_class () . ' - '.__METHOD__ . ' : '. $e -> getMessage ();
            }

            return $retour;

        }


        public static function insert ($objetMetier) {
            return FALSE;
        }
        
        public static function update ($idMetier, $objetMetier) {
            return FALSE;
        }

        public static function delete ($idMetier) {
            
        }

        /*
         * Compte le Nombre d'Etablissement offrant des Chambres
         * @Prends : (PDO)
         * @Retourne : le Nombre d'Etablissements trouvés
         */

        static function obtenirTypesChambres ($connexion) {

            $req = "SELECT * FROM TypeChambre";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute ();
            return $stmt;

        }

        /*
         * Obtenir les ID des Types de Chambres
         * @Prends : (PDO)
         * @Retourne : l'ID des Types de Chambres
         */

        static function obtenirIdTypesChambres ($connexion) {

            $req = "SELECT id FROM TypeChambre";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute ();
            return $stmt;

        }

        /*
         * Obtenir les libellés des Types de Chambres
         * @Prends : (PDO)
         * @Retourne : les Libellés des Types de Chambres
         */

        function obtenirLibelleTypesChambres ($connexion) {

            $req = "SELECT libelle FROM TypeChambre ORDER BY id";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute ();
            return $stmt;

        }

        /*
         * Obtenir le Libellé d'un Type de Chambre
         * @Prends : (PDO), l'ID du Type de Chambre
         * @Retourne : le Libellé du Type de Chambre
         */

        function obtenirLibelleTypeChambre ($connexion, $id) {

            $req = "SELECT libelle FROM TypeChambre WHERE id = ?";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute (array ($id));
            return $stmt -> fetchColumn ();

        }

        /*
         * Obtenir le Nombre de Types de Chambres
         * @Prends : (PDO)
         * @Retourne : le Nombre de Types de Chambres
         */

        static function obtenirNbTypesChambres ($connexion) {

            $req = "SELECT COUNT(*) FROM TypeChambre";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute ();
            return $stmt -> fetchColumn ();

        }

        /*
         * Supprimer un Type de Chambre
         * @Prends : (PDO), l'ID du Type de Chambre
         * @Retourne : un Booleen (Vrai si la Suppression a eu lieu)
         */

        function supprimerTypeChambre ($connexion, $id) {

            $req = "DELETE FROM TypeChambre WHERE id=?";
            $stmt = $connexion -> prepare ($req);
            $ok = $stmt -> execute (array ($id));
            return $ok;

        }

        /*
         * Obtenir le Détail d'un Type de Chambre
         * @Prends : (PDO), l'ID du Type de Chambre
         * @Retourne : un Booleen (Vrai si la Suppression a eu lieu)
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
         * @Prends : (PDO)
         * @Retourne : (ID, Nom)
         */

        function estUnIdTypeChambre ($connexion, $id) {

            $req = "SELECT COUNT(*) FROM TypeChambre WHERE id=?";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute (array ($id));
            return $stmt -> fetchColumn ();

        }

        /*
         * Obtenir le Nom et l'Identifiant d'un Etablissement
         * @Prends : (PDO)
         * @Retourne : (ID, Nom)
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

    }

?>