<!DOCTYPE html>
<head>
  <title>Connexion</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
	  				header('Location: game.php');
				}
				else{
					header('Location: index.php?erreur=connexionErreur');  
					exit();  
				}
  			}
  		}



?>
<html lang="fr">
<body id="body">
  
	<h1>Formulaire de connexion </h1>
		

<form action="index.php" method="post" class="connexion">
      
    <h2 id="title_inscription">Identification </h2>
     <div class = "message_erreur">
        <?php
            $matchFound = (isset($_GET["erreur"]) && trim($_GET["erreur"]) == 'connexionErreur');
	        if($matchFound){
	            echo "<div id='message_erreur'>Login ou mot de passe incorrect</div>";
        }
              
        ?>
        </div>
  			<p>Entrer votre pseudo:</p>
  			<input type="text" name="login" id="login" required/>
  			<div id="message_login"></div>
  					
  			<p>Entrer votre mot de passe:</p>
  			<input type="password" name="password" id="password" required/>

  			<div id="message_password" ></div>
  			<label ><p></p>Afficher les mots de passe</label>
			<input type="checkbox" name="amdp" id="amdp">

  			<input type="hidden" name="formtype" value="connexion" />

  			<p>
  			
  			<input type="reset" name = "effacer" />
  			<input type="submit" id="envoyer" name="validez">
  			</p>

  			<p>Vous n'avez pas de un compte?
  			
  			<a href=inscription.php>Inscrivez vous ici.</a></p>

</form>
<script type="text/javascript">
	
	function VerificationChamps(champs,message_champs,form){
		//avant de valider
		$("#envoyer").hover(function(){
		//si le champs du login est vide
			if($(champs).val()==""){
				$(message_champs).html("<p>Ce champ est vide</p>");
				$(message_champs).css("color", "red");
				$(message_champs).css("font-weight", "bold");
				$(form).css("height", "440px");

			}
		})
		/*//en quittant le champs
		$(champs).on(function(){
		//si le champs du login est vide
			if($(champs).val()==""){
				$(message_champs).html("Ce champ est vide");
				$(message_champs).css("color", "red");
				$(message_champs).css("font-weight", "bold");
			}
			else{
				$(message_champs).html("");
			}
		})*/

	}
	function RemplirChamps(champs,message_champs,form){
		$("#body").click(function(){
		//si le champs est vide
			if($(champs).val()!=""){
				$(message_champs).html("");
				$(form).css("height", "400px");
			}
	})
	}

	
	//Verification des champs
	//Login
	VerificationChamps("#login","#message_login","form.connexion");
	RemplirChamps("#login","#message_login","form.connexion");
	//mdp
	VerificationChamps("#password","#message_password","form.connexion");
	RemplirChamps("#password","#message_password","form.connexion");

	

	//Permet d'afficher le mot de passe en clair
	$("#amdp").click(function(){
		if ($(this).is(':checked')){
			$("#password").replaceWith('<input id="password" name="password" type="text" value="' + $('#password').val() + '" />');
		} 
		else{
			$("#password").replaceWith('<input id="password" name="password" type="password" value="' + $('#password').val() + '" />');
		}
	})
</script>

</body>
<footer>
  <p>Copyright © Développé par WASEF Alexandra</p>
</footer>

</html>