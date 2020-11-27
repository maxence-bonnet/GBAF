<div class="header_content">
	<div class="logo_gbaf">
		<a href="accueil.php"><img src="../pages/logos/gbaf.png" title="GBAF"alt="GBAF logo"/></a>
	</div>
	<?php
		if(isset($_SESSION['username']) AND !empty($_SESSION['username'])) //si session active
		{
			try
			{
			$db = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
			}
			catch (Exception $e)
			{
			        die('Erreur : ' . $e->getMessage());
			}
			$nom = htmlspecialchars($_SESSION['last_name']);
			$prenom = htmlspecialchars($_SESSION['first_name']);
			$username = htmlspecialchars($_SESSION['username']);
			$result = $db->prepare('SELECT photo FROM account WHERE username = :username');
			$result->execute(array('username' => $username));
			$data = $result->fetch();
			$photo = htmlspecialchars($data['photo']); //éléments par défaut
			?>
			<div class="user_ref">
				<div class="user_photo">
					<a href="profil.php"><img src="uploads/<?php echo $photo ; ?>" alt="Ma photo de profil" title="Voir mon profil"/></a>
				</div>
				<div class="user_name">
					<a href="profil.php" title="Voir mon profil"><p><?php echo $prenom . ' ' . $nom; ?></p></a>
				</div>
				<form class="deconnection_form" action="../traitement/trait_deconnexion.php" method="post"><input type="submit" value="deconnexion"/></form>				
			</div>
			<?php
		}
		else // pas de session
		{
			?>
			<div class="inscription_link">
				<a href="inscription.php">S'inscrire</a><p>/</p><a href="accueil.php">Se connecter</a>
			</div>
			<?php
		}
	?>
</div>