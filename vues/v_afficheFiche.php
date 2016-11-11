<div id="contenu">
    <a href="index.php?uc=validerFiche&action=selectionnerMois" >Changer de mois </a></br>
      
<h3>Fiche de frais du mois <?php echo $numMois . "-" . $numAnnee ?> :
</h3>


    <table class="listeLegere">
        <caption>Elements forfaitises </caption>
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $libelle = $unFraisForfait['libelle'];
                ?>	
                <th> <?php echo $libelle ?></th>
                <?php
            }
            ?>
        </tr>
        <tr>
            <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $quantite = $unFraisForfait['quantite'];
                ?>
                <td class="qteForfait"><?php echo $quantite ?> </td>
                <?php
            }
            ?>
        </tr>
    </table>
    <table class="listeLegere">
        <caption>Descriptif des elements hors forfait -<?php echo $nbJustificatifs ?> justificatifs recus -
        </caption>
        <tr>
            <th class="date">Date</th>
            <th class="libelle">Libelle</th>
            <th class='montant'>Montant</th>                
        </tr>
<?php
foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
    $date = $unFraisHorsForfait['date'];
    $libelle = $unFraisHorsForfait['libelle'];
    $montant = $unFraisHorsForfait['montant'];
    ?>
            <tr>
                <td><?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
            </tr>
    <?php
}
?>
    </table>
</div>
</div>















