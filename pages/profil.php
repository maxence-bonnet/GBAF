<?php
session_start();
if(isset($_SESSION['username'])) // si connexion active
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
	$result = $db->prepare('SELECT username, nom, prenom, photo FROM account WHERE username = :username');
	$result->execute(array('username' => $username));
	$data = $result->fetch();
	$result->closeCursor();
	foreach($data as $value => $key)
	{
		$data[$value] = htmlspecialchars($data[$value]);		
	}
	$last_name = $data['nom'];
	$first_name = $data['prenom'];
	$photo = $data['photo'];
	?>
		<!DOCTYPE html>
		<html lang="fr">
			<head>
				<meta charset="UTF-8" />
				<meta name="viewport" content="width=device-width" />
				<link rel="stylesheet" href="style.css" />
				<link rel="icon" type="image/png" href="logos/gbaf_ico.png" />
				<title>Mon profil</title>
			</head>
			<body>
				<?php include("../includes/inc_header.php"); ?>
				<section class="content profile_content">
					<form enctype="multipart/form-data" class="profile_form" action="../traitement/trait_profil.php" method="post">
						<fieldset>
							<legend>Mon profil</legend>
							<div class="actual_profile">
								<div class="actual_profile_part1">								
									<p>Mon nom (fixe) : <?= $last_name ?></p>
									<p>Mon prénom (fixe) : <?= $first_name ?></p>
									<p>Mon identifiant : <?= $username ?></p>
								</div>
								<div class="actual_profile_part2">								
									<div class="photo">
										<p>Ma photo de profil : </p>
										<img src="uploads/<?= $photo ; ?>" alt="Ma photo de profil"/>
									</div>
								</div>
							</div>
							<HR>
								<div class="update_profile">
									<div class="update_profile_part1">
										<label for="username">Modifier mon identifiant : </label><input type="text" name="username" id="username"/>
											<?php
											if(isset($_SESSION['exist']))
											{
												    echo '<p style=color:red;>Ce nom d\'utilisateur existe déjà, veuillez en saisir un autre.</p>';
												    unset($_SESSION['exist']);
											}
											if(isset($_SESSION['short']))
											{
												    echo '<p style=color:red;>Le nom d\'utilisateur saisi est trop court (minimum 3 caractères).</p>';
												    unset($_SESSION['short']);
											}
											?>
										<h5>Modifier mon mot de passe</h5>
											<?php
											if(isset($_SESSION['passchanged']))
											{
												    echo '<p style=color:red;>La modification du mot de passe a bien été prise en compte.</p>';
												    unset($_SESSION['passchanged']);
											}
											?>											
										<label for="actual_pass">Mon mot de passe actuel : </label><input type="password" name="actual_pass" id="actual_pass">
											<?php
											if(isset($_SESSION['wrongpass']))
											{
												    echo '<p style=color:red;>Le mot de passe saisi est invalide.</p>';
												    unset($_SESSION['wrongpass']);
											}
											?>
										<label for="pass1">Mon nouveau mot de passe : </label><input type="password" name="pass1" id="pass1">
											<?php
											if(isset($_SESSION['invalidpass']))
											{
												    echo '<p style=color:red;>Le mot de passe saisi ne convient pas au format demandé.</p>';
												    unset($_SESSION['invalidpass']);
											}
											?>
										<label for="pass2">Confirmation du nouveau mot de passe :</label><input type="password" name="pass2" id="pass2">
											<?php
											if(isset($_SESSION['passnotmatching']))
											{
												    echo '<p style=color:red;>Les deux mots de passe saisis ne correspondent pas.</p>';
												    unset($_SESSION['passnotmatching']);
											}					
											?>										
									</div>
									<div class="update_profile_part2">
										<input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
										<label for="photo">Choisir une photo de profil : </label><input type="file" name="photo" id="photo"/>
									</div>							
								</div>
							<input type="submit" name="update_profile_submit" value="Modifier ces paramètres">
						</fieldset>
					</form>
				</section>
				<?php include("../includes/inc_footer.php"); ?>
			</body>
<?php
}
else // pas de connexion -> retour accueil
{
	header('Location: accueil.php');
}
?>
</html>