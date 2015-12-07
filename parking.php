<?php

    require ("inc/config.php"); #Connexion a la base (inclusion de la connexion par CLASSE PDO:Statement)
    require 'functions.php';
    session_start();
    if (!isset($_SESSION['numutil']) ){
        header('Location:index.php');
    }
    if ($_SESSION['admin'] != 1) {
        header('Location:accueil.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Parking - Le Parking</title>
    </head>
    
    <body>
        <div id="bloc_page">
        <?php require "inc/header.php"; ?>

        
        <section>
            <article>
                
                <h3>Option du Parking</h3>
                
                <form action="crea_place.php" method="POST"><input type="submit" name="creer" class="btn" value="Créer"/></form>

                <hr/>
                <h3>Places de Parking : </h3>
                <table border="3">
                    <tr>
                        <th>Numéro</th>
                        <th>Date de Début</th>
                        <th>Date de Fin</th>
                        <th>Statut de la Place</th>
                        <th>Occupée par</th>
                    </tr>
                    <?php 
                    //ON AFFICHE LES PLACES DE PARKING
                      $parking = $bdd->query('SELECT * FROM placeparking');
                      //$elementpres = $presta->fetch();
                      while ($places = $parking->fetch()) 
                      {
                      
                    ?>
                    <tr>

                        <td><?php echo $places['numplace']; ?></td>
                        <td>
                            <?php 
                            if($places['datedebut'] == '0000-00-00'){
                                echo "-";
                                }else { date_maker($places['datedebut']); }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if($places['echeance'] == '0000-00-00'){
                                echo "-";
                                }else { echo date_maker($places['echeance']); }
                            ?>
                        </td>
                        
                        <?php  
                            $busy = $bdd->query('SELECT * FROM placeoccupee WHERE numoccupee = '.$places['numplace']);
                            while ($busies = $busy->fetch()) {
                         ?>
                        <td><?php 
                                if($busies['statut_place'] == 0) 
                                    echo 'Libre';
                                else
                                    echo 'Occupée';
                                 ?></td>
                        <td>
                            <?php 
                                $who = $bdd->query('SELECT nomutil FROM utilisateurs WHERE numutil = '.$busies['codeclient']);
                                if($who){
                                $whos = $who->fetch();
                                echo $whos['nomutil'];
                                }else { echo "-"; } 
                            ?>
                        </td>
                        <?php } ?>
                    </tr>
                <?php 
                 } ?>
            </table>
            </article>
            <aside>
                <form action="supp_place.php" method="POST">
                    <h3>Supprimer une place</h3>
                    <?php 
                    //ON SUPPRIME UNE PLACE DE PARKING
                        $reukette = $bdd->query("SELECT numplace FROM placeparking");
                        echo "<select name ='placepark'>";
                        while ($donnees = $reukette->fetch()) {
                             echo "<option>".$donnees['numplace'];
                         } 
                        echo "</select><br/><br/>"; 
                    ?>
                    <input type="submit" name="supprimer" value="supprimer"/>
                </form>
            </aside>
        </section>
        <?php  require "inc/footer.php";?>
        </div>
    </body>
</html>
