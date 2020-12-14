<!DOCTYPE html>
<head>
  <title>Connexion</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<?php
session_start();
//On inclut le fichier qui établit la connexion
include('db_manager.php');

		$doesUserExist = FALSE;

		if(isset($_POST["formtype"])){
  			
  			$login =  $_POST['login'];
  			$password = $_POST['password'];
        $hash = md5($password);
  			if ( !empty($login) AND !empty($password)) {
  				$request= ("SELECT login_user,mdp_user,nom_user,prenom_user,id_user FROM user ");
  				$result = getResults($request);
  				while ($row = $result -> fetch_array( MYSQLI_NUM)) {
  					if ($row[0]==$login AND $row[1]==$hash){
              $_SESSION['login']=$row[0];
              $_SESSION['nom']=$row[2];
              $_SESSION['prenom']=$row[3];
              $_SESSION['id_user']=$row[6];
  						$doesUserExist = TRUE;
  					}

  				}
  				if( $doesUserExist == TRUE )
				{      
	  				header('Location: game.html');
				}
				else{
					header('Location: connexion.php?erreur=connexionErreur');  
					exit();  
				}
  			}
  		}



?>
<html lang="fr">
<body>
  
	<h1>Formulaire d'inscription</h1>
		

  <div id="connexion">
 		<form action="connexion.php" method="post" class="connexion" >
      
            <h2 id="title_inscription">Identification </h2>
            <div class = "message_erreur">
              <?php
                $matchFound = (isset($_GET["erreur"]) && trim($_GET["erreur"]) == 'connexionErreur');
                if($matchFound){
                  echo "<div id='message_erreur'>Login ou mot de passe incorrect</div>";
                }
              
              ?>
            </div>
          </div>
  			   
  				<div id="connexion">
  					<p>Entrer votre pseudo:</p>
  					<input type="text" name="login"required/>
  
  					<p>Entrer votre mot de passe:</p>
  					<input type="password" name="password" required/>
  
  					<input type="hidden" name="formtype" value="connexion" />
  					<input type="reset" value="recommancer" class="button" />
  					<input type="submit" name="validez">
  
  
  					<p>Vous n'avez pas de un compte?
  					<a href=inscription.php>Inscrivez vous ici.</a></p>
		</form>

</body>
<footer>
  <p>Copyright © Développé par WASEF Alexandra et Thilleli BELHOCINE</p>
</footer>

</html>