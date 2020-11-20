<?php
	session_start();
if(isset($_GET['act']) AND isset($_SESSION['username'])) // Si il y a bien un paramètre de référence acteur et une connexion
{
	$actor = htmlspecialchars($_GET['act']);
	$username = htmlspecialchars($_SESSION['username']);	
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
	if(!$data)// référence dans $_GET['act'] inexistante dans la bdd 
	{
		// retour à l'accueil, pas mieux pour l'instant
		header('Location: ../pages/accueil.php');
	}
	// 1) On va récupérer l'identifiant utilisateur via username
	$result = $db->prepare('SELECT id_user FROM account WHERE username = :username');
	$result->execute(array('username' => $username));
	$data = $result->fetch();
	$result->closeCursor();
	$id_user = htmlspecialchars($data['id_user']);
	if(isset($_GET['delete']) AND $_GET['delete'] == 1)// Si c'est une demande de suppression valide
	{
		// 2) On supprime son commentaire pour l'acteur souhaité
		$query = $db->prepare('DELETE FROM post WHERE id_user = :id_user AND id_actor = :id_actor');
		$query->execute(array('id_user' => $id_user, 'id_actor' => $actor));
		$query->closeCursor();
		// 3) Retour à la page de l'acteur en question et on confirme la suppression
		$_SESSION['deleted_post'] =  true ;
		header('Location: ../pages/acteur.php?act=' . $actor);			
	}
	elseif(isset($_POST['new_post']) AND !empty($_POST['new_post'])) // Si c'est une demande d'écriture valide
	{	
		// 2) On vérifie qu'il n'y a pas déjà un commentaire de cet utilisateur pour cet acteur
		$result = $db->prepare('SELECT id_post FROM post WHERE id_user = :id_user AND id_actor = :id_actor');
		$result->execute(array('id_user' => $id_user, 'id_actor' => $actor));
		$data = $result->fetch();
		$result->closeCursor();
		if(!$data) // Pas de donnée -> il n'y a pas de commentaire de cet utilisateur pour cet acteur
		{			
			$new_post = htmlspecialchars($_POST['new_post']);			
			// 3) Écriture dans la table post
			$query = $db->prepare('INSERT INTO post(id_user, id_actor, post) VALUES(:id_user, :id_actor, :post)');
			$query->execute(array('id_user' => $id_user, 'id_actor' => $actor, 'post' => $new_post));
			$query->closeCursor();
			// 4) Retour à la page de l'acteur en question et on confirme la prise en compte de l'écriture
			$_SESSION['posted'] =  true ;
			header('Location: ../pages/acteur.php?act=' . $actor);
		}
		else // Commentaire déjà existant, on envoie un message d'erreur et retour à la page acteur
		{
			$_SESSION['existing_post'] = true ;
			header('Location: ../pages/acteur.php?act=' . $actor);
		}
	}	
}
else // au cas où
{ 
	header('Location: ../pages/accueil.php');	
}
?>