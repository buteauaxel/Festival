<?php

	include "_debut.inc.php";

	echo "

		<form action = 'cAjouterOffreHebergement.php' method = 'post'>

			ID : <input type = 'text' name = 'IDEtablissement'>
			ID Type Chambre : <input type = 'text' name = 'IDTypeChambre'>
			Nombre Chambre : <input type = 'text' name = 'nombreChambre'>

			<input type = 'submit' value = 'Valider'>

		</form>

	";

?>