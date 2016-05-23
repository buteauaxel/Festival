<?php

	namespace modele\metier;

	class TypeChambre {

		private $id, $libelle;

		public function __construct ($id, $libelle) {

			$this -> ID = $id;
			$this -> libelle = $libelle;

		}

		public function getID () {
			return $this -> ID;
		}

		public function getLibelle () {
			return $this -> libelle;
		}

		public function setID ($id) {
			$this -> ID = $id;
		}

		public function setLibelle ($libelle) {
			$this -> libelle = $libelle;
		}

		public function __toString () {

			$etat = "ID : " . $this -> getID () . "<br />";
			$etat .= "Libelle : " . $this -> getLibelle () . "<br />";

			return $etat;

		}

	}

?>