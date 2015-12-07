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

    if(isset($_POST['listedattente']))
    {
        erase_notif($_POST['client']);
    	$verif = $bdd->query("SELECT * FROM listedattente WHERE codeclient = ".$_POST['client']);
    	if(!($verifs = $verif->fetch()))
    	{
            //ON COMPTE LE NOMBRE DE PERSONNE EN LISTE DATTENTE
	    	$req = $bdd->query("SELECT COUNT(*) AS nbattentes FROM listedattente");
			$occurence = $req->fetch();
			$count = $occurence['nbattentes'];
			$count++;

            //ON AJOUTE UNE PERSONNE EN LISTE DATTENTE
	        $reukette = $bdd->prepare("INSERT INTO listedattente(positionattente, codeclient) VALUES (:position, :code)");
	        $reukette->execute(array(
	        	'position' => $count,
	        	'code'=>$_POST['client'],
	        	))or exit(print_r($reukette->errorInfo()));
	        header('Location:gestion.php');
	    }else header('Location:gestion.php');
    }else header('Location:gestion.php');
?>