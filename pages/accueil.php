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
		<div class="content accueil_content">
		<?php
		if(isset($_SESSION['username']) AND !empty($_SESSION['username']))
		{
			?>
			<section class="presentation_section">
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
			</section>

			<section class="actors_list_section">
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
								    		<div class="actor_logo"><img src="logos/<?= $data['logo']; ?>" alt="logo <?= $data['actor']; ?>"></div>
								    			<div class="actor_description">
									    			<h3><?= $data['actor']; ?></h3>									    			
									    			<p><?php /* boucle pour écrire les 25 premiers mots pour un rendu plus homogène, si on veut exactement la première phrase on demande d'afficher $phrase où $phrase = strtok($content,"."); mais résultat pas terrible si phrase trop courte. */
									    			$i = 0;
									    			while($i < 25)
									    			{
									    				echo $extract[$i] . ' ';
									    				$i++;
									    			}
									    			?>... </p><p>Vers le site de <a class="actor_external_link" href="#"><?= $data['actor']?></a></p>
									    		</div>
									    	</div>
									    	<a class="actor_read_more" href="acteur.php?act=<?= $data['id_actor']; ?>">Lire la suite</a>
								    </div>
							<?php
						}
						$result->closeCursor();
					?>
			</section>
		<?php
		}
		else
		{
			header('Location: connexion.php');
		}
	?>
		</div>
		<?php include("../includes/inc_footer.php"); ?>
	</body>
</html>