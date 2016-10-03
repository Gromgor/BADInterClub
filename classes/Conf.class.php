<?php

class Global_Conf
{
    /**
     * @var object The database connection
     */
	public $errors = array();
	public $messages = array();
	
    private $db_connection = null;
	private $conf_reload, $conf_logo, $conf_forteams, $conf_display, $conf_victoire, $conf_scores;
	
	public function __construct(){
			$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (!$this->db_connection->connect_errno) {
				$sql = "SELECT * FROM conf;";
				$result = $this->db_connection->query($sql);
				$result_row = $result->fetch_object();
			
				$this->conf_reload = $result_row->conf_reload;
				$this->conf_logo = $result_row->conf_logo;
				$this->conf_forteams = $result_row->conf_forteams;
				$this->conf_display = $result_row->conf_display;
				$this->conf_victoire = $result_row->conf_victoire;
				$this->conf_scores = $result_row->conf_scores;
			}
			$this->db_connection->close();
	}
	
	public function __set($propriete, $valeur){
		if('logo' === $propriete){
			$this->conf_logo = $valeur; 
		}elseif('display' === $propriete){
			$this->conf_display = $valeur; 
		}elseif('reload' === $propriete){
			$this->conf_reload = $valeur; 
		}elseif('4teams' === $propriete){
			$this->conf_forteams = $valeur;
		}elseif('victoire' === $propriete){
			$this->conf_victoire = $valeur;
		}elseif('scores' === $propriete){
			$this->conf_scores = $valeur;
		} else {
			throw new Exception('Propriété ou valeur invalide !');
		}
	}
	
	public function __get($property) {
		if('logo' === $property){
			return $this->conf_logo;
		}elseif('reload' === $property){
			return $this->conf_reload;
		}elseif('logo' === $property){
			return $this->po_disp_logo;
		}elseif('4teams' === $property){
			return $this->conf_forteams;
		}elseif('display' === $property){
			return $this->conf_display;
		}elseif('victoire' === $property){
			return $this->conf_victoire;
		}elseif('scores' === $property){
			return $this->conf_scores;
		} else {
			throw new Exception('Propriété invalide !');
		}
	}
	
	public function updateConfig(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "UPDATE conf SET 
				conf_reload='".$this->conf_reload."'
				, conf_logo='".$this->conf_logo."'
				, conf_forteams='".$this->conf_forteams."'
				, conf_display='".$this->conf_display."'
				, conf_victoire='".$this->conf_victoire."'
				, conf_scores='".$this->conf_scores."'
				;";
			if($result = $this->db_connection->query($sql)){				$this->messages[] = "Configuration mise à jour.";			}else{				$this->errors[] = $sql;				$this->errors[] = "La configuration n'a pas pu être mise à jour !";			}
			$this->db_connection->close();
			return $result;
		}
		$this->db_connection->close();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}