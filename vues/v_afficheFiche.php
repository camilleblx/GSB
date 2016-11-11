<div id="contenu">
    <a href="index.php?uc=validerFiche&action=selectionnerMois" >Changer de mois </a></br>

    <h3>Fiche de frais du mois <?php echo $numMois . "-" . $numAnnee ?> :
    </h3>
    <form method="POST" action="index.php?uc=validerFiche&action=modifFrais"> 

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
                    $idfrais = $unFraisForfait['idfrais'];
                    ?>
                    <td class="qteForfait"><input type="text" size="10" maxlength="5" name="lesFrais[<?php echo $idfrais ?>]" value="<?php echo $quantite ?> "></td>

                    <?php
                }
                ?> 
            </tr>
        </table><input type="submit" value="Modifier" >
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
                $id = $unFraisHorsForfait['id'];
                ?>
                <tr>
                    <td><?php echo $date ?></td>
                    <td><?php echo $libelle ?></td>
                    <td><?php echo $montant ?></td>
                     <td><a href="index.php?uc=validerFiche&action=refusFrais&id=<?php echo $id;?>&libelle=<?php echo $libelle;?>">Refuser</a></td>
                     <td><a href="index.php?uc=validerFiche&action=reporterFrais&id=<?php echo $id;?>">Reporter</a></td>
                      <td><a href="index.php?uc=validerFiche&action=validerFrais&id=<?php echo $id;?>">Valider</a></td>
                </tr>
                <?php
            }
            ?>
        </table></form>
</div>
</div>















