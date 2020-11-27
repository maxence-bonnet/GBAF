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
		<title>Accueil GBAF</title>
	</head>
	<body>
	<?php include("../includes/inc_header.php"); ?>
		<div class ="content accueil_content">
		<?php
		if(isset($_SESSION['username']) AND !empty($_SESSION['username']))
		{ 
			?>
			<div class="presentation_section">
				<h1>Groupement Banque-Assurance Français</h1>
				<p>Le GBAF représente les professions bancaires et de l'assurance sur tous les axes de la réglementation financière française. Sa mission est de promouvoir l'activité bancaire à l'échelle nationale. Il est également un interlocuteur privilégié des pourvoirs publics. Il est le fruit de l'association de 6 grands groupes français : BNP Paribas, BPCE, Crédit Agricole, Crédit Mutuel-CIC, Société Générale, La Banque Postale.</p>
				<div class="illustration">
					<div class="illustration_logos_container">
						<a href="#"><img src="logos/banques/BP.jpg" alt="banque_postale"/></a>
						<a href="#"><img src="logos/banques/CA.png" alt="credit_agricole"/></a>
						<a href="#"><img src="logos/banques/SG.png" alt="societe_generale"/></a>
						<a href="#"><img src="logos/banques/CIC.png" alt="cic"/></a>						
						<a href="#"><img src="logos/banques/BPCE.png" alt="bpce"/></a>
						<a href="#"><img src="logos/banques/CM.png" alt="credit_mutuel"/></a>						
						<a href="#"><img src="logos/banques/BNP.png" alt="bnp_paribas"/></a>
					</div>
				</div>
			</div>
			<div class="actors_list_section">
				<div class="actors_list_intro">
					<h2>Les acteurs et partenaires</h2>
						<p>Une liste complète des différents partenaires avec qui nous sommes susceptibles de collaborer. Vous pourrez ici vous renseigner sur chacun d'entre eux, consulter les avis de confrères, ou y laisser votre propre commentaire afin d'échanger des appréciations constructives et de distinguer les qualités et compétences de chacun de ces partenaires.</p>
				</div>					
					<?php // Récupération des infos et extraits de tous les partenaires
						try
						{
						$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
						}
						catch (Exception $e)
						{
						        die('Erreur : ' . $e->getMessage());
						}
						$result = $db->query('SELECT * FROM actor');
						while($data = $result->fetch())
						{
							$content = htmlspecialchars($data['description']);
							$extract = explode(" ",$content);
							?>								
								    <div class="actor">
								    	<div class="actor_logo_n_desc">
								    		<div class="actor_logo"><img src="logos/<?php echo $data['logo']; ?>" alt="logo <?php echo $data['actor']; ?>"></div>
								    			<div class="actor_description">
									    			<h3><?php echo $data['actor']; ?></h3>									    			
									    			<p><?php /* boucle pour écrire les 25 premiers mots pour un rendu plus homogène, si on veut exactement la première phrase on demande d'afficher $phrase où $phrase = strtok($content,"."); mais résultat pas terrible si phrase trop courte. */
									    			$i = 0;
									    			while($i < 25)
									    			{
									    				echo $extract[$i] . ' ';
									    				$i++;
									    			}
									    			?>... </p><p>Vers le site de <a class="actor_external_link" href="#"><?php echo $data['actor']?></a></p>
									    		</div>
									    	</div>
									    	<a class="actor_read_more" href="acteur.php?act=<?php echo $data['id_actor']; ?>">Lire la suite</a>
								    </div>
							<?php
						}
						$result->closeCursor();
					?>
			</div>
		<?php
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
					<form class="connection_form" action="accueil.php?fgt=2" method="post">
						<fieldset>
							<legend class="long_legend">Réinitialiser le mot de passe :</legend>

								<label for="username">Veuillez saisir votre nom d'utilisateur :</label><input type="text" name="username" id="username"/>

								<input type="submit" name="submit" value="Valider">
								<!-- mettre un header('Location: accueil.php?fgt=2'); -->					
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
						<form class="connection_form" action="accueil.php?fgt=3" method="post">
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
									<a href="accueil.php?fgt=1">Recommencer</a>
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
						if($reponse1 == $reponse2)// 5) Bonne réponse, on vérifie le format des mots de passe
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
								header('Location: accueil.php');
							}
							else // Mauvais format mdp ou alors ils ne correspondent pas
							{
								?>
								<form class="connection_form" action="../traitement/trait_mot_de_passe.php" method="post">
									<fieldset>
										<legend>Échec :</legend>
											<p> Le format de mot de passe saisi est incorrect ou alors les mots de passe ne correspondent pas : </p>
											<a href="accueil.php?fgt=1">Recommencer</a>
									</fieldset>			
								</form>
								<?php														
							}
						}
						else // mauvaise réponse à la question secrète
						{
							?>
							<form class="connection_form" action="../traitement/trait_mot_de_passe.php" method="post">
								<fieldset>
									<legend>Échec :</legend>
										<p> La réponse à la question secrète est incorrecte :</p>
										<a href="accueil.php?fgt=1">Recommencer</a>
								</fieldset>			
							</form>
							<?php													
						}
					}
					else // erreur indéterminée (pas de $_SESSION['usertemp'])
					{
						?>
						<form class="connection_form" action="../traitement/trait_mot_de_passe.php" method="post">
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
				?>
				<form class="connection_form" action="../traitement/trait_connexion.php" method="post">
					<fieldset>
						<legend>Connexion</legend>
							<?php
								if(isset($_SESSION['passchanged']))
								{
									    echo '<p style=color:red;>La modification du mot de passe a bien été prise en compte.</p>';
									    unset($_SESSION['passchanged']);
								}							
								if(isset($_SESSION['wrong']))
								{
									    echo '<p style=color:red;>Le mot de passe ou l\'identifiant est incorrect.</p>';
									    unset($_SESSION['wrong']);
								}
								if(isset($_SESSION['success']))
								{
									    echo '<p style=color:red;>Inscription réussie !</p>';
									    unset($_SESSION['success']);
								}														
							?>
							<label for="username">Indentifiant / nom d'utilisateur :</label><input type="text" name="username" id="username"/>

							<label for="password">Mot de passe :</label><input type="password" name="password" id="password"/>

							<div class="connection_link"><a href="accueil.php?fgt=1">Mot de passe oublié ?</a><p>  |  </p><a href="inscription.php">Je ne suis pas encore inscrit</a></div>

							<input type="submit" name="submit" value="Me connecter">
				
					</fieldset>			
				</form>
				<?php
			}
		}
	?>
		</div>
		<?php include("../includes/inc_footer.php"); ?>
	</body>
</html>