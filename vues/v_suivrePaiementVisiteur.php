 <div id="contenu">
      <h2>Les Visiteurs</h2>
	    <a href="index.php?uc=validerFiche&action=selectionnerMois" >Changer de mois </a>
      <h3>Visiteur  à sélectionner : </h3>
      <form action="index.php?uc=suivrePaiement&action=afficheFiche" method="post">
      <div class="corpsForm">
         
      <p>
	 
        <label for="lstVisiteurs" accesskey="n">Visiteur(s):</label>
        <select id="lstVisiteurs" name="idVisiteur">
            <?php
			foreach ($lesVisiteurs as $unVisiteur)
			{
			    
				$id =  $unVisiteur['id'];
				$nom =  $unVisiteur['nom'];
				$prenom = $unVisiteur['prenom'];
				if($Visiteur == $unVisiteur['id']){
				?>
				<option selected value="<?php echo $id?>"><?php echo  $nom." ". $prenom?> </option>
				<?php 
				}
				else{ ?>
				<option value="<?php echo $id ?>"><?php echo  $nom." ".$prenom ?> </option>
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