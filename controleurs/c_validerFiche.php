<?php
 

$action = $_REQUEST['action'];

$mois = getMois(date("d/m/Y"));
//$numAnnee = substr($mois, 0, 4);
//$numMois = substr($mois, 4, 2);
include("vues/v_sommaire_comp.php");
switch($action){

		
	case 'selectionnerMois':{
		
		
		$lesMois=$pdo->getLesMoisAValider();
		include("vues/v_listeMoisComp.php");
		break;
	}
	
	case 'selectionnerVisiteur' :{
		
		$mois = $_POST['mois'];
		// $_SESSION ['mois'] = $mois;
		//$mois = $_REQUEST['mois'];
		$lesVisiteurs = $pdo->getInfosVisiteurMois($mois) ;
			include("vues/v_listeVisiteurComp.php");
		break;
	
		
	}
		




}







?>