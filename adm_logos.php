<!DOCTYPE html>
<?php
	include_once("config/config.php");
	
	$dir = "./logos/";
	$list_dir = scandir($dir);
	if(isset($_GET["ind"])){
		$ind = $_GET["ind"];
		$logo_suppr = $list_dir[$ind];
		unlink($dir.$list_dir[$ind]);
	}
	$list_dir = scandir($dir);
?>
<html>
	<head>
		<title><?php echo SITE_TITRE_PAGES; ?> - Administration</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="style1.css" />
		<link rel="stylesheet" type="text/css" href="style_menu_ic.css">
	</head>
	<body>
	
	<div id="wrapper">
		<header>
			<?php echo SITE_TITRE_PAGES; ?><br/>Administration logos
		</header>
		<?php include_once('menu.php'); ?>
		<div id="panel-equipe">
			Gestion des logos
			<br />
			<br />
			<?php if(isset($_GET["ind"])){ echo "Le logo ".$logo_suppr." à été supprimé."; } ?>
			<br />
			<br />
			<table id="adm_logos">
				<?php
					for($i=2;$i<count($list_dir);$i++) {
						echo "<tr>";
							echo "<td><img src='./logos/".$list_dir[$i]."' /></td><td>".$list_dir[$i]."</td><td><a href='adm_logos.php?ind=".$i."'><img src='./images/delete.png' /></a></td>";
						echo "</tr>";
					}
				?>
			</table>
		</div>
	</div>
		<footer id="footer-std">
			<?php include('config/version.php'); ?>
		</footer>
	</body>
</html>