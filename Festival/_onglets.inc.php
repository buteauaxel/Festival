<!-- Barre de navigation de la page -->

<?php

    $URL = $_SERVER ["PHP_SELF"] . "?" . $_SERVER ["QUERY_STRING"];

    function construireMenu ($nom, $adr, $i) {
        
        global $URL;

        if (($adr != "") && (strpos ($URL, $adr))) {
            
            if ($i == 1) {
                echo "<li class = 'ongletOuvertPrem'>" . $nom . "</li>";
            } else {
                echo "<li class = 'ongletOuvert'>" . $nom . "</li>";
            }
            
        } else {
            
            if ($i == 1) {
                echo "<li class = 'ongletPrem'><a href = '" . $adr . "'>" . $nom . "</a></li>";
            } else {
                echo "<li class = 'onglet'><a href = '" . $adr . "'>" . $nom . "</a></li>";
            }

        }
    }

?>