<!DOCTYPE HTML>

<html lang = 'FR'>

    <head>

        <title>Festival</title>
        <meta charset = "UTF-8">
        <link href = 'bootStrap/css/bootstrap.min.css' rel = 'stylesheet'>
        <link href = 'design/styleSheet.css' rel = 'stylesheet' type = 'text/css'>
        <link href = 'https://fonts.googleapis.com/css?family=Architects+Daughter' rel = 'stylesheet' type = 'text/css'>
        <link rel = 'stylesheet' href = 'design/carousel.css'/>
        <script src = 'ism/js/ism-2.1.js'></script>

    </head>

    <body class = 'basePage'>

        <?php

            include 'includes/session.inc.php';

            if ($_SESSION ['nom'] == 'invité') {

                echo "

                    <form action = 'connexion.php' method = 'post'>
                        <input type = 'submit' class = 'btn btn-info' value = 'Se Connecter'>
                    </form>

                ";

            } else {

                echo "

                    <form action = 'cDeconnexion.php' method = 'post'>
                        <input type = 'submit' class = 'btn btn-danger' value = 'Se Déconnecter'>&nbsp;&nbsp;&nbsp;" . $_SESSION ['nom'] . "
                    </form>

                ";

            }

        ?>

        <div class = 'grosTitre'>Festival Folklores du Monde</div>
        <center><div class = 'petitTitre'>Hébergement des groupes</div></center>

        <br />

        <?php include '_onglets.inc.php'; ?>

            <div id = 'barreMenus'>

                <ul class = 'menus'>

                    <?php

                        construireMenu ('Accueil', 'index.php', 1);
                        construireMenu ('Gestion établissements', 'cGestionEtablissements.php', 2);
                        construireMenu ('Gestion types chambres', 'cGestionTypesChambres.php', 3);
                        construireMenu ('Offre hébergement', 'cOffreHebergement.php', 4);
                        construireMenu ('Attribution chambres', 'cAttributionChambres.php', 5);

                    ?>

                </ul>

            </div>

            <div class = 'page'>