<?php
if(isset($_POST['last_name']) AND isset($_POST['first_name']) AND isset($_POST['username']) AND isset($_POST['pass1']) AND isset($_POST['pass2']) AND isset($_POST['question']) AND isset($_POST['answer']))
{
	foreach($_POST as $value => $key)
	{
		$_POST[$value] = htmlspecialchars($_POST[$value]);
	}
	try
	{
	$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	}
	// Test si username disponnible
	$result = $db->prepare('SELECT username FROM account WHERE username = :username');
	$result->execute(array('username' => $_POST['username']));
	$data = $result->fetch();
	$result->closeCursor();
	if($data)
	{
		// username existant
		$error[] = 'exist';
	}
	// RAJOUTER UN TEST POUR EMPECHER L'IDENTIFIANT DE CONTENIR DES ESPACES
	if(strlen($_POST['username']) < 3)
	{
		// username trop court
		$error[] = 'short';
	}
	if(!preg_match("#(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\d)(?=.*[^A-Za-z\d])#",$_POST['pass1']) OR strlen($_POST['pass1']) < 8)
	{
		// format mot de passe invalide
		$error[] = 'invalidpass';
	}
	if($_POST['pass1'] != $_POST['pass2'])
	{
		// les mots de passe ne correspondent pas
		$error[] = 'passnotmatching';
	}
	if(!isset($error))
	{
		// pas d'erreur = écriture dans la bdd
		$pass=password_hash($_POST['pass1'],PASSWORD_DEFAULT);
		$query = $db->prepare('INSERT INTO account(nom, prenom, username, password, question, reponse) VALUES(:nom, :prenom, :username, :pass, :question, :answer)');
		$query->execute(array('nom' => $_POST['last_name'], 'prenom' => $_POST['first_name'], 'username' => $_POST['username'], 'pass' => $pass, 'question' => $_POST['question'], 'answer' => $_POST['answer']));
		$query->closeCursor();
		// envoi d'une notification confirmation de l'inscription
		session_start();
		$_SESSION['success'] = true;
		header('Location: ../pages/accueil.php');
	}
}
else
{
	//manque des champs
	$error[] = 'entrymissing';
}
if(isset($error))
{
	session_start();
	foreach($error as $value => $key)
	{
		$_SESSION[$key] = true;
	}
	header('Location: ../pages/inscription.php');
}
?>