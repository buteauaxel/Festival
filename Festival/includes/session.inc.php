<?php

	session_start ();	

	if (!isset ($_SESSION ['nom'])) {
		$_SESSION ['nom'] = 'invité';
	}

	if (!isset ($_SESSION ['organisation'])) {
		$_SESSION ['organisation'] = null;
	}

	if (!isset ($_SESSION ['privilèges'])) {
		$_SESSION ['privilèges'] = 'invité';
	}
	
?>