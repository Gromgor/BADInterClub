<?php

class Scores
{
    /**
     * @var object The database connection
     */
	public $errors = array();
	public $messages = array();
	
    private $db_connection = null;	
	private $det_id, $det_po, $det_serie, $det_set, $det_score;
	
	public function __construct($det_id){
		if($det_id) {
			$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (!$this->db_connection->connect_errno) {
				$this->det_id = $det_id;
				$sql = "SELECT * FROM details_scores WHERE det_id = '".$this->det_id."';";
				$result = $this->db_connection->query($sql);
				$result_row = $result->fetch_object();
			
				$this->det_serie = $result_row->det_serie;
				$this->det_set = $result_row->det_set;
				$this->det_score = $result_row->det_score;
			}
			$this->db_connection->close();
		}
	}
	
	public function __set($propriete, $valeur){
		if('id' === $propriete && ctype_digit($valeur)) {
			$this->det_id = (int) $valeur;  
		/*}elseif('club' === $propriete){
			$this->det_po = (int) $valeur; 
		}elseif('serie' === $propriete){
			$this->det_serie = $valeur; 
		}elseif('set' === $propriete){
			$this->det_set = (int) $valeur; 
		*/}elseif('score' === $propriete){
			$this->det_score = (int) $valeur; 
		} else {
			throw new Exception('Propriété ou valeur invalide !');
		}
	}
	
	public function __get($property) {
		if('id' === $property) {
			return $this->det_id;
		}elseif('club' === $property){
			return $this->det_po;
		}elseif('serie' === $property){
			return $this->det_serie;
		}elseif('set' === $property){
			return $this->det_set;
		}elseif('score' === $property){
			return $this->det_score;
		} else {
			throw new Exception('Propriété invalide !');
		}
	}
	
	public function updateScore(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "UPDATE details_scores SET 
				det_score='".$this->det_score."' 
				WHERE det_id=".$this->det_id.";";
				//$this->errors[] = $sql;
			$result = $this->db_connection->query($sql);
			$this->db_connection->close();
			//$this->messages[] = "Scores mis à jour.";
			return $result;
		}
		$this->db_connection->close();
	}
	
	public function getNewScore($id){
		$this->det_id = $id;
			$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (!$this->db_connection->connect_errno) {
				$sql = "SELECT * FROM details_scores WHERE det_id = '".$this->det_id."';";
				$result = $this->db_connection->query($sql);
				$result_row = $result->fetch_object();
			
				$this->det_serie = $result_row->det_serie;
				$this->det_set = $result_row->det_set;
				$this->det_score = $result_row->det_score;
			}
			$this->db_connection->close();
	}
	
	public function getEquipes(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT * FROM details_scores WHERE 1=1";
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
	
	public function updateMatchScores($scores){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "UPDATE details_scores SET 
				det_score='".$scores[0]."' 
				WHERE det_id=".$this->det_id.";";
				$this->errors[] = $sql;
			$result = $this->db_connection->query($sql);
			$this->db_connection->close();
			return $result;
		}
		$this->db_connection->close();		
	}
}
?>