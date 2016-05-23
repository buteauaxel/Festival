<?php

	namespace modele\metier;

	class Groupe {

		private $id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, $nomPays, $hebergement;

		public function __construct ($id, $nom, $identiteResponsable, $adressePostale, $nombrePersonnes, $nomPays, $hebergement) {

			$this -> ID = $id;
			$this -> nom = $nom;
			$this -> identiteResponsable = $identiteResponsable;
			$this -> adressePostale = $adressePostale;
			$this -> nombrePersonnes = $nombrePersonnes;
			$this -> nomPays = $nomPays;
			$this -> hebergement = $hebergement;

		}

		public function getID () {
			return $this -> ID;
		}

		public function getNom () {
			return $this -> nom;
		}

		public function getIdentiteResponsable () {
			return $this -> identiteResponsable;
		}

		public function getAdressePostale () {
			return $this -> adressePostale;
		}

		public function getNombrePersonnes () {
			return $this -> nombrePersonnes;
		}

		public function getNomPays () {
			return $this -> nomPays;
		}

		public function getHebergement () {
			return $this -> hebergement;
		}

		public function setID ($id) {
			$this -> ID = $id;
		}

		public function setNom ($nom) {
			$this -> nom = $nom;
		}

		public function setIdentiteResponsable ($identiteResponsable) {
			$this -> identiteResponsable = $identiteResponsable;
		}

		public function setAdressePostale ($adressePostale) {
			$this -> adressePostale = $adressePostale;
		}

		public function setNombrePersonnes ($nombrePersonnes) {
			$this -> nombrePersonnes = $nombrePersonnes;
		}

		public function setNomPays ($nomPays) {
			$this -> nomPays = $nomPays;
		}

		public function setHebergement ($hebergement) {
			$this -> hebergement = $hebergement;
		}

		public function __toString () {

			$etat = "ID du Groupe: " . $this -> getID () . "<br />";
			$etat .= "Nom : " . $this -> getNom () . "<br />";
			$etat .= "Identite du Responsable : " . $this -> getIdentiteResponsable () . "<br />";
			$etat .= "Adresse Postale : " . $this -> getAdressePostale () . "<br />";
			$etat .= "Nombre de Personnes : " . $this -> getNombrePersonnes () . "<br />";
			$etat .= "Pays d'Origine : " . $this -> getNomPays () . "<br />";
			$etat .= "Hebergement : " . $this -> getHebergement () . "<br />";

			return $etat;

		}

	}

?>