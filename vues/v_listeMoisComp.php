<div id="contenu">
      <h2>Les fiches de frais</h2>
	
      <h3>Mois à sélectionner : </h3>
	   
      <form action="index.php?uc=validerFiche&action=selectionnerVisiteur" method="post">
      <div class="corpsForm">
        
      <p>
		 
		
		
		
        <label for="mois" accesskey="n">Mois :</label>
        <select id="mois" name="mois">
            <?php
			foreach ($lesMois as $unMois)
			{
			    $mois = $unMois['mois'];
				echo $numMois ;
				$numAnnee =  $unMois['numAnnee'];
				$numMois =  $unMois['numMois'];
				if($mois == $moisASelectionner){
				?>
				<option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option>
				<?php 
				}
			
			}
           
		   ?>    
            
        </select>
      </p>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>