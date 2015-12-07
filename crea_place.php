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

    if (isset($_POST['creer'])) {
        //ON COMPTE LE NOMBRE DE PLACE
        $cbdeplaces = $bdd->query("SELECT COUNT(*) AS nbdeplaces FROM placeparking");
        $count = $cbdeplaces->fetch();
        $num = $count['nbdeplaces'];

        $num++;//ON INCREMENTE LE NOMBRE DE PLACE

        //ON RAJOUTE LA PLACE DANS LA TABLE
        $sql = $bdd->prepare('INSERT INTO placeparking(numplace, datedebut, echeance) VALUES (:num, :datedebut, :echeance)');
        $sql->execute(array(
                'num'=>$num,
                'datedebut'=>'0000-00-00',
                'echeance'=>'0000-00-00',
            ))or exit(print_r($sql->errorInfo()));
        $null = 'NULL';
        $reukette = $bdd->prepare('INSERT INTO placeoccupee(numoccupee, statut_place, codeclient) VALUES (:num, :stat, :code)');
        $reukette->bindValue(':num', $num, PDO::PARAM_INT);
        $reukette->bindValue(':stat', 0, PDO::PARAM_INT);
        $reukette->bindValue(':code', null, PDO::PARAM_INT);

        $reukette->execute()or exit(print_r($reukette->errorInfo()));
        
        $erreur = "<strong>Nouvelle place créee</strong><br/><br/>";
        $sql->closeCursor();
        $reukette->closeCursor();
        header('Location:parking.php');
    }else header('Location:accueil.php');
    
?>