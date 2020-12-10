<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" href="style.css" />
		<link rel="icon" type="image/png" href="logos/gbaf_ico.png" />
		<title>Récupération du mot de passe</title>
	</head>
	<body>
	<?php include("../includes/inc_header.php"); ?>
		<div class="content accueil_content">
		<?php
		if(isset($_SESSION['username']) AND !empty($_SESSION['username']))
		{
			header('Location: accueil.php');
		}
		else
		{
			try
			{
			$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
			}
			catch (Exception $e)
			{
			        die('Erreur : ' . $e->getMessage());
			}
			if(isset($_GET['fgt'])) // Cas de demande de réinitialisation du mot de passe 
			{
				$step = htmlspecialchars($_GET['fgt']);
				if($step == 1) // 1) on demande le nom d'utilisateur
				{
					?>
					<form class="connection_form" action="reinitialisation.php?fgt=2" method="post">
						<fieldset>
							<legend class="long_legend">Réinitialiser le mot de passe :</legend>

								<label for="username">Veuillez saisir votre nom d'utilisateur :</label><input type="text" name="username" id="username"/>

								<input type="submit" name="submit" value="Valider">

						</fieldset>			
					</form>			
					<?php				
				}
				if($step == 2 AND isset($_POST['username'])) // 2) On vérifie l'existance de l'identifiant
				{
					$username = htmlspecialchars($_POST['username']);			
					$result = $db->prepare('SELECT username FROM account WHERE username = :username');
					$result->execute(array('username' => $_POST['username']));
					$data = $result->fetch();
					$result->closeCursor();
					if($data)// 3) identifiant correct, on pose la question secrète de l'utilisateur
					{
						$_SESSION['usertemp'] = $username;
						?>
						<form class="connection_form" action="reinitialisation.php?fgt=3" method="post">
							<fieldset>
								<legend class="long_legend">Réinitialiser le mot de passe :</legend>

									<?php 
										$result = $db->prepare('SELECT question FROM account WHERE username = :username');
										$result->execute(array('username' => $_POST['username']));
										$data = $result->fetch();
										$data['question'] = preg_replace("#(\?)#"," ",$data['question']);
										$question = 'Votre question secrète : ' . $data['question'] . ' ?'; 
										$result->closeCursor();
									?>

									<label for="answer"><?php echo $question ?> </label><input type="text" name="answer" id="answer"/>

									<label for="pass1">Nouveau mot de passe <span class="lower_italic">(8 caractères, une majuscule, un chiffre et un caractère spécial au minimum)</span> :</label><input type="password" name="pass1" id="pass1"/>

									<label for="pass2">Confirmation du mot de passe :</label><input type="password" name="pass2" id="pass2"/>

									<input type="submit" name="submit" value="Changer le mot de passe">
							</fieldset>			
						</form>			
						<?php
					}
					else
					{
						?>
						<form class="connection_form" action="../traitement/trait_mot_de_passe.php" method="post">
							<fieldset>
								<legend>Échec :</legend>
									<p> L'identifiant saisi est incorrect, veuillez recommencer :</p>
									<a href="reinitialisation.php?fgt=1">Recommencer</a>
							</fieldset>			
						</form>
						<?php
					}
				}
				if($step == 3 AND isset($_POST['answer']) AND isset($_POST['pass1']) AND isset($_POST['pass2']) AND isset($_SESSION['usertemp'])) // 4) On vérifie la réponse
				{
					$result = $db->prepare('SELECT reponse FROM account WHERE username = :username');
					$result->execute(array('username' => $_SESSION['usertemp']));
					$data = $result->fetch();
					$result->closeCursor();
					if($data)
					{
						$reponse = htmlspecialchars($_POST['answer']);
						$testanswer = password_verify($reponse,$data['reponse']);
						if($testanswer)// 5) Bonne réponse, on vérifie le format des mots de passe
						{
							$pass1 = htmlspecialchars($_POST['pass1']);
							$pass2 = htmlspecialchars($_POST['pass2']);
							if(preg_match("#(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\d)(?=.*[^A-Za-z\d])#",$pass1) AND $pass1=$pass2) // 6) Format et correspondance Ok -> écriture
							{
								$pass = password_hash($pass1, PASSWORD_DEFAULT);
								$query = $db->prepare('UPDATE account SET password = :pass WHERE username = :username');
								$query->execute(array('pass' => $pass,'username' => $_SESSION['usertemp']));
								$data = $result->fetch();
								$query->closeCursor();
								unset($_SESSION['usertemp']);
								$_SESSION['passchanged'] = true;
								header('Location: connexion.php');
							}
							else // Mauvais format mot de passe ou alors ils ne correspondent pas
							{
								?>
								<form class="connection_form" action="#" method="post">
									<fieldset>
										<legend>Échec :</legend>
											<p> Le format de mot de passe saisi est incorrect ou alors les mots de passe ne correspondent pas : </p>
											<a href="reinitialisation.php?fgt=1">Recommencer</a>
									</fieldset>			
								</form>
								<?php														
							}
						}
						else // mauvaise réponse à la question secrète
						{
							?>
							<form class="connection_form" action="#" method="post">
								<fieldset>
									<legend>Échec :</legend>
										<p> La réponse à la question secrète est incorrecte :</p>
										<a href="reinitialisation.php?fgt=1">Recommencer</a>
								</fieldset>			
							</form>
							<?php													
						}
					}
					else // erreur indéterminée (pas de $_SESSION['usertemp'])
					{
						?>
						<form class="connection_form" action="#" method="post">
							<fieldset>
								<legend>Échec :</legend>
									<p> Erreur inconnue :</p>
									<a href="accueil.php">Retour à la page de connexion</a>
							</fieldset>			
						</form>
						<?php
					}
				}
			}
			else
			{
				header('Location: connexion.php');
			}
		}
	?>
		</div>
		<?php include("../includes/inc_footer.php"); ?>
	</body>
</html>