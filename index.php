<!DOCTYPE html>
<?php	include_once("config/db.php");	include_once("config/config.php");	include_once("classes/Equipe.class.php");	include_once("classes/Conf.class.php");
	$conf = new Global_Conf();
	$forteams = $conf->__get('4teams');
	$disp_logo = $conf->__get('logo');
	$type = $conf->__get('display');
	$disp_victoire = $conf->__get('victoire');	
	$equipe1 = new Equipe(1);
	$equipe2 = new Equipe(2);
	$equipe3 = new Equipe(3);	$equipe4 = new Equipe(4);	
	$myfile = fopen("reload.txt", "w") or die("Unable to open file!");
		fwrite($myfile, "");
		fclose($myfile);
?>
<html>
	<head>
		<title><?php echo SITE_TITRE_PAGES; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<?php
			switch ($type) {
				case 0:
					echo '<link rel="stylesheet" type="text/css" href="style1.css">';
					break;
				case 1:
					echo '<link rel="stylesheet" type="text/css" href="style2.css">';
					break;
				default:
					echo '<link rel="stylesheet" type="text/css" href="style1.css">';				
			}
		?>
		<link rel="stylesheet" type="text/css" href="style_add.css">
	</head>
	<body onload="loadScores(); loadVictoires(); reloadPage();">
		<?php if($forteams){ ?>
		<table id="index3">
		<?php }else{ ?>
		<table id="index2">
		<?php } ?>
			<tr>
				<?php
					if($disp_logo){
						echo "<td><img src=\"logos/".$equipe1->__get('logo')."\" /></td>";
					}
				?>
				<td><?php echo $equipe1->__get('club'); ?></td>
				<td id="score1">0</td>
				<?php
					if($disp_victoire){
						echo "<td><span class=\"victoire\" id=\"victoire1\"></span></td>";
					}
				?>
			</tr>
			<tr>
				<?php
					if($disp_logo){
						echo "<td><img src=\"logos/".$equipe2->__get('logo')."\" /></td>";
					}
				?>
				<td><?php echo $equipe2->__get('club'); ?></td>
				<td id="score2">0</td>
				<?php
					if($disp_victoire){
						echo "<td><span class=\"victoire\" id=\"victoire2\"></span></td>";
					}
				?>
			</tr>
			<?php if($forteams){ ?>
			<tr>
				<?php
					if($disp_logo){
						echo "<td><img src=\"logos/".$equipe3->__get('logo')."\" /></td>";
					}
				?>
				<td><?php echo $equipe3->__get('club'); ?></td>
				<td id="score3">0</td>
				<?php
					if($disp_victoire){
						echo "<td><span class=\"victoire\" id=\"victoire3\"></span></td>";
					}
				?>
			</tr>
			<tr>
				<?php
					if($disp_logo){
						echo "<td><img src=\"logos/".$equipe4->__get('logo')."\" /></td>";
					}
				?>
				<td><?php echo $equipe4->__get('club'); ?></td>
				<td id="score4">0</td>
				<?php
					if($disp_victoire){
						echo "<td><span class=\"victoire\" id=\"victoire4\"></span></td>";
					}
				?>
			</tr>
			<?php } ?>
		</table>
		<!-- 
		<footer id="footer-index">
			<?php include('config/version.php'); ?>
		</footer>
		-->
</body>
		<script>
			function loadScores() {
				var xmlhttp;
				if (window.XMLHttpRequest) {
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for older browsers
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("score1").innerHTML = xmlhttp.responseText.split("|")[0];
						document.getElementById("score2").innerHTML = xmlhttp.responseText.split("|")[1];
						document.getElementById("score3").innerHTML = xmlhttp.responseText.split("|")[2];
						document.getElementById("score4").innerHTML = xmlhttp.responseText.split("|")[3];
					}
				};
				xmlhttp.open("GET", "scores.txt", true);
				xmlhttp.send();
				setTimeout(loadScores, 5000);
			}			
			function loadVictoires() {
				var xmlhttp;
				if (window.XMLHttpRequest) {
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for older browsers
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("victoire1").innerHTML = xmlhttp.responseText.split("|")[0];
						document.getElementById("victoire2").innerHTML = xmlhttp.responseText.split("|")[1];
						document.getElementById("victoire3").innerHTML = xmlhttp.responseText.split("|")[2];
						document.getElementById("victoire4").innerHTML = xmlhttp.responseText.split("|")[3];
					}
				};
				xmlhttp.open("GET", "victoires.txt", true);
				xmlhttp.send();
				setTimeout(loadVictoires, 5000);
			}			
			function reloadPage() {
				var xmlhttp;
				if (window.XMLHttpRequest) {
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for older browsers
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						//document.getElementById("debug").innerHTML = xmlhttp.responseText;
						if (xmlhttp.responseText == "reload")
							location.reload(true);
					}
				};
				xmlhttp.open("GET", "reload.txt", true);
				xmlhttp.send();
				setTimeout(reloadPage, 5000);
			}
		</script>
</html>
