<?php
session_start();
unset($_SESSION["login"]);
unset($_SESSION["nom"]);
unset($_SESSION["prenom"]);
unset($_SESSION["id_user"]);
session_destroy();
header('Location: index.php');
exit();
?>