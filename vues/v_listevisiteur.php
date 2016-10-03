
 <div id="contenu">
    <h2>Valider fiche frais </h2>
    <h3>Visiteurs et mois à sélectionner : </h3>
    <form action="index.php?uc=validerfichefrais&action=fiche" method="post">

        <div class="corpsForm">

            <p>
                <label for="lstVisiteurs" accesskey="n">sélectionner votre visiteur: </label>
                <select id="lstVisiteurs" name="lstVisiteurs">
                    <?php
                    foreach ($lesVisiteurs as $Visiteur) {
                        $id = $Visiteur['id'];
                        $prenom = $Visiteur['prenom'];
                        $nom = $Visiteur['nom'];
                        if ($Visiteur == $Visiteur['id']) {
                            ?>                     
                            <option selected value="<?php echo $id ?>"><?php echo $nom . " " . $prenom ?></option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $id ?>"><?php echo $nom . " " . $prenom ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </p>
            
            
            
        </div>
        <div class="piedForm">
            <p>
                <input id="ok" type="submit" value="Valider"/>
                <input id="annuler" type="reset" value="Effacer"/>
            </p> 

        </div>

    </form>