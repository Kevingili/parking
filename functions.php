<?php 

//FONCTION POUR MODIFIER L'AFFICHAGE DE LA DATE
function date_maker($baby){

	$babies = explode("-", $baby);
	//Une date est du style Année-Mois-Jour
	$mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
	'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
	echo $babies[2].' '.$mois[$babies[1]-1].' '.$babies[0];
}

//FONCTION POUR SAVOIR SI UNE PLACE EST DISPO
function check_pdispo()
{
	require "inc/config.php";
	$chercher = $bdd->query("SELECT * FROM placeoccupee WHERE statut_place = '0'");
	$chercher->execute();
	
	if (!($cb = $chercher->fetch())) { 
		//Aucun de libre
		return 0;
	}
	else{
		//echo "Place libre";
		return 1;
	}

}
//FONCTION POUR EFFACER LES NOTIFS
function erase_notif($code)
{

	require "inc/config.php";


		$suppnotifs = $bdd->prepare('DELETE FROM notifications WHERE numuser = :numuser');
		$suppnotifs->execute(array('numuser'=>$code));	
		//return 1; //Il occupe une place
	
}

?>