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
        <title>Parking - Gestion du Parking</title>
    </head>
    
    <body>
        <div id="bloc_page">
        <?php require "inc/header.php"; ?>

        
        <section>
            <article>
                <h3>Notifications : </h3>
                <?php 

                
                    
                                $check = $bdd->query("SELECT COUNT(*) AS nbnotifss FROM notifications");
                                $raisultat = $check->fetch();
                                $raisultat = $raisultat['nbnotifss'];
                                
                    
                    if($raisultat == 0){ echo '<p>Il n\'y a aucune notifications !</p>'; }
                    if($raisultat > 0)
                    {
                        ?><form action ="gestion.php" method="POST">
                        <input type="submit" name="supp" value="Supprimer toutes les notifications" />
                        </form><?php
                        
                        //BOUTON POUR SUPPRIMER UNE NOTIF
                        if (isset($_POST['supp']))
                        {

                                erase_notif(1);
                                erase_notif(2);
                                erase_notif(3);
                                erase_notif(4);
                                erase_notif(5);
                               
                            
                        }

                        $check->closeCursor();
                        //ON VERIFIE LES NOTIFS
                        $check = $bdd->query("SELECT * FROM notifications ORDER BY datenotif DESC");
                        while ($notifs = $check->fetch()) 
                        {
                            $users = $bdd->prepare('SELECT nomutil, prenomutil FROM utilisateurs WHERE numutil = :num');
                            $users->execute(array('num'=>$notifs['numuser'],))or exit(print_r($users->errorInfo()));
                            $userfound = $users->fetch();
                            $client = $notifs['numuser'];
                            

                        ?>

                        <p><strong><?php date_maker($notifs['datenotif']); ?></strong> : <?php echo $userfound['nomutil'].' '.$userfound['prenomutil'];?> voudrait une place pour une durée de <strong><?php echo $notifs['nbjours']; ?> jours</strong>. 
                            <?php 
                                if (check_pdispo() == 0) { ?>
                                    <form action ="listedattente.php" method="POST">
                                        <input type="submit" name="listedattente" value="Placer en liste d'attente" />
                                        <input type="hidden" name="client" value="<?php echo $client; ?>" />
                                    </form><br/>
                                    <?php
                                }else{ ?>
                                    <a href="attrib_place.php?client=<?php echo $client; ?>&nbjours=<?php echo $notifs['nbjours']; ?>">Attribuer une place</a><br/>
                                    <?php
                                }
                            ?>    
                        </p>

                        <?php
                            }
    
                    }

                ?>
                <hr/>
                <h3>Places de Parking : </h3>
                <table border="3">
                    <tr>
                        <th>Numéro de la place</th>
                        <th>Date de Début</th>
                        <th>Date de Fin</th>
                        <th>Statut de la Place</th>
                        <th>Occupée par</th>
                    </tr>
                    <?php 
          
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
                        //SAVOIR SI UNE PLACE EST DISPO
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
            <hr/>
            <h3>Liste d'attentes :</h3>
            <table border="3">
                <tr>
                        <th>Position dans la file</th>
                        <th>Utilisateur</th>
                    </tr>
            <?php 
          
              $attente = $bdd->query('SELECT * FROM listedattente');
              
              while ($attentes = $attente->fetch()) 
              {
                    
            ?>
                <tr>
                    <td><strong><?php if($attentes['positionattente'] == 1){echo $attentes['positionattente'].'er';}else echo $attentes['positionattente'].'ème'; ?></strong></td>
                    <td>
                        <?php //AFFICHAGE DE LA LISTE D'ATTENTE
                                $who = $bdd->query('SELECT nomutil, prenomutil FROM utilisateurs WHERE numutil = '.$attentes['codeclient']);
                                if($who){
                                $whos = $who->fetch();
                                echo $whos['nomutil'].' '.$whos['prenomutil'];
                                }else { echo "-"; } 
                            ?>
                    </td>
                </tr>
            <?php } ?>
            </table>
            </article>
            
        </section>

        <?php  require "inc/footer.php";?>
        </div>
    </body>
</html>
