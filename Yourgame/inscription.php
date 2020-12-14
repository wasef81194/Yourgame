<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Inscription</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body id="body">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<?php
include('db_manager.php');
function Inscription($nom,$prenom,$login,$password){
  $request = "INSERT INTO `user`(id_user,nom_user,prenom_user,login_user,mdp_user)
              VALUES (NULL,'$nom', '$prenom','$login','$password')";
  $inscription = getResults($request);
}
function LoginExist($login){
  $request_login =  ("SELECT login_user FROM user ");
  $verification_login = getResults($request_login);
  while ($row = $verification_login -> fetch_array( MYSQLI_NUM)) {
      for ($i=0; $i <sizeof($row) ; $i++) { 
        if ($row[$i]==$login) {
          return $LoginExist = TRUE;
        }
      }
    }
}

if($_POST["formtype"] == "inscription"){
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $login =  $_POST['login'];
  $password = $_POST['mdp'];
  $verification = $_POST['mdpc'];
  $hash=md5($password);
  if (!empty($nom) AND !empty($prenom) AND !empty($login) AND !empty($password) AND !empty($verification)) {
  	if (LoginExist($login)) {
      $message_erreur = $login." ce login est déjà pris";
    }
    elseif($password!=$verification){
      $message_erreur = "Les deux mot de passe ne coresspondent pas";
    }
    elseif(!preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)#',$password)){
      $message_erreur = "Votre mot de passe doit contenir des lettres miniscules et majuscules des chiffre et des caractères spéciaux";
    }
    //Verifie le format du nom
    elseif (!preg_match("#^(\pL+[- ']?)*\pL$#ui", $nom) AND !preg_match("#^(\pL+[- ']?)*\pL$#ui", $prenom)) {
      $message_erreur = " Nom ou Prénom non conforme";
    }
    else{
      Inscription($nom,$prenom,$login,$hash);
      $message = "Vous êtes bien inscrit";
    }
  }
  else{
  	$message_erreur = "Veuillez remplir tout les champs ";
  }

}

  ?>

<h1>Formulaire d'inscription</h1>
		
<form id="formulaire" action="./inscription.php" method="post" class="inscription">
 <?php
  if (isset($message_erreur)) {
     echo '<div id="message_erreur">'.$message_erreur.'</div>';
   }
  elseif (isset($message)) {
     echo '<div id="message">'.$message.'</div>';
   } 
   ?>
	<label><p>Etat civil</p> </label>
	<select id="civil">
		<option value="Mme">Mme</option>
		<option value="M">M</option>
	</select required>

	<label><p>Nom</p></label>
	<input type="text" name="nom" id="nom" required>

	<div id="message_nom"></div>

	<label><p>Prenom</p></label>
	<input type="text" name="prenom" id="prenom" required>

	<div id="message_prenom"></div>

	<label><p>Login</p></label>
	<input type="text" name="login" id="login" required="">

	<div id="message_login"></div>

	
	<label><p>Mot de Passe</p></label>
	<input type="password" name="mdp" id="mdp" required>
	<div id="message_mdp"></div>

	<label> <p>Mot de Passe verification</p></label>
	<input type="password" name="mdpc" id="mdpc" required>

	<div id="message_mdpc"></div>
	<div id="message_password"></div>



	<label ><p></p>Afficher les mots de passe</label>
	<input type="checkbox" name="amdp" id="amdp">
	
	<input type="hidden" name="formtype" value="inscription" />
	<br><br><input name="envoyer" id="envoyer" type="submit"><input type="reset" name="effacer">
</form>
 
<script type="text/javascript">
	
	function VerificationChamps(champs,message_champs){
		//avant de valider
		$("#envoyer").hover(function(){
		//si le champs du login est vide
			if($(champs).val()==""){
				$(message_champs).html("<p>Ce champ est vide</p>");
				$(message_champs).css("color", "red");
				$(message_champs).css("font-weight", "bold");
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
	function RemplirChamps(champs,message_champs){
		$("#body").click(function(){
		//si le champs est vide
			if($(champs).val()!=""){
				$(message_champs).html("");
			}
	})
	}

	
	//Verification des champs
	//Nom
	VerificationChamps("#nom","#message_nom");
	RemplirChamps("#nom","#message_nom");
	//Prenom
	VerificationChamps("#prenom","#message_prenom");
	RemplirChamps("#prenom","#message_prenom");
	//Login
	VerificationChamps("#login","#message_login");
	RemplirChamps("#login","#message_login");
	//Mdp
	VerificationChamps("#mdp","#message_mdp");
	RemplirChamps("#mdp","#message_mdp");
	//verfification du mdp
	VerificationChamps("#mdpc","#message_mdpc");
	RemplirChamps("#mdpc","#message_mdpc");

	

	//Permet d'afficher le mot de passe en clair
	$("#amdp").click(function(){
		if ($(this).is(':checked')){
			$("#mdp").replaceWith('<input id="mdp" name="mdp" type="text" value="' + $('#mdp').val() + '" />');
			$("#mdpc").replaceWith('<input id="mdpc" name="mdpc" type="text" value="' + $('#mdpc').val() + '" />');
		} 
		else{
			$("#mdp").replaceWith('<input id="mdp" name="mdp" type="password" value="' + $('#mdp').val() + '" />');
			$("#mdpc").replaceWith('<input id="mdpc" name="mdpc" type="password" value="' + $('#mdpc').val() + '" />');
		}
	})


	
</script>
</body>
</html>