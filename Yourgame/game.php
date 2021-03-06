<?php
	session_start();
	if (!isset($_SESSION['login'])){
		header("Location:index.php");
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Game</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<h1>Pierre Feuille Ciseau</h1>
	<div id="bouton">
	<button id='deconnexion'><a href="deconnexion.php" id="none">Déconnexion</a></button>
	</div>
	<div id="jeu">
	<div id="head">
	<p>MANCHE<div id="manche">0</div></p>
	</div>
	

	
	<div id="score">
		
	<div id="sc_user">
	<p><?php
	if (isset($_SESSION['login'])) {
	 	echo $_SESSION['login'];
	}
	else{
		echo "Vous";
	}
	
	?><div id="score_user">0</div></p>
	</div>
	<div id="sc_robot">
	<p>Adversaire<div id="score_robot">0</div></p>
	</div>
	
	</div>
	
	<div id="bouton">
	<button id="pierre"> <img src="css/images/pierre.jpg" alt="Pierre"></button>
	<button id="feuille"><img src="css/images/feuille.jpg" alt="Feuille"></button>
	<button id="ciseau"><img src="css/images/ciseau.jpg" alt="Ciseau"></button>
</div></div>
	<div id="bouton">
	<div id="combat"></div>
	<div id="resultat"></div>
	</div>
	<script type="text/javascript">

	//function
	function getRandomIntInclusive(min, max) {
		//tirage d'un chiffre aléatoire
	  	min = Math.ceil(min);
	  	max = Math.floor(max);
	  	return Math.floor(Math.random() * (max - min +1)) + min;
	}

	function Robot(probabiliter) {
		//Pour que le robot puisse jouer
		if (probabiliter>=0 && probabiliter<=50 ) {
			var action = "Feuille";
		}
		else if(probabiliter>50 && probabiliter<=100){
			var action = "Ciseau";
		}
		else{
			var action = "Pierre";
		}
		return action;
	}

	function Combat(user,robot){
		//resulatat de chaque manche
		if(user=="Feuille" && robot=="Feuille" || user=="Pierre" && robot=="Pierre" || user=="Ciseau" && robot=="Ciseau"){
			resultat = "Egaliter";
		}
		else if (user=="Ciseau" && robot=="Feuille" || user=="Feuille" && robot=="Pierre" || user=="Pierre" && robot=="Ciseau") {
			resultat = "Vous avez gagner";
		}
		else if (user=="Feuille" && robot=="Ciseau" || user=="Pierre" && robot=="Feuille" || user=="Ciseau" && robot=="Pierre") {
			resultat = "Vous avez perdu";
		}
		return resultat;
	}
	function End(score_robot,score_user){
		//Resultat final du score
		if (score_robot>=5 || score_user>=5 ) {
			if (score_robot>score_user) {
				end = "Vous avez perdu";
			}
			else if(score_robot<score_user){
				end = "Vous avez perdu";
			}
		return end;
		}
	}

	function Result(pierre,feuille,ciseau,resultat,score_robot,score_user){
		//bloque les touches
		document.getElementById('pierre').disabled=true;
		document.getElementById('feuille').disabled=true;
		document.getElementById('ciseau').disabled=true;
		//si y'a égaliter
		if (score_robot==score_user) {
			$("#resultat").html("<button id='recommencer'>Recommencer</button> ");
			$("#res").css("background-color", "#e1dddc");
			$("#sc_user").css("background-color", "#e1dddc");
			$("#sc_robot").css("background-color", "#e1dddc");
		}
		//si le robot gagne et l'utilsateur pers
		else if (score_robot>score_user) {
			$("#resultat").html("<button id='recommencer'>Recommencer</button> ");
			$("#res").css("background-color", "#fa7967");
			$("#sc_user").css("background-color", "#fa7967");
			$("#sc_robot").css("background-color", "#98fa67");
		}
		//Si l'utilisateur gagne et le robot paire
		else if (score_robot<score_user) {
			$("#resultat").html(" <button id='recommencer'>Recommencer</button>  ");
			$("#res").css("background-color", "#98fa67");
			$("#sc_user").css("background-color", "#98fa67");
			$("#sc_robot").css("background-color", "#fa7967");
		}
		$("#recommencer").click(function(){
			window.location.reload();
		})

	}
	function Pictures(jeu){
		//Met des photo a la pace des boutton
		if (jeu == "Pierre") {
			img = '<img src="css/images/pierre.jpg" alt="Pierre">' ;
		}
		else if(jeu == "Feuille"){
			img = '<img src="css/images/feuille.jpg" alt="Feuille">' ;
		}
		else if(jeu == "Ciseau"){
			img = '<img src="css/images/ciseau.jpg" alt="Ciseau">' ;
		}
		return img;
	}

	//end of function


	var score_user = parseInt(document.getElementById('score_user').innerHTML);
	var score_robot = parseInt(document.getElementById('score_robot').innerHTML);
	var manche = parseInt(document.getElementById('manche').innerHTML);
	var end_manche = 10;


	
	//document.write(manche);
	


		
		
		$("#pierre").click(function(){
			var getRandom = getRandomIntInclusive(0, 150);
			//var getRandom = getRandomIntInclusive(0, 150);
			var user = "Pierre";
			var robot = Robot(getRandom);
			$("#combat").html("<div id='fight'><p> <div id='user'> Vous : "+ Pictures(user)+"</p></div>"+Combat(user,robot)+" <div id='robot'> <p>Adversaire : "+Pictures(Robot(getRandom))+"</p></div>");
			//Le score
			if (Combat(user,robot)=="Vous avez perdu") {
				score_robot +=1;
				$("#score_robot").html(score_robot);

			}
			else if(Combat(user,robot)=="Vous avez gagner"){
				score_user +=1;
				$("#score_user").html(score_user);
			}
			// Nombre de manche 
			manche += 1;
			$("#manche").html(manche);
			if(manche >= end_manche ){
				Result(pierre,feuille,ciseau,resultat,score_robot,score_user);
			}
		})

		$("#feuille").click(function(){
			var getRandom = getRandomIntInclusive(0, 150);
			//var getRandom = getRandomIntInclusive(0, 150);
			var user = "Feuille";
			var robot = Robot(getRandom);
			$("#combat").html("<div id='fight'><p> <div id='user'> Vous : "+ Pictures(user)+"</p></div>"+Combat(user,robot)+" <div id='robot'> <p>Adversaire : "+Pictures(Robot(getRandom))+"</p></div>");
			//Le score
			if (Combat(user,robot)=="Vous avez perdu") {
				score_robot +=1;
				$("#score_robot").html(score_robot);
			}
			else if(Combat(user,robot)=="Vous avez gagner"){
				score_user +=1;
				$("#score_user").html(score_user);
			}
			// Nombre de manche 
			manche += 1;
			$("#manche").html(manche);
			if(manche >= end_manche ){
				Result(pierre,feuille,ciseau,resultat,score_robot,score_user);
			}
		})

		$("#ciseau").click(function(){
			var getRandom = getRandomIntInclusive(0, 150);
			//var getRandom = getRandomIntInclusive(0, 150);
			var user = "Ciseau";
			var robot = Robot(getRandom);
			$("#combat").html("<div id='fight'><p> <div id='user'> Vous : "+ Pictures(user)+"</p></div>"+Combat(user,robot)+" <div id='robot'> <p>Adversaire : "+Pictures(Robot(getRandom))+"</p></div>");
			//Le score
			if (Combat(user,robot)=="Vous avez perdu") {
				score_robot +=1;
				$("#score_robot").html(score_robot);
			}
			else if(Combat(user,robot)=="Vous avez gagner"){
				score_user +=1;
				$("#score_user").html(score_user);
			}
			// Nombre de manche 
			manche += 1;
			$("#manche").html(manche);
			if(manche >= end_manche ){
				 Result(pierre,feuille,ciseau,resultat,score_robot,score_user);
			}
		})

	</script>

</body>
</html>