

 <?php
 

$action = $_REQUEST['action'];


include("vues/v_sommaire_comp.php");
switch($action){

		
	case 'selectionnerMois':{
		
		
		$lesMois=$pdo->getLesMoisAValider();
		include("vues/v_listeMoisComp.php");
		break;
	}
	
	case 'selectionnerVisiteur' :{
		  $mois = $_POST['mois'];
		$lesVisiteurs = $pdo->getInfosVisiteurMois($mois) ;
		include("vues/v_listeVisiteursMois.php");
		break;
		
	}
	case 'afficheFiche' :{
		$mois = $_SESSION['mois'];
		$id = $_POST['id'];
		$LesFiches = $pdo->getLesFraisForfait($id, $mois);
		
	}	




}







?>