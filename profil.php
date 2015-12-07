<?php

    require ("inc/config.php"); #Connexion a la base (inclusion de la connexion par CLASSE PDO:Statement)
    require 'functions.php';
    session_start();
    if (!isset($_SESSION['numutil']) ){
        header('Location:index.php');
    }
    if ($_SESSION['admin'] != 0) {
        header('Location:accueil.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Parking - Profil</title>
    </head>
    
    <body>
        <div id="bloc_page">
        <?php require "inc/header.php"; ?>

        
        <section>
            
            <article>
                <p>Affichage des informations de l'utilisateur</p>
                <?php

                //ON REGARDE SI LUTILSATEUR A UNE PLACE DE PARKING
                $trouve = false;
                $num = $_SESSION['numutil'];
                                $req = $bdd->query('SELECT * FROM placeoccupee');
                                while($donnees = $req->fetch())
                                {
                                    if($donnees['codeclient'] == $num)
                                    {
                                        $trouve = true;
                                        if ($trouve == true)
                                            echo 'Votre numéro de place de parking est '.$donnees['numoccupee'];
                                    }
                                }

                                //ON REGARDE SI LUTILISATEUR EST SUR LISTE DATTENTE
                if ($trouve == false)
                    echo "Vous n'avez pas de place de parking attribuée";
                ?> <br /><br /><br /> <?php
                $trouve = false;
                $num = $_SESSION['numutil'];
                                $req = $bdd->query('SELECT * FROM listedattente');
                                while($donnees = $req->fetch())
                                {
                                    if($donnees['codeclient'] == $num)
                                    {
                                        $trouve = true;
                                        if ($trouve == true)
                                            echo 'Votre numéro dans la liste d\'attente est'.$donnees['numoccupee'];
                                    }
                                }

                if ($trouve == false)
                    echo "Vous n'êtes pas dans la liste d'attente.";




                ?>
            </article>
            <aside>
                <p>
                    <?php echo '<strong>'.$_SESSION['nomutil'].'</strong>'; ?>&nbsp;
                    <?php 
                        echo '<strong>'.$_SESSION['prenomutil'].'</strong><br/>';
                        echo " Inscrit depuis le ";
                        date_maker($_SESSION['dateinscription']);
                        echo '<br/>' ;
                        if ($_SESSION['admin']==1) {
                            echo "Statut : Administrateur";
                        }else echo "Statut : Utilisateur standard";

                    ?>
                    <br/><a href="modif_motdepasse.php">Rectifier son mot de passe</a>
                </p>
            </aside>
        </section>

        <?php  require "inc/footer.php";?>
        </div>
    </body>
</html>
