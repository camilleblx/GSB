<!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2>
    
</h2>
    
      </div>  
        <ul id="menuList">
			<li >
				  Comptable :<br> 
                            
                            
				<?php echo $_SESSION['prenom']."  ".$_SESSION['nom']  ?>
			</li>
           <li class="smenu">
              <a href="index.php?uc=etatFrais&action=saisirFrais" title="Fiche de frais à valider ">Fiche de frais à valider</a>
           </li>
 	   <li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se dÃ©connecter">DÃ©connexion</a>
           </li>
         </ul>
        
    </div>
    