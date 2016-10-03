<?php

class Match
{
    /**
     * @var object The database connection
     */
	public $errors = array();
	public $messages = array();
	
    private $db_connection = null;	
	private $mat_id, $mat_ordre, $mat_serie, $mat_joueur1, $mat_joueur2, $mat_joueur3, $mat_joueur4, $mat_vainc;
	
	public function __construct($mat_ordre){
		if($mat_ordre) {
			$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (!$this->db_connection->connect_errno) {
				$this->mat_ordre = $mat_ordre;
				$sql = "SELECT * FROM details_match WHERE mat_ordre = '".$this->mat_ordre."';";
				$result = $this->db_connection->query($sql);
				$result_row = $result->fetch_object();
			
				$this->mat_id = $result_row->mat_id;
				$this->mat_serie = $result_row->mat_serie;
				$this->mat_joueur1 = $result_row->mat_joueur1;
				$this->mat_joueur2 = $result_row->mat_joueur2;
				$this->mat_joueur3 = $result_row->mat_joueur3;
				$this->mat_joueur4 = $result_row->mat_joueur4;
				$this->mat_vainc = $result_row->mat_vainc;
			}
			$this->db_connection->close;
		}
	}
	
	public function __set($propriete, $valeur){
		if('id' === $propriete && ctype_digit($valeur)) {
			$this->mat_id = (int) $valeur;  
		}elseif('ordre' === $propriete){
			$this->mat_ordre = (int) $valeur; 
		}elseif('serie' === $propriete){
			$this->mat_serie = $valeur; 
		}elseif('j1' === $propriete){
			$this->mat_joueur1 = $valeur; 
		}elseif('j2' === $propriete){
			$this->mat_joueur2 = $valeur; 
		}elseif('j3' === $propriete){
			$this->mat_joueur3 = $valeur; 
		}elseif('j4' === $propriete){
			$this->mat_joueur4 = $valeur; 
		}elseif('vainc' === $propriete){
			$this->mat_vainc = (int) $valeur; 
		} else {
			throw new Exception('Propriété ou valeur invalide !');
		}
	}
	
	public function __get($property) {
		if('id' === $property) {
			return $this->mat_id;
		}elseif('ordre' === $property){
			return $this->mat_ordre;
		}elseif('serie' === $property){
			return $this->mat_serie;
		}elseif('j1' === $property){
			return $this->mat_joueur1;
		}elseif('j2' === $property){
			return $this->mat_joueur2;
		}elseif('j3' === $property){
			return $this->mat_joueur3;
		}elseif('j4' === $property){
			return $this->mat_joueur4;
		}elseif('vainc' === $property){
			return $this->mat_vainc;
		} else {
			throw new Exception('Propriété invalide !');
		}
	}
	
	public function updateMatch(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "UPDATE details_match SET 
				mat_ordre='".$this->mat_ordre."' , 
				mat_joueur1='".$this->mat_joueur1."' , 
				mat_joueur2='".$this->mat_joueur2."' , 
				mat_vainc='".$this->mat_vainc."' 
				WHERE mat_id=".$this->mat_id.";";
				$this->errors[] = $sql;
			$result = $this->db_connection->query($sql);
			$this->db_connection->close();
			return $result;
		}
		$this->db_connection->close();
	}
}