<?php

	include "_debut.inc.php";

	session_unset ();
	session_destroy ();
	
	echo "Déconnexion réussie !";

	header ("refresh:3; index.php");

?>