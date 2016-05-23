<?php

	include '_debut.inc.php';

	echo "

		<div style = 'margin-left: 300px; margin-right: 300px;'>

			<form action = 'cConnexion.php' method = 'post'>

			<br /><br /><br /><br />
				
			<center><label><div class = 'moyenTitre'>Connexion</div></label><br /><br /></center>

			<center><label>Nom Utilisateur</label><br />
			<div class='input-group-addon'><span class='glyphicon glyphicon-user'></span></div>
			<input type = 'text' class = 'form-control' name = 'nom'><br /><br /></center>

			<center><label>Mot de Passe</label><br />
			<div class='input-group-addon'><span class='glyphicon glyphicon-edit'></span></div>
			<input type = 'password' class = 'form-control' name = 'motDePasse'><br /><br /></center>

			<center><br /><button type = 'submit' class = 'btn btn-success' value = 'valider' name = 'suscribe'>Se Connecter</button><br />

			</form>

		</div>

	";

?>