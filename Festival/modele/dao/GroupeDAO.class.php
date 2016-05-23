<?php

    namespace modele\dao;

    use modele\metier\Groupe;
    use \PDO;

    class GroupeDAO implements DAO {
            
        public static function enregistrementVersObjet($unEnregistrement) {

            $retour = new Groupe($unEnregistrement['id'], $unEnregistrement['nom'], $unEnregistrement['identiteResponsable'], $unEnregistrement['adressePostale'], $unEnregistrement['nombrePersonne'], $unEnregistrement['nomPays'], $unEnregistrement['hebergement']);
            return $retour; 
                   
        }

        public static function objetVersEnregistrement($objetMetier) {

            $retour = array(

                ':id' => $objetMetier->getId(),
                ':nom' => $objetMetier->getNom(),
                ':identiteResponsable' => $objetMetier->getIdentiteResponsable(),
                ':adressePostale' => $objetMetier->getAdressePostale(),
                ':nombrePersonne' => $objetMetier->getNombrePersonne(),
                ':nomPays' => $objetMetier->getNomPays(),
                ':hebergement' => $objetMetier->getHebergement()

            );

            return $retour;

        }
        
        public static function getAll() {

            $retour = null;
            $sql = "SELECT * FROM groupe";

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

            $retour = null;

            try {
                
                $sql = "SELECT * FROM groupe WHERE id = ?";
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
     * @Retourne : (ID, Nom)
     */

    static function obtenirIdNomGroupesAHeberger ($connexion) {

        $req = "SELECT id, nom FROM Groupe WHERE hebergement='O' ORDER BY id";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute ();
        return $stmt;

    }

    /*
     * Obtenir le Nom et l'Identifiant d'un Etablissement
     * @Prends : (PDO)
     * @Retourne : (ID, Nom)
     */

    static function obtenirNomGroupe ($connexion, $id) {

        $req = "SELECT nom FROM Groupe WHERE id=?";
        $stmt = $connexion -> prepare ($req);
        $stmt -> execute (array ($id));
        return $stmt -> fetchColumn ();

    }

    }

?>