# GBAF
OpenClassRooms - Initiation Full Stack - Projet 3 GBAF

Exercice de programmation procédurale PHP & MySQL

Objectif :

Créer un site de partage d'informations sur différents acteurs du secteur bancaire.


Fonctionnalités :


Générales :

- Sytème d'inscription / connexion avec mot de passe

- Connexion obligatoire sans quoi aucun contenu n'est accessible (sauf Inscription / Contact / Mentions-Légales).


En-tête et pieds de page :

Chaque page inclut le même en-tête et pied de page.
Tant qu'il n'y a pas de connexion, l'en-tête inclut le logo GBAF à gauche, deux liens à droite : s'inscrire ou se connecter.
En cas de connexion active, logo de GBAF à gauche, photo de profil, nom, prénom utilisateur à droite avec bouton de déconnexion.
Le pied de page est statique peu importe l'état de la connexion, liens au centre vers pages de mentions-légales et contact.


Par page :

- Page de connexion : formulaire de connexion demandant l'indentifiant utilisateur et son mot de passe,
			liens vers la page d'inscription et vers la page de réinitialisation du mot de passe.

- Page d'inscripiton : formulaire d'inscription demandant nom, prénom, indentifiant utilisateur, mot de passe et confirmation du mot de passe, question secrète et réponse à la question secrète.
			L'identifiant est unique (vérification dans la base de données s'il n'est pas déjà existant),
			mot de passe avec format minimum imposé (8 caractères, une majuscule, un chiffre et un caractère spécial au minimum),
			mot de passe et réponse à la question secrète hashées avant écriture dans la base de données.

- Page de réinitialisation du mot de passe : formulaire de réinitialisation par étape,
						étape 1 : demande de l'identifiant (puis vérification de son existance)
						étape 2 : envoi de la question, formulaire demandant la réponse, le nouveau mot de passe et confirmation du mot de passe.
						étape 3 : si les informations sont valides, renvoi vers page de connexion, sinon message d'erreur.


- Page d'accueil : présentation de GBAF, introduction puis dresse une liste des acteurs à présenter avec un extrait de la description et lien vers la page complète.

- Page acteur : description complète d'un acteur, 
		nombre de recommandations pour cet acteur (like/dislike) et liste des utilisateurs ayant recommandé / déconseillé en infobulle, 
		possibilité d'ajouter une recommandation (unique) pour l'utilisateur en cours ou de la supprimer / inverser,
		possibilité d'ajouter un commentaire (unique) ou de le supprimer,
		liste des commentaires postés pour cet acteur, triés du plus ancien au plus récent, avec les références des utilisateurs ayant commenté.

- Page profil : rappel des informations de l'utilisateur en cours,
		possibilité de changer son identifiant utilisateur,
		possibilité de changer son mot de passe,
		possibilité de changer sa photo de profil (avec suppression de l'ancienne).

- Page de mentions-légales : vide par défaut.

- Page de contact : vide par défaut.


Structure :

Le dossier Inclues contient en-tête et pied-de page, ils seront appelés sur chaque page.
Le dossier Pages contient les différents pages du site (majoritairement en html et quelques conditions php), 
		un dossier logos qui contient les images fixes du site, 
		un dossier font pour les polices d'écriture,
		un dossier uploads pour stocker les photos de profil utilisateur.
Le dossier traitement contient tous les fichiers relatifs à l'execution de requêtes SQL et autres vérifications PHP qui seront appelées par les pages.


La Base de données :

Nom de la base de données : gbaf

Elle se découpe en 4 tables (account, actor, post, vote) :

-- Structure de la table `account` / Contient les informations utilisateurs
CREATE TABLE `account` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(127) NOT NULL,
  `prenom` varchar(127) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `question` varchar(255) NOT NULL,
  `reponse` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Structure de la table `actor` / Contient les informations qui concernent les acteurs à présenter
CREATE TABLE `actor` (
  `id_actor` int(11) NOT NULL,
  `actor` varchar(127) NOT NULL,
  `description` text NOT NULL,
  `logo` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Structure de la table `post` / Contient les commentaires
CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_actor` int(11) NOT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `post` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Structure de la table `vote` / Contient la liste des mentions "like" & "dislike"
CREATE TABLE `vote` (
  `id_vote` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_actor` int(11) NOT NULL,
  `vote` enum('like','dislike') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;