<?php

/**
 * Classe d'accès aux données. 

 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe

 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */
class PdoGsb {

    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=gkaya';
    private static $user = 'gkaya';
    private static $mdp = 'thoa7AeL';
    private static $monPdo;
    private static $monPdoGsb = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct() {
        PdoGsb::$monPdo = new PDO(PdoGsb::$serveur . ';' . PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
        PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
    }

    public function _destruct() {
        PdoGsb::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe

     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();

     * @return l'unique objet de la classe PdoGsb
     */
    public static function getPdoGsb() {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
        }
        return PdoGsb::$monPdoGsb;
    }

    /**
     * Retourne les informations d'un visiteur

     * @param $login 
     * @param $mdp
     * @return l'id, le nom et le prénom sous la forme d'un tableau associatif 
     */
    public function getInfosVisiteur($login, $mdp) {

        $req = "select visiteur.comp as comp , visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom from visiteur 
			where visiteur.login='$login' and visiteur.mdp=md5('$mdp') ";
        $rs = PdoGsb::$monPdo->query($req);
        $ligne = $rs->fetch();
        return $ligne;
    }
    /**
     * selectionne tout les visiteurs
     * @param type $idVisiteur
     * @return infos visiteur
     */
    public function getLeVisiteur($idVisiteur) {
        $req = "select * from visiteur where id ='$idVisiteur'";
        $resultat = PdoGsb::$monPdo->query($req);
        $fetch = $resultat->fetch();
        return $fetch;
    }

    /**
     * Retourne les informations d'un visiteur selon un mois selectionner

     * @param $mois 

     * @return le nom et le prenom 
     */
    public function getInfosVisiteurMois($mois) {
        $req = "select id , visiteur.nom , visiteur.prenom  from visiteur join fichefrais
			where  fichefrais.mois ='$mois' and comp =0 and idVisiteur = id";

        $rs = PdoGsb::$monPdo->query($req);
        $lesVisiteurs = array();
        $ligne = $rs->fetch();
        while ($ligne != null) {
            $id = $ligne['id'];
            $nom = $ligne['nom'];
            $prenom = $ligne['prenom'];

            $lesVisiteurs["$id"] = array(
                "id" => "$id",
                "nom" => "$nom",
                "prenom" => "$prenom"
            );
            $ligne = $rs->fetch();
        }
        return $lesVisiteurs;
    }
    /**
     *  selectionne les visiteurs qui ont une fiche en attente de validation
     * @param type $mois
     * @return id , nom , prenom
     */
    public function getInfosVisiteursAValider($mois) {
        $req = "SELECT id,nom as nom, prenom as prenom from fichefrais join visiteur  where idVisiteur = visiteur.id and mois ='$mois' and idetat = 'cl'";
        $res = PdoGsb::$monPdo->query($req);
        $lesVisiteursAValider = array();
        $laLigne = $res->fetch();
        while ($laLigne != null) {
            $id = $laLigne['id'];
            $nom = $laLigne['nom'];
            $prenom = $laLigne['prenom'];
            $lesVisiteursAValider["$id"] = array(
                "id" => "$id",
                "nom" => "$nom",
                "prenom" => "$prenom"
            );
            $laLigne = $res->fetch();
        }
        return $lesVisiteursAValider;
    }
    /**
     * selectionne les visiteurs qui ont une fiche en �tat VA
     * @param type $mois
     * @return type
     */
    public function getInfosVisiteursAPayer($mois) {
        $req = "SELECT id,nom as nom, prenom as prenom from fichefrais join visiteur  where idVisiteur = visiteur.id and mois ='$mois' and idEtat = 'VA'";
        $res = PdoGsb::$monPdo->query($req);
        $lesVisiteursAValider = array();
        $laLigne = $res->fetch();
        while ($laLigne != null) {
            $id = $laLigne['id'];
            $nom = $laLigne['nom'];
            $prenom = $laLigne['prenom'];
            $lesVisiteursAValider["$id"] = array(
                "id" => "$id",
                "nom" => "$nom",
                "prenom" => "$prenom"
            );
            $laLigne = $res->fetch();
        }
        return $lesVisiteursAValider;
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait
     * concernées par les deux arguments

     * La boucle foreach ne peut être utilisée ici car on procède
     * à une modification de la structure itérée - transformation du champ date-

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
     */
    public function getLesFraisHorsForfait($idVisiteur, $mois) {
        $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idvisiteur ='$idVisiteur' 
			and lignefraishorsforfait.mois = '$mois' ";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        $nbLignes = count($lesLignes);
        for ($i = 0; $i < $nbLignes; $i++) {
            $date = $lesLignes[$i]['date'];
            $lesLignes[$i]['date'] = dateAnglaisVersFrancais($date);
        }
        return $lesLignes;
    }

    /**
     * Retourne le nombre de justificatif d'un visiteur pour un mois donné

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @return le nombre entier de justificatifs 
     */
    public function getNbjustificatifs($idVisiteur, $mois) {
        $req = "select fichefrais.nbjustificatifs as nb from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        return $laLigne['nb'];
    }

    /**
     * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
     * concernées par les deux arguments

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
     */
    public function getLesFraisForfait($idVisiteur, $mois) {
        $req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, 
			lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait 
			on fraisforfait.id = lignefraisforfait.idfraisforfait
			where lignefraisforfait.idvisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois' 
			order by lignefraisforfait.idfraisforfait";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }

    /**
     * Retourne tous les id de la table FraisForfait

     * @return un tableau associatif 
     */
    public function getLesIdFrais() {
        $req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }

    /**
     * Met à jour la table ligneFraisForfait

     * Met à jour la table ligneFraisForfait pour un visiteur et
     * un mois donné en enregistrant les nouveaux montants

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
     * @return un tableau associatif 
     */
    public function majFraisForfait($idVisiteur, $mois, $lesFrais) {
        $lesCles = array_keys($lesFrais);
        foreach ($lesCles as $unIdFrais) {
            $qte = $lesFrais[$unIdFrais];
            $req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
				where lignefraisforfait.idvisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
				and lignefraisforfait.idfraisforfait = '$unIdFrais'";
            PdoGsb::$monPdo->exec($req);
        }
    }
    /**
     * Refuse un frais hor forfait en mettant 'REFUSER' devant le libelle de frais
     * @param type $id
     * @param type $libelle
     */
    public function refusFraisHorsForfait($id, $libelle) {
        $req = "update lignefraishorsforfait set libelle = concat(' REFUSE  ','$libelle') where id = '$id'";
        PdoGsb::$monPdo->exec($req);
    }
    /**
     * reporte une fiche au mois suivant
     * @param type $moisSuivant
     * @param type $idVisiteur
     * @param type $id
     */
    public function reportFraisHorsForfait($moisSuivant, $idVisiteur, $id) {
        $req = "update lignefraishorsforfait set mois ='$moisSuivant' where idVisiteur='$idVisiteur' and id ='$id'";
        PdoGsb::$monPdo->exec($req);
    }
    /**
     * Met une fiche frais en �tat valider
     * @param type $idVisiteur
     * @param type $mois
     * @param type $montantTotal
     * 
     */
    public function validerFicheFrais($idVisiteur, $mois, $montantTotal) {
        $req = "update fichefrais set idEtat = 'VA', montantValide = '$montantTotal', datemodif= now() where idVisiteur = '$idVisiteur' and mois ='$mois' ";
        //echo $req;
        PdoGsb::$monPdo->exec($req);
    }

    /**
     *  Calcul le montant des frais HF puis additionne au total du montant forfait
     * @param type $idVisiteur
     * @param type $mois
     * @return le montant
     */
    public function montantTotal($idVisiteur, $mois) {
        $req = "select sum(montant) as montantTotalHF from lignefraishorsforfait  where idVisiteur='$idVisiteur' and mois='$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $montantHF = $res->fetch();
        $req = "select SUM(montant * quantite) as montantFraisForfait from fraisforfait inner join lignefraisforfait on fraisforfait.id = lignefraisforfait.idfraisforfait where idVisiteur = '$idVisiteur' and mois ='$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $montantForfait = $res->fetch();
        $montantTotal = $montantHF['montantTotalHF'] + $montantForfait['montantFraisForfait'];
        return $montantTotal;
    }
    /**
     * Met une fiche valider en �tat MP
     * @param type $idVisiteur
     * @param type $mois
     */
    public function payerFiche($idVisiteur, $mois) {
        $req = "update fichefrais set idEtat = 'MP',datemodif= now() where idVisiteur = '$idVisiteur' and mois = '$mois'";
        //echo $req;
        PdoGsb::$monPdo->exec($req);
    }

    /**
     *      
     * met à jour le nombre de justificatifs de la table ficheFrais
     * pour le mois et le visiteur concerné

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     */
    public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs) {
        $req = "update fichefrais set nbjustificatifs = $nbJustificatifs 
			where fichefrais.idvisiteur = '$idVisiteur' and fichefrais.mois = '$mois'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Teste si un visiteur possède une fiche de frais pour le mois passé en argument

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @return vrai ou faux 
     */
    public function estPremierFraisMois($idVisiteur, $mois) {
        $ok = false;
        $req = "select count(*) as nblignesfrais from fichefrais 
			where fichefrais.mois = '$mois' and fichefrais.idvisiteur = '$idVisiteur'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        if ($laLigne['nblignesfrais'] == 0) {
            $ok = true;
        }
        return $ok;
    }

    /**
     * Retourne le dernier mois en cours d'un visiteur

     * @param $idVisiteur 
     * @return le mois sous la forme aaaamm
     */
    public function dernierMoisSaisi($idVisiteur) {
        $req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = '$idVisiteur'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        $dernierMois = $laLigne['dernierMois'];
        return $dernierMois;
    }

    /**
     * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés

     * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
     * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     */
    public function creeNouvellesLignesFrais($idVisiteur, $mois) {
        $dernierMois = $this->dernierMoisSaisi($idVisiteur);
        $laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur, $dernierMois);
        if ($laDerniereFiche['idEtat'] == 'CR') {
            $this->majEtatFicheFrais($idVisiteur, $dernierMois, 'CL');
        }
        $req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
			values('$idVisiteur','$mois',0,0,now(),'CR') where comp=0 ";
        PdoGsb::$monPdo->exec($req);
        $lesIdFrais = $this->getLesIdFrais();
        foreach ($lesIdFrais as $uneLigneIdFrais) {
            $unIdFrais = $uneLigneIdFrais['idfrais'];
            $req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
				values('$idVisiteur','$mois','$unIdFrais',0)";
            PdoGsb::$monPdo->exec($req);
        }
    }

    /**
     * Cree un nouveau frais hors forfait pour un visiteur un mois donné
     * à partir des informations fournies en paramètre

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @param $libelle : le libelle du frais
     * @param $date : la date du frais au format français jj//mm/aaaa
     * @param $montant : le montant
     */
    public function creeNouveauFraisHorsForfait($idVisiteur, $mois, $libelle, $date, $montant) {
        $dateFr = dateFrancaisVersAnglais($date);
        $req = "insert into lignefraishorsforfait 
			values('','$idVisiteur','$mois','$libelle','$dateFr','$montant')";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Supprime le frais hors forfait dont l'id est passé en argument

     * @param $idFrais 
     */
    public function supprimerFraisHorsForfait($idFrais) {
        $req = "delete from lignefraishorsforfait where lignefraishorsforfait.id =$idFrais ";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Retourne les mois pour lesquel un visiteur a une fiche de frais

     * @param $idVisiteur 
     * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
     */
    public function getLesMoisDisponibles($idVisiteur) {
        $req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' 
			order by fichefrais.mois desc ";
        $res = PdoGsb::$monPdo->query($req);
        $lesMois = array();
        $laLigne = $res->fetch();
        while ($laLigne != null) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois["$mois"] = array(
                "mois" => "$mois",
                "numAnnee" => "$numAnnee",
                "numMois" => "$numMois"
            );
            $laLigne = $res->fetch();
        }
        return $lesMois;
    }

    /**
     * Retourne les mois pour lesquel un visiteur a une fiche de frais à valider (CR)


     * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
     */
    public function getLesMoisAValider() {
        $req = "select fichefrais.mois from  fichefrais where idEtat = 'CL' 
			order by fichefrais.mois desc ";
        $res = PdoGsb::$monPdo->query($req);
        $lesMois = array();
        $laLigne = $res->fetch();
        while ($laLigne != null) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois["$mois"] = array(
                "mois" => "$mois",
                "numAnnee" => "$numAnnee",
                "numMois" => "$numMois"
            );
            $laLigne = $res->fetch();
        }
        return $lesMois;
    }
    /**
     * retourne les �ois sui sont en �tat valider et pr�t � �tre payer
     * @return les mois en question
     */
    public function getLesMoisAPayer() {
        $req = "select fichefrais.mois from  fichefrais where idEtat = 'VA' 
			order by fichefrais.mois desc ";
        $res = PdoGsb::$monPdo->query($req);
        $lesMois = array();
        $laLigne = $res->fetch();
        while ($laLigne != null) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois["$mois"] = array(
                "mois" => "$mois",
                "numAnnee" => "$numAnnee",
                "numMois" => "$numMois"
            );
            $laLigne = $res->fetch();
        }
        return $lesMois;
    }

    /**
     * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné

     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
     */
    public function getLesInfosFicheFrais($idVisiteur, $mois) {
        $req = "select fichefrais.idEtat as idEtat, fichefrais.dateModif as dateModif, fichefrais.nbJustificatifs as nbJustificatifs, 
				fichefrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join etat on fichefrais.idEtat = etat.id 
				where fichefrais.idVisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        return $laLigne;
    }

    /*  public function getMoisSuivant ($annee ,$mois){

      $mois = $mois+1 ;

      if ($mois = 12 ){
      $annee = $annee +1 ;
      $mois = '01';

      }

      } */

    /**
     * Modifie l'�tat et la date de modification d'une fiche de frais

     * Modifie le champ idEtat et met la date de modif � aujourd'hui
     * @param $idVisiteur 
     * @param $mois sous la forme aaaamm
     */
    public function majEtatFicheFrais($idVisiteur, $mois, $etat) {
        $req = "update ficheFrais set idEtat = '$etat', dateModif = now() 
			where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
        PdoGsb::$monPdo->exec($req);
    }

}
?>