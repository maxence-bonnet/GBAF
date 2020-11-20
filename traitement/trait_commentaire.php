<?php
	session_start();
if(isset($_POST['new_post']) AND isset($_GET['act']) AND isset($_SESSION['last_name']) AND isset($_SESSION['first_name']) AND isset($_SESSION['username']))
{	
	$last_name = htmlspecialchars($_SESSION['last_name']);
	$first_name = htmlspecialchars($_SESSION['first_name']);
	$username = htmlspecialchars($_SESSION['username']);
	$new_post = nl2br(htmlspecialchars($_POST['new_post']));
	$actor = htmlspecialchars($_GET['act']);
	try
	{
	$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
	}
	catch (Exception $e)
	{
	        die('Erreur : ' . $e->getMessage());
	}
	// On vérifie que $_GET['act'] a une valeur existante
	$result = $db->prepare('SELECT id_actor FROM actor WHERE id_actor = :actor');
	$result->execute(array(':actor' => $actor));
	$data = $result->fetch();
	if(!$data)// $_GET['act']  inexistant /
	{
		// retour à l'accueil, pas mieux pour l'instant
		header('Location: ../pages/accueil.php');
		echo 'if !$data <br/>';
	}	
	elseif(empty($_POST['new_post'])) // Si le $_POST['new_post'] est vide mais a passé le test isset (? happens...)
	{
		echo 'elseif empty POST <br/>';
		//header("Refresh:0");
	}
	else // écriture : need id_actor=$actor / id_user = ? / post= $post / date_add = auto
	{
		// 1) On va récupérer l'identifiant utilisateur via username (qui est unique, pas de confusion possible)
		$result = $db->prepare('SELECT id_user FROM account WHERE username = :username');
		$result->execute(array('username' => $username));
		$data = $result->fetch();
		$result->closeCursor();
		$id_user = $data['id_user'];
		// 2) écriture dans la table post
		$query = $db->prepare('INSERT INTO post(id_user, id_actor, post) VALUES(:id_user, :id_actor, :post)');
		$query->execute(array('id_user' => $id_user, 'id_actor' => $actor, 'post' => $new_post));
		$query->closeCursor();
		header('Location: ../pages/acteur.php?act=' . $actor);
	}
}
?>