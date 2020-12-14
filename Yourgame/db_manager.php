<?php

$configs = include('login_bdd.php');

//----------------------------------------------------------------------------------------

function OpenCon()
	{
		global $configs;
		
		$conn = mysqli_connect($configs['servername'], $configs['username'], $configs['pass'],$configs['dbname']);
		if (!$conn){
			error_log("Connect failed");
		}
		$conn->set_charset('utf8');
 
		return $conn;
	}
	
//----------------------------------------------------------------------------------------

function CloseCon($conn)

	{
		$conn -> close();
	}


//----------------------------------------------------------------------------------------
 function getResults($request)
 {
    //Connexion à la base de données
     $conn = OpenCon();

     $result = mysqli_query($conn,$request);
     //fermeture de la connexion
     CloseCon($conn);
     return $result;
 }





?>