<?php
session_start();
if(isset($_SESSION['username']) AND isset($_GET['like'])  AND isset($_GET['act'])) // on vérifie la connexion et les paramètres (n° acteur et type de like)
{
	$likerequest = htmlspecialchars($_GET['like']);
	if($likerequest >= 1 AND $likerequest <= 3)// si la demande est valide
	{
		try
		{
		$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
		}
		catch (Exception $e)
		{
		        die('Erreur : ' . $e->getMessage());
		}
		$username = htmlspecialchars($_SESSION['username']);
		$actor = htmlspecialchars($_GET['act']);
		// on verfie l'existance de l'utilisateur et de l'acteur en question
		//1) l'identifiant
		$result = $db->prepare('SELECT id_user FROM account WHERE username = :username');
		$result->execute(array('username' => $username));
		$data1 = $result->fetch();
		$result->closeCursor();
		//2) l'acteur
		$result = $db->prepare('SELECT id_actor FROM actor WHERE id_actor = :actor');
		$result->execute(array('actor' => $actor));
		$data2 = $result->fetch();
		$result->closeCursor();
		if(!$data1 OR !$data2)// si au moins un des deux est inexistant : problème -> retour accueil
		{
			header('Location: ../pages/accueil.php');
		}
		else 
		{
			$id_user = htmlspecialchars($data1['id_user']);
			$id_actor = htmlspecialchars($data2['id_actor']);
			$result = $db->prepare('SELECT account.id_user, username, vote.id_user, id_actor, vote 
						FROM account
						INNER JOIN vote
						ON account.id_user = vote.id_user
						WHERE id_actor = :actor
						AND username = :username');
			$result->execute(array('actor' => $actor, 'username' => $username));
			$data = $result->fetch();
			$result->closeCursor();
			if(!$data) // pas d'occurence, normal pour un premier like / dislike
			{	
				if($likerequest == 1)
				{
					
					// ajouter un like INSERT INTO
					$likerequest = 'like';
					$req = $db->prepare('INSERT INTO vote(id_user, id_actor, vote) VALUES(:id_user, :actor, :vote)');
					$req->execute(array('id_user' => $id_user, 'actor' => $id_actor, 'vote' => $likerequest));
					$req->closeCursor();
					// retour à la page
					header('Location: ../pages/acteur.php?act=' . $id_actor);
				}
				elseif($likerequest == 2)
				{
					// ajouter un dislike INSERT INTO
					$likerequest = 'dislike';
					$req = $db->prepare('INSERT INTO vote(id_user, id_actor, vote) VALUES(:id_user, :actor, :vote)');
					$req->execute(array('id_user' => $id_user, 'actor' => $id_actor, 'vote' => $likerequest));
					$req->closeCursor();
					// retour à la page
					header('Location: ../pages/acteur.php?act=' . $id_actor);				
				}
				else
				{
					// ne devrait pas arriver (bouton réinitialiser pas affiché si aucune saisie pour l'utilisateur)
					header('Location: ../pages/accueil.php');
				}
			}
			else // cas où il y a déjà une saisie (like ou dislike)
			{
				if($data['vote'] == 'like')
				{
					if($likerequest == 2)
					{
						// passer de like à dislike UPDATE
						$likerequest = 'dislike';
						$req = $db->prepare('UPDATE vote SET vote = :vote WHERE id_user = :id_user AND id_actor = :actor');
						$req->execute(array('vote' => $likerequest, 'id_user' => $id_user, 'actor' => $id_actor));
						$req->closeCursor();						
						// retour à la page
						header('Location: ../pages/acteur.php?act=' . $id_actor);	
					}
					if($likerequest == 3)
					{
						// réinitialiser en effaçant l'entrée existante DELETE FROM
						$req = $db->prepare('DELETE FROM vote WHERE id_user = :id_user AND id_actor = :actor');
						$req->execute(array('id_user' => $id_user, 'actor' => $id_actor));
						$req->closeCursor();						
						// retour à la page
						header('Location: ../pages/acteur.php?act=' . $id_actor);						
					}
					else // si demande de like sur un like -> invalide -> retrour à la page
					{
						header('Location: ../pages/acteur.php?act=' . $id_actor);
					}
				}
				elseif($data['vote'] == 'dislike')
				{
					if($likerequest == 1)
					{
						// passer de dislike à like UPDATE
						$likerequest = 'like';
						$req = $db->prepare('UPDATE vote SET vote = :vote WHERE id_user = :id_user AND id_actor = :actor');
						$req->execute(array('vote' => $likerequest, 'id_user' => $id_user, 'actor' => $id_actor));
						$req->closeCursor();						
						// retour à la page
						header('Location: ../pages/acteur.php?act=' . $id_actor);						
					}
					if($likerequest == 3)
					{
						// réinitialiser en effaçant l'entrée existante DELETE FROM
						$req = $db->prepare('DELETE FROM vote WHERE id_user = :id_user AND id_actor = :actor');
						$req->execute(array('id_user' => $id_user, 'actor' => $id_actor));
						$req->closeCursor();						
						// retour à la page
						header('Location: ../pages/acteur.php?act=' . $id_actor);							
					}
					else // si demande de dislike sur un dislike -> invalide -> retour à la page
					{
						header('Location: ../pages/acteur.php?act=' . $id_actor);
					}						
				}
			}	
		}
	}
	else // demande non valide ($likerequest n'est pas comprise en 1 et 3)
	{
		header('Location: ../pages/accueil.php');
	}
}
else // il manque des paramètres ou une connexion
{
	header('Location: ../pages/accueil.php');
}