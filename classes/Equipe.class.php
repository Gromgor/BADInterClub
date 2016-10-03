<?php

class Equipe
{
    /**
     * @var object The database connection
     */
	public $errors = array();
	public $messages = array();
	
    private $db_connection = null;	
	private $po_id, $po_club, $po_logo, $po_score, $po_ordre, $po_victoire, $po_reload, $po_disp_logo, $po_disp_4teams, $po_image;
	
	public function __construct($id=0){
		if($id != 0) {
			$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (!$this->db_connection->connect_errno) {
				$this->po_ordre = $id;
				$sql = "SELECT * FROM playoff WHERE po_ordre = '".$this->po_ordre."';";
				$result = $this->db_connection->query($sql);
				$result_row = $result->fetch_object();
			
				$this->po_id = $result_row->po_id;
				$this->po_club = $result_row->po_club;
				$this->po_logo = $result_row->po_logo;
				$this->po_score = $result_row->po_score;
				$this->po_ordre = $result_row->po_ordre;
				$this->po_victoire = $result_row->po_victoire;			
				$this->po_reload = $result_row->po_reload;
				$this->po_disp_logo = $result_row->po_disp_logo;
				$this->po_disp_4teams = $result_row->po_disp_4teams;
			}
			$this->db_connection->close();
		}
	}
	
	public function __set($propriete, $valeur){
		if('id' === $propriete && ctype_digit($valeur)) {
			$this->po_id = (int) $valeur;  
		}elseif('club' === $propriete){
			$this->po_club = $valeur; 
		}elseif('logo' === $propriete){
			$this->po_logo = $valeur; 
		}elseif('score' === $propriete){
			$this->po_score = $valeur; 
		}elseif('ordre' === $propriete && ctype_digit($valeur)) {
			$this->po_ordre = (int) $valeur;
		}elseif('victoire' === $propriete) {
			$this->po_victoire = $valeur;
		}elseif('reload' === $propriete){
			$this->po_reload = $valeur; 
		}elseif('disp_logo' === $propriete){
			$this->po_disp_logo = $valeur; 
		}elseif('4teams' === $propriete){
			$this->po_disp_4teams = $valeur;
		}elseif('image' === $propriete){
			$this->po_image = $valeur;
		} else {
			throw new Exception('Propriété ou valeur invalide !');
		}
	}
	
	public function __get($property) {
		if('id' === $property) {
			return $this->po_id;
		}elseif('club' === $property){
			return $this->po_club;
		}elseif('logo' === $property){
			return $this->po_logo;
		}elseif('score' === $property){
			return $this->po_score;
		}elseif('ordre' === $property){
			return $this->po_ordre;
		}elseif('victoire' === $property){
			return $this->po_victoire;
		}elseif('reload' === $property){
			return $this->po_reload;
		}elseif('disp_logo' === $property){
			return $this->po_disp_logo;
		}elseif('4teams' === $property){
			return $this->po_disp_4teams;
		} else {
			throw new Exception('Propriété invalide !');
		}
	}
	
	public function updateScore(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "UPDATE playoff SET 
				po_score='".$this->po_score."'
				, po_victoire='".$this->po_victoire."'
				WHERE po_id=".$this->po_id.";";
				$this->errors[] = $sql;
			$result = $this->db_connection->query($sql);
			$this->db_connection->close();
			return $result;
		}
		$this->db_connection->close();
	}
	
	public function updateEquipe(){
		if($this->po_image['error']==0){
			$extension_upload = strtolower(  substr(  strrchr($this->po_image['name'], '.')  ,1)  );
			$nom = strtolower($this->po_club).".".$extension_upload;
			
			$resultat = move_uploaded_file($this->po_image['tmp_name'],"logos/".$nom);
			if (!$resultat) {
				$this->errors[] =  "Download unsuccessfull.";
			}else{
				$this->po_logo = $nom;
				$this->messages[] = "Logo mis à jour.";
			}
		}
		if($this->po_logo=="..."){
			$this->po_logo=LOGO_DEFAULT;
		}
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "UPDATE playoff SET 
				po_club='".$this->po_club."'
				, po_logo='".$this->po_logo."'
				, po_score=0
				, po_ordre='".$this->po_ordre."'
				, po_victoire=''
				WHERE po_id=".$this->po_id.";";
			if($result = $this->db_connection->query($sql)){
				$this->messages[] = " mise à jour.";
			}else{
				$this->errors[] = $sql;
				$this->errors[] = " non mise à jour !";
			}
			$this->db_connection->close();
			return $result;
		}
		$this->db_connection->close();
	}
	
	public function updateConfig(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "UPDATE playoff SET 
				po_disp_4teams='".$this->po_disp_4teams."'
				, po_disp_logo='".$this->po_disp_logo."'
				, po_reload='".$this->po_reload."'
				WHERE po_id=1;";
				//$this->errors[] = $sql;
			$result = $this->db_connection->query($sql);
			$this->db_connection->close();
			return $result;
		}
		$this->db_connection->close();
	}
	
	
	public function getEquipes(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT * FROM playoff WHERE 1=1";
			$i=0;
			if($result = $this->db_connection->query($sql)){
				$all = array();
				while($obj = $result->fetch_object()){
					$all[$i] = $obj;
					$i++;
				}
				$result->close();
				return $all;
			}
			return array();
		}
		$this->db_connection->close();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>