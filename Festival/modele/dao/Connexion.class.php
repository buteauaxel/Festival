<?php

	namespace modele\dao;
	use \PDO;

	/* 

		Pour le déploiement

		define ("DataSourceName", "mysql:host=;dbname=festival;charset=utf8");
		define ("Utilisateur", "root");
		define ("MotDePasse", "joliverie");

	*/

	/*

		Pour le développement */

		define("DataSourceName", "mysql:host=;dbname=abuteau_festival;charset=utf8");
		define("Utilisateur", "root");
		define("MotDePasse", "joliverie");

	/**/

	class Connexion {

		private static $PHPDataObject, $etat;

	    public static function seConnecter () {

            self:: $PHPDataObject = new PDO (DataSourceName, Utilisateur, MotDePasse);
	        self:: $PHPDataObject -> setAttribute (PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
	        self:: $PHPDataObject -> query ("SET NAMES UTF8");

	        return self:: $PHPDataObject;

	    }

	    public static function seDeconnecter () {
	        self:: $PHPDataObject = null;
	    }

	    public static function getPDO () {
	        return self:: $PHPDataObject ;
	    }

	}

?>