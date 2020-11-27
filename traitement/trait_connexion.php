<?php
if(isset($_POST['username']) AND isset($_POST['password']) AND !empty($_POST['username']) AND !empty($_POST['password']))
{	//connexion à la BDD
	try
	{
	$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	}
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);
	$result = $db->prepare('SELECT nom, prenom, username, password FROM account WHERE username = :username');
	$result->execute(array('username' => $username));
	$content = $result->fetch();
	$testpass = password_verify($password,$content['password']);
	if($content AND $testpass)
	{
		session_start();
		$_SESSION['last_name'] = $content['nom'];
		$_SESSION['first_name'] = $content['prenom'];
		$_SESSION['username'] = $content['username'];
		header('Location: ../pages/accueil.php');
	}
	else // mauvais identifiant ou mot de passe
	{
		session_start();
		$_SESSION['wrong'] = true ;
		header('Location: ../pages/accueil.php');
	}
}
else
{
	header('Location: ../pages/accueil.php');
}
?>
