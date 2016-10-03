<!DOCTYPE html>
<?php
	include_once("config/db.php");
	include_once("config/config.php");
	include_once("classes/Equipe.class.php");
	include_once("classes/Conf.class.php");
	
	$conf = new Global_Conf();
	$forteams = $conf->__get('4teams');
	$disp_victoire = $conf->__get('victoire');
	$victoire1 = "";
	$victoire2 = "";
	$victoire3 = "";
	$victoire4 = "";
	
	$equipe1 = new Equipe(1);
	$equipe2 = new Equipe(2);
	if($forteams){
		$equipe3 = new Equipe(3);
		$equipe4 = new Equipe(4);
	}
	
	if(isset($_POST['update'])){
		$equipe1->__set('score',$_POST['po_score1']);
		//$equipe1->__set('ordre',$_POST['po_ordre1']);
		if(isset($_POST['po_victoire1'])){
			$victoires = implode(" ",$_POST['po_victoire1']);
		$equipe1->__set('victoire',$victoires);
		}
		$equipe1->updateScore();
	//print_r($equipe1->errors);
		
		$equipe2->__set('score',$_POST['po_score2']);
		//$equipe2->__set('ordre',$_POST['po_ordre2']);
		if(isset($_POST['po_victoire2'])){
			$victoires = implode(" ",$_POST['po_victoire2']);
		$equipe2->__set('victoire',$victoires);
		}
		$equipe2->updateScore();
		
		if($forteams){
			$equipe3->__set('score',$_POST['po_score3']);
			//$equipe3->__set('ordre',$_POST['po_ordre3']);
			if(isset($_POST['po_victoire3'])){
				$victoires = implode(" ",$_POST['po_victoire3']);
			$equipe3->__set('victoire',$victoires);
			}
			$equipe3->updateScore();
		
			$equipe4->__set('score',$_POST['po_score4']);
			//$equipe4->__set('ordre',$_POST['po_ordre4']);
			if(isset($_POST['po_victoire4'])){
				$victoires = implode(" ",$_POST['po_victoire4']);
			$equipe4->__set('victoire',$victoires);
			}
			$equipe4->updateScore();
		}
		
		if(isset($_POST['po_victoire1'])){
			$victoire1 = implode(" ",$_POST['po_victoire1']);
		}
		if(isset($_POST['po_victoire2'])){
			$victoire2 = implode(" ",$_POST['po_victoire2']);
		}
		if(isset($_POST['po_victoire3'])){
			$victoire3 = implode(" ",$_POST['po_victoire3']);
		}
		if(isset($_POST['po_victoire4'])){
			$victoire4 = implode(" ",$_POST['po_victoire4']);
		}
		$line_victoires = $victoire1."|".$victoire2."|".$victoire3."|".$victoire4;
		$myfile = fopen("victoires.txt", "w") or die("Unable to open file!");
		fwrite($myfile, $line_victoires);
		fclose($myfile);
		
		$line_scores = $_POST['po_score1']."|".$_POST['po_score2']."|".@$_POST['po_score3']."|".@$_POST['po_score4'];
		$myfile = fopen("scores.txt", "w") or die("Unable to open file!");
		fwrite($myfile, $line_scores);
		fclose($myfile);
		
	}
	$equipe1 = new Equipe(1);
	$arr_victoires1 = explode(" ",$equipe1->__get('victoire'));
	$equipe2 = new Equipe(2);
	$arr_victoires2 = explode(" ",$equipe2->__get('victoire'));
	if($forteams){
		$equipe3 = new Equipe(3);
		$arr_victoires3 = explode(" ",$equipe3->__get('victoire'));
		$equipe4 = new Equipe(4);
		$arr_victoires4 = explode(" ",$equipe4->__get('victoire'));
	}
	//print_r($_POST);
?>
<html>
	<head>
		<title><?php echo SITE_TITRE_PAGES; ?> - Saisie</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="style1.css">
		<link rel="stylesheet" type="text/css" href="style_menu_ic.css">
	</head>
	<body>
	<div id="wrapper">
		<header>
			<?php echo SITE_TITRE_PAGES; ?><br/>Saisie des Victoires
		</header>
		<span id="debug"></span>
		<?php include_once('menu.php'); ?>
		<form method="post" action="">
		<div id="panel-score">
			<table>
				<tr>
					<th>Club</th><th>Score</th><!--<th>Ordre</th>--><?php if($disp_victoire){ echo "<th>Victoire</th>";} ?>
				</tr>
				<tr>
					<td><?php echo $equipe1->__get('club'); ?><input type="hidden" value="<?php echo $equipe1->__get('id'); ?>" name="po_id1" /></td>
					<td>
					<?php if($disp_victoire){ ?>
						<span id="score1"><?php echo $equipe1->__get('score'); ?></span>
						<input type="hidden" value="<?php echo $equipe1->__get('score'); ?>" name="po_score1"/>						
					<?php }else{ ?>
						<input type="number" value="<?php echo $equipe1->__get('score'); ?>" name="po_score1" pattern="[0-8]" required />						
					<?php } ?>
					</td>
					<!--<td><input type="number" value="<?php echo $equipe1->__get('ordre'); ?>" name="po_ordre1" pattern="[0-8]" required/></td>-->
					<?php if($disp_victoire){ ?>
					<td>
						<input type="checkbox" name="po_victoire1[]" value="SH1" <?php echo (in_array("SH1", $arr_victoires1) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SH1
						<input type="checkbox" name="po_victoire1[]" value="SH2" <?php echo (in_array("SH2", $arr_victoires1) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SH2
						<input type="checkbox" name="po_victoire1[]" value="SD1" <?php echo (in_array("SD1", $arr_victoires1) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SD1
						<input type="checkbox" name="po_victoire1[]" value="SD2" <?php echo (in_array("SD2", $arr_victoires1) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SD2
						<br />
						<input type="checkbox" name="po_victoire1[]" value="DH" <?php echo (in_array("DH", $arr_victoires1) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/> DH
						<input type="checkbox" name="po_victoire1[]" value="DD" <?php echo (in_array("DD", $arr_victoires1) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/> DD
						<input type="checkbox" name="po_victoire1[]" value="DX1" <?php echo (in_array("DX1", $arr_victoires1) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>DX1
						<input type="checkbox" name="po_victoire1[]" value="DX2" <?php echo (in_array("DX2", $arr_victoires1) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>DX2
					</td>
					<?php } ?>
				</tr>
				<tr>
					<td>contre</td>
					<td colspan=3>
						<!--
						
						-->
					</td>
				</tr>
				<tr>
					<td><?php echo $equipe2->__get('club'); ?><input type="hidden" value=<?php echo $equipe2->__get('id'); ?> name="po_id2" /></td>
					<td>
					<?php if($disp_victoire){ ?>
						<span id="score2"><?php echo $equipe2->__get('score'); ?></span>
						<input type="hidden" value="<?php echo $equipe2->__get('score'); ?>" name="po_score2"/>						
					<?php }else{ ?>
						<input type="number" value="<?php echo $equipe2->__get('score'); ?>" name="po_score2" pattern="[0-8]" required />						
					<?php } ?>
					</td>
					<!--<td><input type="number" value="<?php echo $equipe2->__get('ordre'); ?>" name="po_ordre2" pattern="[0-8]" required/></td>-->
					<?php if($disp_victoire){ ?>
					<td>
						<input type="checkbox" name="po_victoire2[]" value="SH1" <?php echo (in_array("SH1", $arr_victoires2) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SH1
						<input type="checkbox" name="po_victoire2[]" value="SH2" <?php echo (in_array("SH2", $arr_victoires2) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SH2
						<input type="checkbox" name="po_victoire2[]" value="SD1" <?php echo (in_array("SD1", $arr_victoires2) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SD1
						<input type="checkbox" name="po_victoire2[]" value="SD2" <?php echo (in_array("SD2", $arr_victoires2) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SD2
						<br />
						<input type="checkbox" name="po_victoire2[]" value="DH" <?php echo (in_array("DH", $arr_victoires2) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/> DH
						<input type="checkbox" name="po_victoire2[]" value="DD" <?php echo (in_array("DD", $arr_victoires2) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/> DD
						<input type="checkbox" name="po_victoire2[]" value="DX1" <?php echo (in_array("DX1", $arr_victoires2) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>DX1
						<input type="checkbox" name="po_victoire2[]" value="DX2" <?php echo (in_array("DX2", $arr_victoires2) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>DX2
					</td>
					<?php } ?>
				</tr>
			</table>
		</div>
				<?php
				if($forteams){
				?>
		<div id="panel-score">
			<table>
				<tr>
					<th>Club</th><th>Score</th><!--<th>Ordre</th><!--<th>Victoire</th>-->
				</tr>
				<tr>
					<td><?php echo $equipe3->__get('club'); ?><input type="hidden" value=<?php echo $equipe3->__get('id'); ?> name="po_id3" /></td>
					<td>
					<?php if($disp_victoire){ ?>
						<span id="score3"><?php echo $equipe3->__get('score'); ?></span>
						<input type="hidden" value="<?php echo $equipe3->__get('score'); ?>" name="po_score3"/>						
					<?php }else{ ?>
						<input type="number" value="<?php echo $equipe3->__get('score'); ?>" name="po_score3" pattern="[0-8]" required />						
					<?php } ?>
					</td>
					<!--<td><input type="number" value="<?php echo $equipe3->__get('ordre'); ?>" name="po_ordre3" pattern="[0-8]" required/></td>-->
					<?php if($disp_victoire){ ?>
					<td>
						<input type="checkbox" name="po_victoire3[]" value="SH1" <?php echo (in_array("SH1", $arr_victoires3) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SH1
						<input type="checkbox" name="po_victoire3[]" value="SH2" <?php echo (in_array("SH2", $arr_victoires3) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SH2
						<input type="checkbox" name="po_victoire3[]" value="SD1" <?php echo (in_array("SD1", $arr_victoires3) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SD1
						<input type="checkbox" name="po_victoire3[]" value="SD2" <?php echo (in_array("SD2", $arr_victoires3) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SD2
						<br />
						<input type="checkbox" name="po_victoire3[]" value="DH" <?php echo (in_array("DH", $arr_victoires3) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/> DH
						<input type="checkbox" name="po_victoire3[]" value="DD" <?php echo (in_array("DD", $arr_victoires3) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/> DD
						<input type="checkbox" name="po_victoire3[]" value="DX1" <?php echo (in_array("DX1", $arr_victoires3) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>DX1
						<input type="checkbox" name="po_victoire3[]" value="DX2" <?php echo (in_array("DX2", $arr_victoires3) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>DX2
					</td>
					<?php } ?>
				</tr>
				<tr>
					<td>contre</td>
					<td colspan=3>
					</td>
				</tr>
				<tr>
					<td><?php echo $equipe4->__get('club'); ?><input type="hidden" value=<?php echo $equipe4->__get('id'); ?> name="po_id4" /></td>
					<td>
					<?php if($disp_victoire){ ?>
						<span id="score4"><?php echo $equipe4->__get('score'); ?></span>
						<input type="hidden" value="<?php echo $equipe4->__get('score'); ?>" name="po_score4"/>						
					<?php }else{ ?>
						<input type="number" value="<?php echo $equipe4->__get('score'); ?>" name="po_score4" pattern="[0-8]" required />						
					<?php } ?>
					</td>
					<!--<td><input type="number" value="<?php echo $equipe4->__get('ordre'); ?>" name="po_ordre4" pattern="[0-8]" required/></td>-->
					<?php if($disp_victoire){ ?>
					<td>
						<input type="checkbox" name="po_victoire4[]" value="SH1" <?php echo (in_array("SH1", $arr_victoires4) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SH1
						<input type="checkbox" name="po_victoire4[]" value="SH2" <?php echo (in_array("SH2", $arr_victoires4) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SH2
						<input type="checkbox" name="po_victoire4[]" value="SD1" <?php echo (in_array("SD1", $arr_victoires4) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SD1
						<input type="checkbox" name="po_victoire4[]" value="SD2" <?php echo (in_array("SD2", $arr_victoires4) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>SD2
						<br />
						<input type="checkbox" name="po_victoire4[]" value="DH" <?php echo (in_array("DH", $arr_victoires4) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/> DH
						<input type="checkbox" name="po_victoire4[]" value="DD" <?php echo (in_array("DD", $arr_victoires4) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/> DD
						<input type="checkbox" name="po_victoire4[]" value="DX1" <?php echo (in_array("DX1", $arr_victoires4) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>DX1
						<input type="checkbox" name="po_victoire4[]" value="DX2" <?php echo (in_array("DX2", $arr_victoires4) ? "checked=\"checked\"" : "") ?> onclick="updateScore(this)"/>DX2
					</td>
					<?php } ?>
				</tr>
			</table>
		</div>
				<?php
				}
				?>
				<tr>
					<td colspan=4> </td>
				</tr>
				<tr>
					<td colspan=4><input type="submit" name="update" id="score_update" value="Enregistrer"/></td>
				</tr>
			</table>
		</form>
	</div>
		<footer id="footer-std">
			<?php include('config/version.php'); ?>
		</footer>
	</body>
	<script type="Text/JavaScript">
		function updateScore(MyCheckBox) {
			//var serie = MyCheckBox.value;
			var id = MyCheckBox.name.substr(11,1);
				if(MyCheckBox.checked){
					document.getElementsByName("po_score"+id)[0].value = parseInt(document.getElementsByName("po_score"+id)[0].value) + parseInt(1);
				}else{
					document.getElementsByName("po_score"+id)[0].value = parseInt(document.getElementsByName("po_score"+id)[0].value) - parseInt(1);
				}
				document.getElementById("score"+id).innerHTML = document.getElementsByName("po_score"+id)[0].value;
		}
		function check() {
			document.getElementById("myCheck").checked = true;
		}

		function uncheck() {
			document.getElementById("myCheck").checked = false;
		}
	</script>
</html>