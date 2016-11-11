

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
		  $_SESSION['mois'] = $mois;
		$lesVisiteurs = $pdo->getInfosVisiteurMois($mois) ;
		include("vues/v_listeVisiteursMois.php");
		break;
		
	}
	
	case 'afficheFiche' :{
		/*$mois = $_POST['mois'];
		$idVisiteur = $_POST['idVisiteur'];
		$lesVisiteurs = $pdo->getInfosVisiteurMois($mois) ;
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$mois);*/
		
                
                 $idVisiteur = $_POST['idVisiteur'];
                $_SESSION['idVisiteur'] = $idVisiteur;
                $mois = $_SESSION['mois'];
               $_SESSION['mois'] = $mois;
                $lesVisiteurs = $pdo->getInfosVisiteursAValider($mois);
                
               /* $visiteur = $pdo->getLeVisiteur($idVisiteur);
                $nom = $visiteur['nom'];
                $prenom = $visiteur['prenom'];*/
                $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
                $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
                $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $mois);
                
                $numAnnee = substr($mois, 0, 4);
                $numMois = substr($mois, 4, 2);
              // $libetat = $lesInfosFicheFrais['libetat'];
                $montantvalide = $lesInfosFicheFrais['montantValide'];
                $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
               $dateModif = $lesInfosFicheFrais['dateModif'];
                $dateModif = dateAnglaisVersFrancais($dateModif);
                
		include("vues/v_afficheFiche.php");
		break;
	}	




}







?>