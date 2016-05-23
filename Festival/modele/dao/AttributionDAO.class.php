<?php

    namespace modele\dao;

    use modele\metier\Attribution;
    use modele\dao\OffreDAO;
    use modele\metier\Offre;
    use \PDO;

    class AttributionDAO implements DAO {
            
        public static function enregistrementVersObjet($unEnregistrement) {

            $retour = new Attribution($unEnregistrement['idEtab'], $unEnregistrement['idTypeChambre'], $unEnregistrement['idGroupe'], $unEnregistrement['nombreChambres']);
            return $retour; 

        }

        public static function objetVersEnregistrement($objetMetier) {

            $retour = array(
                ':idEtab' => $objetMetier->getIdEtab(),
                ':idTypeChambre' => $objetMetier->getidTypeChambre(),
                ':idGroupe' => $objetMetier->getIdGroupe(),
                ':nombreChambre' => $objetMetier->getNombreChambre()
            );

            return $retour;

        }
        
        public static function getAll() {

            $retour = null;
            $sql = "SELECT * FROM attribution";

            try {
                
                $queryPrepare = Connexion::getPdo()->prepare($sql);
               
                if ($queryPrepare->execute()) {
                    
                    $retour = array();
                   
                    while ($enregistrement = $queryPrepare->fetch(PDO::FETCH_ASSOC)) {
                       
                        $unObjetMetier = self::enregistrementVersObjet($enregistrement);
                        $retour[] = $unObjetMetier;

                    }
                }
            } catch (PDOException $e) {
                echo get_class() . ' - ' . __METHOD__ . ' : ' . $e->getMessage();
            }
            return $retour;
        }

        public static function getOneById($valeurClePrimaire) {
            
        }
        
        public static function getOneByIdCompo($idEtablissement, $idTypeChambre, $idGroupe){

            $retour = null;
            $valeursClePrimaire = array($idEtablissement, $idTypeChambre, $idGroupe);

            try {
                
                $sql = "SELECT * FROM attribution WHERE idEtab = ? AND idTypeChambre = ? AND idGroupe = ?";
                $queryPrepare = Connexion::getPdo()->prepare($sql);
                
                if ($queryPrepare->execute($valeursClePrimaire)) {
                    
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
         * Compte le Nombre d'Attribution d'un Etablissement
         * @Prends : (PDO), l'ID de l'Etablissement
         * @Retourne : le Nombre d'Attributions trouvées
         */

        static function existeAttributionsEtab ($connexion, $id) {

            $req = "SELECT COUNT(*) FROM Attribution WHERE idEtab=?";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute (array ($id));
            return $stmt -> fetchColumn ();

        }

        /*
         * Obtenir le Nombre d'Attributions selon le Type de Chambre
         * @Prends : (PDO), l'ID du Type de Chambre
         * @Retourne : le Nombre d'Attributions trouvées
         */

        static function existeAttributionsTypeChambre ($connexion, $id) {

            $req = "SELECT COUNT(*) FROM Attribution WHERE idTypeChambre=?";
            $stmt = $connexion -> prepare ($req);
            $stmt -> execute (array ($id));
            return $stmt -> fetchColumn ();

        }

        /*
         * Obtenir le Nombre d'Occupants
         * @Prends : (PDO), l'ID de l'Etablissement, l'ID du Type de Chambre
         * @Retourne : le Nombre d'Occupants avec le Type de Chambre
         */

        static function obtenirNbOccup ($connexion, $idEtab, $idTypeChambre) {

            $req = "SELECT IFNULL (SUM(NombreChambres), 0) AS totalChambresOccup FROM 
                Attribution WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh";
            $stmt = $connexion -> prepare ($req);
            $stmt -> bindParam (':idEtab', $idEtab);
            $stmt -> bindParam (':idTypeCh', $idTypeChambre);
            $stmt -> execute ();
            $nb = $stmt -> fetchColumn ();
            return $nb;

        }

        static function modifierAttribChamb($connexion, $idEtab, $idTypeChambre, $idGroupe, $nbChambres) {

            $req = "SELECT COUNT(*) AS nombreAttribGroupe 
                FROM Attribution 
                WHERE idEtab= :idEtab AND idTypeChambre=:idTypeCh AND idGroupe=:idGroupe";
            $stmt = $connexion->prepare($req);
            $stmt->bindParam(':idEtab', $idEtab);
            $stmt->bindParam(':idTypeCh', $idTypeChambre);
            $stmt->bindParam(':idGroupe', $idGroupe);
            $stmt->execute();
            $lgAttrib = $stmt->fetchColumn();

            if ($nbChambres == 0) {

                $req = "DELETE FROM Attribution WHERE idEtab=:idEtab AND 
                   idTypeChambre=:idTypeCh AND idGroupe=:idGroupe";
                $stmt = $connexion->prepare($req);

            } else {

                if ($lgAttrib != 0) {
                    $req = "UPDATE Attribution SET nombreChambres=:nbCh 
                        WHERE idEtab=:idEtab AND idTypeChambre=:idTypeCh 
                        AND idGroupe=:idGroupe";
                } else {
                    $req = "INSERT INTO Attribution VALUES(:idEtab, :idTypeCh, :idGroupe, :nbCh)";
                }
                
                $stmt = $connexion->prepare($req);
                $stmt->bindParam(':nbCh', $nbChambres);

            }

            $stmt->bindParam(':idEtab', $idEtab);
            $stmt->bindParam(':idTypeCh', $idTypeChambre);
            $stmt->bindParam(':idGroupe', $idGroupe);

            $ok = $stmt->execute();
            return $ok;

        }

        static function obtenirGroupesEtab($connexion, $id) {

            $req = "SELECT DISTINCT id, nom FROM Groupe 
                INNER JOIN Attribution ON Attribution.idGroupe = Groupe.id 
                WHERE idEtab=?";
            $stmt = $connexion->prepare($req);
            $stmt->execute(array($id));
            return $stmt;

        }

        static function obtenirNbDispo ($connexion, $idEtab, $idTypeChambre) {

            $nbOffre = OffreDAO:: obtenirNbOffre ($connexion, $idEtab, $idTypeChambre);

            if ($nbOffre != 0) {

                $nbOccup = AttributionDAO:: obtenirNbOccup($connexion, $idEtab, $idTypeChambre);
                $nbChLib = $nbOffre - $nbOccup;
                return $nbChLib;

            } else {
                return 0;
            }

        }

        static function obtenirNbOccupGroupe($connexion, $idEtab, $idTypeChambre, $idGroupe) {

            $req = "SELECT nombreChambres FROM Attribution 
                    WHERE idEtab=:idEtab 
                      AND idTypeChambre=:idTypeCh 
                      AND idGroupe=:idGroupe";

            $stmt = $connexion->prepare($req);
            $stmt->bindParam(':idEtab', $idEtab);
            $stmt->bindParam(':idTypeCh', $idTypeChambre);
            $stmt->bindParam(':idGroupe', $idGroupe);
            $stmt->execute();
            $ok = $stmt->fetchColumn();

            if ($ok) {
                return $ok;
            } else {
                return 0;
            }

        }

    }

?>