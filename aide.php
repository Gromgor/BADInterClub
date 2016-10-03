<!DOCTYPE html><?php	include_once("config/config.php");?>
<html>
	<head>
		<title><?php echo SITE_TITRE_PAGES; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="style1.css">
		<link rel="stylesheet" type="text/css" href="style_menu_ic.css">
	</head>
	<body id="body_aide">
		<div id="wrapper-aide">
			<header>
				<?php echo SITE_TITRE_PAGES; ?><br/>Documentation
			</header>
			<?php include_once('menu.php'); ?>
			<!-- | <a href="input_scores2.php">Saisie des scores</a></p> -->
			<div id="panel-aide">
				<p><h1>Aide à l'utilisation de l'affichage pour Interclub</h1></p>
				<p>
					<ul>
					<li>
						<h2>Configuration d'une rencontre</h2>
						<br />
						Selon le niveau de la rencontre d'interclub (Nationale 2, Régionale 1, ...) l'affichage ne sera pas le même.<br />
						En effet, il peut y avoir 2 ou 4 équipes jouant simultanément.<br />
						Aussi, pour des besoins de lisibilités, on peut choisir d'afficher ou non, les logos des clubs, les victoires et modifier le style lui-même.<br />
						Pour cela il faut,<br />
						<ol>
							<li>Sur la page de <a href="gestion.php">gestion de la rencontre</a> cliquer sur "Afficher le paramétrage de l'affichage"<br />
								un panneau est alors affiché</li>
							<li>Sélectionner le type de rencontre (2 ou 4 équipes)</li>
							<li>Choisir d'afficher ou non les logos</li>
							<li>Choisir d'afficher ou non les victoires</li>
							<li>Choisir un style personalisé ou un style classic</li>
							<li>Enregistrer vos choix via le bouton "Mettre à jour"</li>
						</ol>
					</li>
					<li>
						<h2>Configuration des équipes</h2>
						<br />
						Les équipes d'une rencontre se gèrent en deux étapes distinct.<br />
						<ol>
							<li>La saisie des noms et logos</li>
							<li>La saisie des oppsisitions</li>
						</ol>
						<br />
						<h3>La saisie des noms et logos</h3>
						<br />
						La gestion des noms est simple, il suffit de les saisir dans la colonne "Club".<br />
						Si le logo est déjà présent, il suffit de le chercher dans la liste déroulante et le sélectionner.<br />
						Si celui-ci n'est pas/plus présent, il faut le télécharger dans l'application d'affichage.<br />
						Le téléchargement du logo se fait en plusieurs étapes :
						<br />
						<ol>
							<li>Cliquer sur le bouton "..." de l'équipe</li>
							<li>Chercher sur votre ordinateur le logo à téléchager</li>
							<li>Valider votre choix</li>
						</ol>
						<br />
						Une fois toutes les équipes saisies, cliquer sur le bouton "Mettre à jour".
						<br />
						<h3>La saisie des opositions</h3>
						<br />
						La saisie des oppositions (rencontres) se gère via l'ordre des équipes.<br />
						L'équipe en ordre 1 rencontrera l'équipe en ordre 2.<br />
						L'équipe en ordre 3 rencontrera l'équipe en ordre 4.<br />
						Pour gérer les rencontres, il faut saisir l'ordre d'affichage des équipes.<br />
						Une fois tous les ordres saisies, cliquer sur le bouton "Mettre à jour".
						<br />
						<br />
						Par convention, la rencontre affichée en haut sera jouée à gauche et la rencontre affichée en bas sera jouée à droite.
						<br />
					</li>
					<li>
						<h2>Administration des logos</h2>
						<br />
						Afin de garder des performances d'affichage convenable, il convient de supprimer les logos des clubs qui ne seront plus utiles sur la saison.<br />
						Depuis la page de <a href="gestion.php">gestion de la rencontre</a><br />
						<ol>
							<li>Cliquer sur "<a href="adm_logos.php">Administration logos</a>" </li>
							<li>Cliquer sur l'icône de corbeille du logo à supprimer</li>
						</ol>
						<br />
						<img src="./images/warning.png" /> Attention, la suppression est définitive !
						<br />
					</li>
				</p>
			</div>
		</div>
		<footer id="footer-aide">
			<?php include('config/version.php'); ?>
		</footer>
	</body>
</html>