<!DOCTYPE html>
<?php	include_once("config/db.php");	include_once("config/config.php");	include_once("classes/Equipe.class.php");	include_once("classes/Conf.class.php");
	$conf = new Global_Conf();
	$forteams = $conf->__get('4teams');	
	$equipe1 = new Equipe(1);
	$equipe2 = new Equipe(2);
	if($forteams){
		$equipe3 = new Equipe(3);
		$equipe4 = new Equipe(4);
	}	
	if(isset($_POST['update_test'])){
		if($_POST['conf_victoire'] && $conf->__get('victoire') != $_POST['conf_victoire']){
			$equipe1->updateEquipe();
			$equipe2->updateEquipe();
			if($forteams){
				$equipe3->updateEquipe();
				$equipe4->updateEquipe();
			}
		}		
		$conf->__set('4teams',$_POST['conf_4teams']);
		$conf->__set('logo',$_POST['conf_logo']);
		$conf->__set('display',$_POST['conf_display']);
		$conf->__set('victoire',$_POST['conf_victoire']);
		$conf->__set('scores',0); //$_POST['conf_scores']);
		//$conf->__set('reload',1);
		$conf->updateConfig();		
		$myfile = fopen("reload.txt", "w") or die("Unable to open file!");
		fwrite($myfile, "reload");
		fclose($myfile);
	}
	$forteams = $conf->__get('4teams');
	$equipe1 = new Equipe(1);
	$equipe2 = new Equipe(2);
	if($forteams){
		$equipe3 = new Equipe(3);
		$equipe4 = new Equipe(4);
	}
	$list_dir = scandir("./logos/");
?>
<html>
	<head>
		<title><?php echo SITE_TITRE_PAGES; ?> - Paramétrage</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="style1.css">
		<link rel="stylesheet" type="text/css" href="style_menu_ic.css">
	</head>
	<body>
	<div id="wrapper">
		<header>
			<?php echo SITE_TITRE_PAGES; ?><br/>Paramétrage
		</header>
		<?php
			include_once('menu.php');
			if(!empty($conf->errors)){
				echo "<div id=\"panel-config\">";
				foreach($conf->errors as $error){
					echo $error."<br />";
				}
				echo "</div>";
			}
			if(!empty($conf->messages)){
				echo "<div id=\"panel-score\">";
				foreach($conf->messages as $message){
					echo $message."<br />";
				}
				echo "</div>";
			}
		?>
		<div id="panel-config">
			Configuration
			<br /><br />
			<form method="post" action="">
				<table>
					<tr>
						<th>Type de rencontre</th><th>Affichage Logo</th><th>Style</th><th>Affichage Victoires</th><!-- <th>Affichage Scores</th> -->
					</tr>
					<tr>
						<td>
							<input type="radio" name="conf_4teams" value="1" <?php echo ($conf->__get('4teams') ? "checked" : "") ?>> 4 équipes<br>
							<input type="radio" name="conf_4teams" value="0" <?php echo ($conf->__get('4teams') ? "" : "checked") ?>> 2 équipes<br>
						</td>
						<td>
							<input type="radio" name="conf_logo" value="1" <?php echo ($conf->__get('logo') ? "checked" : "") ?>> Oui<br>
							<input type="radio" name="conf_logo" value="0" <?php echo ($conf->__get('logo') ? "" : "checked") ?>> Non<br>
						</td>
						<td>
							<input type="radio" name="conf_display" value="0" <?php echo ($conf->__get('display') ? "" : "checked") ?>> NUC<br>
							<input type="radio" name="conf_display" value="1" <?php echo ($conf->__get('display') ? "checked" : "") ?>> TS <br>
						</td>
						<td>
							<input type="radio" name="conf_victoire" value="1" <?php echo ($conf->__get('victoire') ? "checked" : "") ?>> Oui <br>
							<input type="radio" name="conf_victoire" value="0" <?php echo ($conf->__get('victoire') ? "" : "checked") ?>> Non<br>
						</td>
						<!--
						<td>
							<input type="radio" name="conf_scores" value="1" <?php echo ($conf->__get('scores') ? "checked" : "") ?>> Oui <br>
							<input type="radio" name="conf_scores" value="0" <?php echo ($conf->__get('scores') ? "" : "checked") ?>> Non<br>
						</td>
						-->
					</tr>
					<tr>
						<td colspan=5><input type="submit" name="update_test" value="Mettre à jour"/></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
		<footer id="footer-std">
			<?php include('config/version.php'); ?>
		</footer>
	</body>
</html>