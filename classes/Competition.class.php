<?php

class Competition
{
    /**
     * @var object The database connection
     */
	public $errors = array();
	public $messages = array();
	
    private $db_connection = null;	
	private $comp_id, $comp_tournoi, $comp_licence, $comp_joueur, $comp_sexe, $comp_simple, $comp_double, $comp_mixte, $comp_cout, $comp_remb, $comp_type, $comp_paye;
	private $sol_licence, $sol_joueur, $sol_due, $sol_paye, $sol_rest, $sol_gp, $sol_tour, $sol_regl;
	private $exe_raison;
	private $nb_gp=0;
	private $nb_tour=0;
	
	public function __construct($id=0){
		if($id != 0) {
			$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (!$this->db_connection->connect_errno) {
				$this->comp_id = $id;
				$sql = "SELECT * FROM competition, solde_comp WHERE comp_licence=sol_licence AND comp_id = '".$this->comp_id."';";
				//echo $sql;
				$result = $this->db_connection->query($sql);
				$result_row = $result->fetch_object();
			
				$this->comp_tournoi = $result_row->comp_tournoi;
				$this->comp_licence = $result_row->comp_licence;
				$this->comp_joueur = $result_row->comp_joueur;
				$this->comp_sexe = $result_row->comp_sexe;
				$this->comp_simple = $result_row->comp_simple;
				$this->comp_double = $result_row->comp_double;
				$this->comp_mixte = $result_row->comp_mixte;
				$this->comp_cout = $result_row->comp_cout;
				$this->comp_remb = $result_row->comp_remb;
				$this->comp_type = $result_row->comp_type;
				$this->comp_paye = $result_row->comp_paye;
				
				$this->sol_licence = $result_row->sol_licence;
				$this->sol_joueur = $result_row->sol_joueur;				
				$this->sol_due = $result_row->sol_due;
				$this->sol_paye = $result_row->sol_paye;
				$this->sol_rest = $result_row->sol_rest;
				$this->sol_gp = $result_row->sol_gp;
				$this->sol_tour = $result_row->sol_tour;
			}
			$this->db_connection->close();
		}
	}
	
	public function __set($propriete, $valeur){
		if('id' === $propriete) {
			$this->comp_id = $valeur;
		}elseif('tournoi' === $propriete){
			$this->comp_tournoi = $valeur;
		}elseif('licence' === $propriete){
			$this->comp_licence = $valeur;
		}elseif('joueur' === $propriete){
			$this->comp_joueur = $valeur; 
		}elseif('sexe' === $propriete){
			$this->comp_sexe = $valeur; 
		}elseif('simple' === $propriete) {
			$this->comp_simple = $valeur;
		}elseif('double' === $propriete) {
			$this->comp_double = $valeur;
		}elseif('mixte' === $propriete){
			$this->comp_mixte = $valeur;
		}elseif('cout' === $propriete){
			$this->comp_cout = $valeur; 
		}elseif('regl' === $propriete){
			$this->sol_regl = $valeur; 
		}elseif('gp' === $propriete){
			$this->sol_regl = $valeur; 
		}elseif('tour' === $propriete){
			$this->sol_regl = $valeur; 
		}elseif('type' === $propriete){
			$this->comp_type = $valeur;
		}elseif('paye' === $propriete){
			$this->comp_paye = $valeur; 
		}elseif('remb' === $propriete){
			$this->comp_remb = $valeur;			
			
		}elseif('sdue' === $propriete){
			$this->sol_due = $valeur; 
		}elseif('spaye' === $propriete){
			$this->sol_paye = $valeur; 
		}elseif('srest' === $propriete){
			$this->sol_rest = $valeur;		
			
		}elseif('raison' === $propriete){
			$this->exe_raison = $valeur; 
		} else {
			throw new Exception('Propriété ou valeur invalide !');
		}
	}
	
	public function __get($property) {
		if('id' === $property) {
			return $this->comp_id;
		}elseif('tournoi' === $property){
			return $this->comp_tournoi;
		}elseif('licence' === $property){
			return $this->comp_licence;
		}elseif('joueur' === $property){
			return $this->comp_joueur;
		}elseif('sexe' === $property){
			return $this->comp_sexe;
		}elseif('simple' === $property){
			return $this->comp_simple;
		}elseif('double' === $property){
			return $this->comp_double;
		}elseif('mixte' === $property){
			return $this->comp_mixte;
		}elseif('cout' === $property){
			return $this->comp_cout;
		}elseif('gp' === $property){
			return $this->sol_gp;
		}elseif('tour' === $property){
			return $this->sol_tour;
		}elseif('remb' === $property){
			return $this->comp_remb;
		}elseif('type' === $property){
			return $this->comp_type;
		}elseif('paye' === $property){
			return $this->comp_paye;
			
			
		}elseif('sdue' === $property){
			return $this->sol_due;
		}elseif('spaye' === $property){
			return $this->sol_paye;
		}elseif('srest' === $property){
			return $this->sol_rest;
		} else {
			throw new Exception('Propriété invalide !');
		}
	}
	
	public function insertCout(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT * FROM solde_exep WHERE exe_licence = '".$this->comp_licence."';";
			$result = $this->db_connection->query($sql);
			if($result->num_rows || $this->comp_type == "2"){
				$this->comp_paye = 1;
				$this->comp_remb = 1;
			}
			
			$sql = "INSERT INTO competition (comp_id, comp_tournoi, comp_licence, comp_joueur, comp_sexe, comp_simple, comp_double, comp_mixte, comp_cout, comp_remb, comp_paye) 
				 VALUES ('".$this->comp_id."', '".$this->comp_tournoi."', '".$this->comp_licence."', '".$this->comp_joueur."', '".$this->comp_sexe."', '".$this->comp_simple."', '".$this->comp_double."', '".$this->comp_mixte."', '".$this->comp_cout."', '".$this->comp_remb."', '".$this->comp_paye."');";
			$result = $this->db_connection->query($sql);
			if($result){
				$this->messages[] = "Import successfull.";
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Import unsuccessfull.";
			}
			$this->db_connection->close();
			return $result;
		}else{
			$this->errors[] = "No database connection.";
		}
		$this->db_connection->close();
	}
	
	public function calcCout(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT * FROM solde_exep WHERE exe_licence = '".$this->comp_licence."';";
			$result = $this->db_connection->query($sql);
			if($result->num_rows || $this->comp_type == "2"){
				$sql = "SELECT * FROM solde_comp WHERE sol_licence = '".$this->comp_licence."'";
				$result = $this->db_connection->query($sql);
				if($result->num_rows){
					$result_row = $result->fetch_object();
					$this->sol_licence = $result_row->sol_licence;
					$this->sol_joueur = $result_row->sol_joueur;				
					$this->sol_due = $result_row->sol_due + $this->comp_cout;
					$this->sol_paye = $result_row->sol_paye + $this->comp_cout;
					$this->sol_rest = $result_row->sol_rest;
					$result = $this->updCout($result);
					return $result;
				}else{
					$this->sol_licence = $result_row->comp_licence;
					$this->sol_joueur = $result_row->comp_joueur;				
					$this->sol_due = $this->comp_cout;
					$this->sol_paye = $this->comp_cout;
					$this->sol_rest = 0;
					$result = $this->insCout($result);
					return $result;
				}
			}else{
				$sql = "SELECT * FROM solde_comp WHERE sol_licence = '".$this->comp_licence."'";
				$result = $this->db_connection->query($sql);
				if($result->num_rows){
					$result_row = $result->fetch_object();
					$this->sol_licence = $result_row->sol_licence;
					$this->sol_joueur = $result_row->sol_joueur;				
					$this->sol_due = $result_row->sol_due + $this->comp_cout;
					$this->sol_paye = $result_row->sol_paye;
					$this->sol_rest = $result_row->sol_rest + $this->comp_cout;
					$result = $this->updCout($result);
					return $result;
				}else{
					$this->sol_licence = $result_row->comp_licence;
					$this->sol_joueur = $result_row->comp_joueur;				
					$this->sol_due = $this->comp_cout;
					$this->sol_paye = 0;
					$this->sol_rest = $this->comp_cout;
					$result = $this->insCout($result);
					return $result;
				}
			}
			$this->db_connection->close();
			return $result;
		}else{
			$this->errors[] = "No database connection.";
		}
		$this->db_connection->close();
	}
	
	private function insCout($result){
			$sql = "INSERT INTO solde_comp (sol_licence, sol_joueur, sol_due, sol_paye, sol_rest) 
					VALUES ('".$this->licence."', '".$this->joueur."', '".$this->sol_due."', '".$this->sol_paye."', '".$this->sol_rest."');";
		
				$result = $this->db_connection->query($sql);
				if($result){
					$this->messages[] = "Import solde successfull.";
				}else{
					$this->errors[] = $sql;
					$this->errors[] = "Import solde unsuccessfull.";
				}
				$this->db_connection->close();
	}
	
	private function updCout($result){
			$sql = "UPDATE solde_comp SET 
					sol_due='".$this->sol_due."'
					, sol_paye='".$this->sol_paye."'
					, sol_rest='".$this->sol_rest."'
					WHERE sol_licence='".$this->sol_licence."';";
		
				$result = $this->db_connection->query($sql);
				if($result){
					$this->messages[] = "Update solde successfull.";
				}else{
					$this->errors[] = $sql;
					$this->errors[] = "Update solde unsuccessfull.";
				}
				$this->db_connection->close();
	}
	
	public function getCompetitions(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT * FROM solde_comp ORDER BY sol_joueur;";
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
	
	public function getCompetitionsJoueur($joueur){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT * FROM solde_comp WHERE sol_joueur LIKE '%".$joueur."%';";
			$i=0;
			if($result = $this->db_connection->query($sql)){
				$all = array();
				while($obj = $result->fetch_object()){
					$all[$i] = $obj;
					$i++;
				}
				$result->close();
				return $all;
			}else{
				$this->errors[] = $sql;
				return array();
			}
			
		}
		$this->db_connection->close();
	}
	
	public function getJoueurTournoi($tournoi){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT * FROM competition WHERE comp_tournoi LIKE '%".$tournoi."%' ORDER BY comp_date;";
			$i=0;
			if($result = $this->db_connection->query($sql)){
				$all = array();
				while($obj = $result->fetch_object()){
					$all[$i] = $obj;
					$i++;
				}
				$result->close();
				return $all;
			}else{
				$this->errors[] = $sql;
				return array();
			}
			
		}
		$this->db_connection->close();
	}
	
	public function getTournois($licence){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT * FROM competition WHERE comp_licence='".$licence."' ORDER BY comp_date;";
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
	
	public function getExeptions(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT * FROM solde_exep ORDER BY exe_joueur;";
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
	
	public function insExep(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "INSERT INTO solde_exep (exe_licence, exe_joueur, exe_raison) 
				 VALUES ('".$this->comp_licence."', '".$this->comp_joueur."', '".$this->exe_raison."');";
			$result = $this->db_connection->query($sql);
			if($result){
				$this->messages[] = "Exeption added successfully.";
				// ===============================================================================================
				$sql = "SELECT * FROM solde_comp WHERE sol_licence='".$this->licence."';";
				$result = $this->db_connection->query($sql);
				if($result->num_rows){
					$result_row = $result->fetch_object();
					$this->sol_licence = $result_row->sol_licence;
					$this->sol_joueur = $result_row->sol_joueur;				
					$this->sol_due = $result_row->sol_due;
					$this->sol_paye = $result_row->sol_paye + $result_row->sol_rest;
					$this->sol_rest = 0;
					
					$sql = "UPDATE solde_comp SET 
							sol_joueur='".$this->sol_joueur."'
							, sol_paye='".$this->sol_paye."'
							, sol_rest='".$this->sol_rest."'
							WHERE sol_licence='".$this->sol_licence."';";
					$result = $this->db_connection->query($sql);
					if($result){
						$this->messages[] = "Solde updated successfully.";
						$sql = "SELECT * FROM competition WHERE comp_licence='".$this->licence."';";
						$result = $this->db_connection->query($sql);
						if($result->num_rows){
							$sql = "UPDATE competition SET 
									comp_remb=1 
									WHERE comp_licence='".$this->sol_licence."';";
							$result = $this->db_connection->query($sql);
							if($result){
								$this->messages[] = "Competition updated successfully.";
							}else{
								$this->errors[] = $sql;
								$this->errors[] = "Competition not updated successfully.";
							}
						}
					}
				}
				// ===============================================================================================
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Exeption not added successfully.";
			}
			$this->db_connection->close();
			return $result;
		}else{
			$this->errors[] = "No database connection.";
		}
		$this->db_connection->close();
	}
	
	public function delExep(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "DELETE FROM solde_exep WHERE exe_licence='".$this->comp_licence."';";
			$result = $this->db_connection->query($sql);
			if($result){
				$this->messages[] = "Delete successfull.";
				// ===============================================================================================
				$sql = "SELECT * FROM solde_comp WHERE sol_licence='".$this->licence."';";
				$result = $this->db_connection->query($sql);
				if($result->num_rows){
					$result_row = $result->fetch_object();
					$this->sol_licence = $result_row->sol_licence;
					$this->sol_joueur = $result_row->sol_joueur;				
					$this->sol_due = $result_row->sol_due;
					$this->sol_paye = 0;
					$this->sol_rest = $result_row->sol_rest + $result_row->sol_paye;
					
					$sql = "UPDATE solde_comp SET 
							sol_joueur='".$this->sol_joueur."'
							, sol_paye='".$this->sol_paye."'
							, sol_rest='".$this->sol_rest."'
							WHERE sol_licence='".$this->sol_licence."';";
					$result = $this->db_connection->query($sql);
					if($result){
						$this->messages[] = "Solde updated successfully.";
						$sql = "SELECT * FROM competition WHERE comp_licence='".$this->licence."';";
						$result = $this->db_connection->query($sql);
						if($result->num_rows){
							$sql = "UPDATE competition SET 
									comp_remb=0 
									, comp_paye=0 
									WHERE comp_licence='".$this->sol_licence."';";
							$result = $this->db_connection->query($sql);
							if($result){
								$this->messages[] = "Competition updated successfully.";
							}else{
								$this->errors[] = $sql;
								$this->errors[] = "Competition not updated successfully.";
							}
						}
					}
				}
				// ===============================================================================================
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Delete unsuccessfull.";
			}
			$this->db_connection->close();
			return $result;
		}else{
			$this->errors[] = "No database connection.";
		}
		$this->db_connection->close();
	}
	
	public function getListeTournois(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT DISTINCT comp_tournoi FROM competition ORDER BY comp_date;";
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
	
	public function newReglement(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if (!$this->db_connection->connect_errno) {
				$sql = "SELECT * FROM solde_comp WHERE sol_licence = '".$this->comp_licence."';";
				$result = $this->db_connection->query($sql);
				$result_row = $result->fetch_object();
			
				//$this->sol_due = $result_row->sol_due;
				$this->sol_paye = $result_row->sol_paye + $this->sol_regl;
				$this->sol_rest = $result_row->sol_rest - $this->sol_regl;
				
				$sql = "UPDATE solde_comp SET 
				sol_paye='".$this->sol_paye."'
				, sol_rest='".$this->sol_rest."'
				WHERE sol_licence='".$this->comp_licence."';";
				$result = $this->db_connection->query($sql);
				if($result){
					$this->messages[] = "Update solde successfull.";
				}else{
					$this->errors[] = $sql;
					$this->errors[] = "Update solde unsuccessfull.";
				}
				$this->db_connection->close();
				return $result;
			}
			$this->db_connection->close();
	}
	
	public function delCompetition(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			
			$this->sol_due = $this->sol_due - $this->comp_cout;
			if($this->comp_paye || $this->comp_remb){
				$this->sol_paye=$this->sol_paye-$this->comp_cout;
			}else{
				$this->sol_rest=$this->sol_rest-$this->comp_cout;
			}
			$sql = "UPDATE solde_comp SET 
					sol_due='".$this->sol_due."'
					, sol_paye='".$this->sol_paye."'
					, sol_rest='".$this->sol_rest."'
					WHERE sol_licence='".$this->sol_licence."';";
			
			$result = $this->db_connection->query($sql);
			if($result){
				//$this->messages[] = $sql;
				$this->messages[] = "Update solde successfull.";
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Update solde unsuccessfull.";
			}
			
			$sql = "DELETE FROM competition WHERE comp_id = '".$this->comp_id."';";
			$result = $this->db_connection->query($sql);
			if($result){
				$this->messages[] = "Update solde successfull.";
			}else{
			$this->errors[] = $sql;
				$this->errors[] = "Update solde unsuccessfull.";
			}
			$this->db_connection->close();
			return $result;		
		}
		$this->db_connection->close();
	}
	
	public function payeCompetition(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {			
			if($this->comp_paye){
				$this->comp_paye = 0;
				$sql = "UPDATE competition SET 
					comp_paye='".$this->comp_paye."' 
					WHERE comp_id='".$this->comp_id."';";
			}else{
				$this->comp_paye = 1;
				$sql = "UPDATE competition SET 
					comp_paye='".$this->comp_paye."' 
					WHERE comp_id='".$this->comp_id."';";
			}
			$result = $this->db_connection->query($sql);
			if($result){
				$this->messages[] = "Update competition successfull.";
				if($this->comp_paye){
					$sql = "SELECT * FROM solde_comp WHERE sol_licence='".$this->comp_licence."';";
					$result = $this->db_connection->query($sql);
					$result_row = $result->fetch_object();
					$this->sol_due=$result_row->sol_due;
					$this->sol_paye=$result_row->sol_paye + $this->comp_cout;
					$this->sol_rest=$result_row->sol_rest - $this->comp_cout;
					$this->sol_gp=$result_row->sol_gp;
					$this->sol_tour=$result_row->sol_tour;
					
					$sql = "UPDATE solde_comp SET 
					sol_paye='".$this->sol_paye."'
					, sol_rest='".$this->sol_rest."'
					WHERE sol_licence='".$this->comp_licence."';";
					$result = $this->db_connection->query($sql);
					if($result){
						$this->messages[] = "Update solde successfull.";
					}else{
						$this->errors[] = $sql;
						$this->errors[] = "Update solde unsuccessfull.";
					}
				}else{
					$sql = "SELECT * FROM solde_comp WHERE sol_licence='".$this->comp_licence."';";
					$result = $this->db_connection->query($sql);
					$result_row = $result->fetch_object();
					$this->sol_due=$result_row->sol_due;
					$this->sol_paye=$result_row->sol_paye - $this->comp_cout;
					$this->sol_rest=$result_row->sol_rest + $this->comp_cout;
					$this->sol_gp=$result_row->sol_gp;
					$this->sol_tour=$result_row->sol_tour;
					
					$sql = "UPDATE solde_comp SET 
					sol_paye='".$this->sol_paye."'
					, sol_rest='".$this->sol_rest."'
					WHERE sol_licence='".$this->comp_licence."';";
					$result = $this->db_connection->query($sql);
					if($result){
						$this->messages[] = "Update solde successfull.";
					}else{
						$this->errors[] = $sql;
						$this->errors[] = "Update solde unsuccessfull.";
					}
				}
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Update competition unsuccessfull.";
			}
		}
		$this->db_connection->close();
		return $result;
	}
	
	public function updCompetition(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "UPDATE solde_comp SET 
					sol_due='".$this->sol_due."'
					, sol_paye='".$this->sol_paye."'
					, sol_rest='".$this->sol_rest."'
					WHERE sol_licence='".$this->comp_licence."';";
			$result = $this->db_connection->query($sql);
			if($result){
				$this->messages[] = "Update solde successfull.";
				$sql = "UPDATE competition SET 
					comp_remb='".$this->comp_remb."'
					, comp_simple='".$this->comp_simple."'
					, comp_double='".$this->comp_double."'
					, comp_mixte='".$this->comp_mixte."'
					, comp_cout='".$this->comp_cout."'
					, comp_paye='".$this->comp_paye."'
					WHERE comp_id='".$this->comp_id."';";
				//echo $sql;
				$result = $this->db_connection->query($sql);
				if($result){
					$this->messages[] = "Update competition successfull.";
				}else{
					$this->errors[] = $sql;
					$this->errors[] = "Update competition unsuccessfull.";
				}
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Update solde unsuccessfull.";
			}
			
		}
		$this->db_connection->close();
		return $result;
	}
	
	public function delJoueur(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "DELETE FROM competition WHERE comp_licence = '".$this->comp_licence."';";
			$result = $this->db_connection->query($sql);
			if($result){
				$this->messages[] = "Update competition successfull.";
				$sql = "DELETE FROM solde_comp WHERE sol_licence = '".$this->comp_licence."';";
				$result = $this->db_connection->query($sql);
				if($result){
					$this->messages[] = "Update solde successfull.";
				}else{
					$this->errors[] = $sql;
					$this->errors[] = "Update solde unsuccessfull.";
				}
				$this->db_connection->close();
				return $result;
			}else{
			$this->errors[] = $sql;
				$this->errors[] = "Update competition unsuccessfull.";
			}
			$this->db_connection->close();
			return $result;		
		}
		$this->db_connection->close();
	}
	
	public function clearDB(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$arrTable = array("solde_exep", "solde_comp", "competition");
			foreach($arrTable as $line){
				$sql = "TRUNCATE TABLE ".$line.";";
				$result = $this->db_connection->query($sql);
				if($result){
					$this->messages[] = "Truncate ".$line." successfull.";
				}else{
					$this->errors[] = $sql;
					$this->errors[] = "Update ".$line." unsuccessfull.";
				}
			}
			$this->db_connection->close();
			return $result;
		}
		$this->db_connection->close();
		return 0;
	}
	
	public function statHF(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT DISTINCT comp_licence, comp_joueur, comp_sexe FROM competition;";
			$result = $this->db_connection->query($sql);
			if($result){
				$nb_ligne = $result->num_rows;
				$sql = "SELECT DISTINCT comp_licence, comp_joueur, comp_sexe FROM competition WHERE comp_sexe='H';";
				$result = $this->db_connection->query($sql);
				if($result){
					$nb_H = $result->num_rows;
					$nb_F = $nb_ligne - $nb_H;
					//$pourc_H = round($nb_H * 100 / $nb_ligne);
					$this->db_connection->close();
					return array($nb_ligne, $nb_F, $nb_H);
				}else{
					$this->errors[] = $sql;
					$this->errors[] = "Erreur";
				}
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Erreur";
			}
		}
		$this->db_connection->close();
		return 0;
	}
	
	public function statDue(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT sol_joueur, sol_due FROM solde_comp ORDER BY sol_due DESC LIMIT 1;";
			if($result = $this->db_connection->query($sql)){
				$result_row = $result->fetch_object();
				$result->close();
				return $result_row;
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Erreur";
			}
		}
		$this->db_connection->close();
		return 0;
	}
	
	public function statNbMatch(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT comp_joueur, COUNT(comp_licence) AS NbMatch
					FROM competition
					GROUP BY comp_joueur
					ORDER BY COUNT(comp_licence) DESC
					LIMIT 1;";
			if($result = $this->db_connection->query($sql)){
				$result_row = $result->fetch_object();
				$result->close();
				return $result_row;
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Erreur";
			}
		}
		$this->db_connection->close();
		return 0;
	}
	
	public function statNbTournois(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT COUNT(DISTINCT comp_tournoi) AS NbTournois 
					FROM competition;";
			if($result = $this->db_connection->query($sql)){
				$result_row = $result->fetch_object();
				$result->close();
				return $result_row;
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Erreur";
			}
		}
		$this->db_connection->close();
		return 0;
	}
	
	public function statNbJoueursNonRemb(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT comp_tournoi, COUNT(comp_tournoi) AS NbJoueurs
					FROM competition
					WHERE comp_remb =0
					GROUP BY comp_tournoi
					ORDER BY COUNT(comp_tournoi) DESC
					LIMIT 1;";
			if($result = $this->db_connection->query($sql)){
				$result_row = $result->fetch_object();
				$result->close();
				return $result_row;
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Erreur";
			}
		}
		$this->db_connection->close();
		return 0;
	}
	
	public function statNbJoueursRemb(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT comp_tournoi, COUNT(comp_tournoi) AS NbJoueurs
					FROM competition
					WHERE comp_remb =1
					GROUP BY comp_tournoi
					ORDER BY COUNT(comp_tournoi) DESC
					LIMIT 1;";
			if($result = $this->db_connection->query($sql)){
				$result_row = $result->fetch_object();
				$result->close();
				return $result_row;
			}else{
				$this->errors[] = $sql;
				$this->errors[] = "Erreur";
			}
		}
		$this->db_connection->close();
		return 0;
	}
	
	public function delTournoi($tournoi){
		if($tournoi){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$sql = "SELECT * FROM competition WHERE comp_tournoi='".$tournoi."';";
			if($result = $this->db_connection->query($sql)){
				$i=0;
				while($obj = $result->fetch_object()){
					$comp = new Competition($obj->comp_id);
					$comp->delCompetition();
					$i++;
				}
				$this->messages[] = $i." joueurs du tournoi ".$tournoi." ont été supprimés.";
			}else{
				$this->errors[] = "Erreur select";
			}
			$result->close();
		}
		}
	}
}















