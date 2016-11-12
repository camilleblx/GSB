

<?php

$action = $_REQUEST['action'];


include("vues/v_sommaire_comp.php");
switch ($action) {


    case 'selectionnerMois': {


            $lesMois = $pdo->getLesMoisAPayer();
            include("vues/v_suivrePaiementMois.php");
            break;
        }

    case 'selectionnerVisiteur' : {
            $mois = $_POST['mois'];
            $_SESSION['mois'] = $mois;
            $lesVisiteurs = $pdo->getInfosVisiteursAPayer($mois);
            include("vues/v_suivrePaiementVisiteur.php");
            break;
        }

    case 'afficheFiche' : {
            /* $mois = $_POST['mois'];
              $idVisiteur = $_POST['idVisiteur'];
              $lesVisiteurs = $pdo->getInfosVisiteurMois($mois) ;
              $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
              $lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
              $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$mois); */


            $idVisiteur = $_POST['idVisiteur'];
            $_SESSION['idVisiteur'] = $idVisiteur;
            $mois = $_SESSION['mois'];
            $_SESSION['mois'] = $mois;
            $lesVisiteurs = $pdo->getInfosVisiteursAValider($mois);

            /* $visiteur = $pdo->getLeVisiteur($idVisiteur);
              $nom = $visiteur['nom'];
              $prenom = $visiteur['prenom']; */
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

            include("vues/v_suivrePaiement.php");
            break;
        }

    case 'payer' : {

            $mois = $_SESSION['mois'];
            $idVisiteur = $_SESSION['idVisiteur'];
            $pdo->payerFiche($idVisiteur,$mois);


            include("vues/v_modification.php");
            break;
        }
      
        
        
        
        
}
?>