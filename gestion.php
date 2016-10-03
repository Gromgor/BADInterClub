<!DOCTYPE html>
<?php
	include_once("config/db.php");
	include_once("config/config.php");
	include_once("classes/Equipe.class.php");
	include_once("classes/Conf.class.php");
	
	$conf = new Global_Conf();
	$forteams = $conf->__get('4teams');
	$arr_errors = array();
	$arr_messages = array();
	
	$equipe1 = new Equipe(1);
	$equipe2 = new Equipe(2);
	if($forteams){
		$equipe3 = new Equipe(3);
		$equipe4 = new Equipe(4);
	}
	
	if(isset($_POST['update'])){
		
		$equipe1->__set('club',$_POST['po_club1']);
		$equipe1->__set('logo',$_POST['po_logo1']);
		$equipe1->__set('image',$_FILES['po_image1']);
		$equipe1->__set('ordre',$_POST['po_ordre1']);
		$equipe1->updateEquipe();
		$arr_messages[] = $equipe1->messages;
		
		$equipe2->__set('club',$_POST['po_club2']);
		$equipe2->__set('logo',$_POST['po_logo2']);
		$equipe2->__set('image',$_FILES['po_image2']);
		$equipe2->__set('ordre',$_POST['po_ordre2']);
		$equipe2->updateEquipe();
		$arr_messages[] = $equipe2->messages;
		//print_r($messages);
		
		if($forteams){
			$equipe3->__set('club',$_POST['po_club3']);
			$equipe3->__set('logo',$_POST['po_logo3']);
			$equipe3->__set('image',$_FILES['po_image3']);
			$equipe3->__set('ordre',$_POST['po_ordre3']);
			$equipe3->updateEquipe();
			$arr_messages[] = $equipe3->messages;
		
			$equipe4->__set('club',$_POST['po_club4']);
			$equipe4->__set('logo',$_POST['po_logo4']);
			$equipe4->__set('image',$_FILES['po_image4']);
			$equipe4->__set('ordre',$_POST['po_ordre4']);
			$equipe4->updateEquipe();
			$arr_messages[] = $equipe4->messages;
		}
		$myfile = fopen("scores.txt", "w") or die("Unable to open file!");
		fwrite($myfile, "0|0|0|0");
		fclose($myfile);
		
		$myfile = fopen("victoires.txt", "w") or die("Unable to open file!");
		fwrite($myfile, "|||");
		fclose($myfile);		
		
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
		<title><?php echo SITE_TITRE_PAGES; ?> - Gestion</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="style1.css">
		<link rel="stylesheet" type="text/css" href="style_menu_ic.css">
	</head>
	<body>
	
	<div id="wrapper">
		<header>
			<?php echo SITE_TITRE_PAGES; ?><br/>Gestion de la rencontre
		</header>
		<?php 
			include_once('menu.php');
			if(!empty($equipe1->errors)){
				echo "<div id=\"panel-config\">";
				$eqp=1;
				foreach($equipe1->errors as $error){
					echo $error."<br />";
				}
				echo "</div>";
			}
			if(!empty($arr_messages)){
				echo "<div id=\"panel-score\">";
				$eqp=1;
				foreach($arr_messages as $messages){
					foreach($messages as $message){
						echo "Equipe ".$eqp." ".$message."<br />";
					}
					$eqp++;
				}
				echo "</div>";
			}
		?>
		<div id="panel-equipe">
			Gestion des équipes
			<br />
			<br />
			<form method="post" action="" enctype="multipart/form-data">
							<input type="hidden" name="MAX_FILE_SIZE" value="" />
				<table>
					<tr>
						<th></th><th>Club</th><th>Logo</th><th>Ordre</th>
					</tr>
					<tr>
						<td>Equipe 1</td>
						<td>
							<input type="text" value="<?php echo $equipe1->__get('club'); ?>" name="po_club1" required/>
							<input type="hidden" value="<?php echo $equipe1->__get('id'); ?>" name="po_id1" />
						</td>
						<td>
							<select name="po_logo1">
								<option>...</option>
								<?php
								for($p=2;$p<=count($list_dir)-1;$p++){
									if($list_dir[$p] == $equipe1->__get('logo')){
										echo "<option value='".$list_dir[$p]."' selected>".$list_dir[$p]."</option>";
									}else{
										echo "<option value='".$list_dir[$p]."'>".$list_dir[$p]."</option>";
									}
								}
								?>
							</select>
							<!-- <input type="text" value="<?php echo $equipe1->__get('logo'); ?>" name="po_logo1" /> -->
							<label for="po_image1" class="bouton">...</label>
							<input type="file" value="<?php echo $equipe1->__get('logo'); ?>" id="po_image1" name="po_image1" accept=".jpg,.jpeg,.png" class="hidefile" />
						</td>
						<td>
							<input type="number" value="<?php echo $equipe1->__get('ordre'); ?>" name="po_ordre1" pattern="[1-4]" required/>
						</td>
					</tr>
					<tr>
						<td colspan=4> </td>
					</tr>
					<tr>
						<td>Equipe 2</td>
						<td>
							<input type="text" value="<?php echo $equipe2->__get('club'); ?>" name="po_club2" required/>
							<input type="hidden" value="<?php echo $equipe2->__get('id'); ?>" name="po_id2" />
						</td>
						<td>
							<select name="po_logo2">
								<option>...</option>
								<?php
								for($p=2;$p<=count($list_dir)-1;$p++){
									if($list_dir[$p] == $equipe2->__get('logo')){
										echo "<option value='".$list_dir[$p]."' selected>".$list_dir[$p]."</option>";
									}else{
										echo "<option value='".$list_dir[$p]."'>".$list_dir[$p]."</option>";
									}
								}
								?>
							</select>
							<!-- 
							<input type="text" value="<?php echo $equipe2->__get('logo'); ?>" name="po_logo2" />
							-->
							<label for="po_image2" class="bouton">...</label>
							<input type="file" value="<?php echo $equipe2->__get('logo'); ?>" id="po_image2" name="po_image2" accept=".jpg,.jpeg,.png" class="hidefile" />
						</td>
						<td>
							<input type="number" value="<?php echo $equipe2->__get('ordre'); ?>" name="po_ordre2" pattern="[1-4]" required/>
						</td>
					</tr>
				<?php
				if($forteams){
				?>
					<tr>
						<td colspan=4> </td>
					</tr>
					<tr>
						<td>Equipe 3</td>
						<td>
							<input type="text" value="<?php echo $equipe3->__get('club'); ?>" name="po_club3" required/>
							<input type="hidden" value="<?php echo $equipe3->__get('id'); ?>" name="po_id3" />
						</td>
						<td>
							<select name="po_logo3">
								<option>...</option>
								<?php
								for($p=2;$p<=count($list_dir)-1;$p++){
									if($list_dir[$p] == $equipe3->__get('logo')){
										echo "<option value='".$list_dir[$p]."' selected>".$list_dir[$p]."</option>";
									}else{
										echo "<option value='".$list_dir[$p]."'>".$list_dir[$p]."</option>";
									}
								}
								?>
							</select>
							<!-- 
							<input type="text" value="<?php echo $equipe3->__get('logo'); ?>" name="po_logo3" />
							-->
							<label for="po_image3" class="bouton">...</label>
							<input type="file" value="<?php echo $equipe3->__get('logo'); ?>" id="po_image3" name="po_image3" accept=".jpg,.jpeg,.png" class="hidefile" />
						</td>
						<td>
							<input type="number" value="<?php echo $equipe3->__get('ordre'); ?>" name="po_ordre3" pattern="[1-4]" required/>
						</td>
					</tr>
					<tr>
						<td colspan=4> </td>
					</tr>
					<tr>
						<td>Equipe 4</td>
						<td>
							<input type="text" value="<?php echo $equipe4->__get('club'); ?>" name="po_club4" required/>
							<input type="hidden" value="<?php echo $equipe4->__get('id'); ?>" name="po_id4" />
						</td>
						<td>
							<select name="po_logo4">
								<option>...</option>
								<?php
								for($p=2;$p<=count($list_dir)-1;$p++){
									if($list_dir[$p] == $equipe4->__get('logo')){
										echo "<option value='".$list_dir[$p]."' selected>".$list_dir[$p]."</option>";
									}else{
										echo "<option value='".$list_dir[$p]."'>".$list_dir[$p]."</option>";
									}
								}
								?>
							</select>
							<!-- 
							<input type="text" value="<?php echo $equipe4->__get('logo'); ?>" name="po_logo4" />
							-->
							<label for="po_image4" class="bouton">...</label>
							<input type="file" value="<?php echo $equipe4->__get('logo'); ?>" id="po_image4" name="po_image4" accept=".jpg,.jpeg,.png" class="hidefile" />
						</td>
						<td>
							<input type="number" value="<?php echo $equipe4->__get('ordre'); ?>" name="po_ordre4" pattern="[1-4]" required/>
						</td>
					</tr>
				<?php
				}
				?>
					<tr>
						<td colspan=4> </td>
					</tr>
					<tr>
						<td colspan=4><input type="submit" name="update" value="Mettre à jour"/></td>
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