<?php

class User
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
	
	public $user_id, $user_name, $user_club, $user_password, $user_email, $user_admin, $user_super_admin, $user_licence;
	
	public $errors = array();
	public $messages = array();
	
	public function __construct($id){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) {
			$this->user_id = $id;
			$sql = "SELECT * FROM users WHERE user_id = '".$id."';";
			$result = $this->db_connection->query($sql);
			$result_row = $result->fetch_object();
			$this->user_name = $result_row->user_name;
			$this->user_club = $result_row->user_club;
			$this->user_password = $result_row->user_password_hash;
			$this->user_email = $result_row->user_email;
			$this->user_admin = $result_row->user_admin;
			$this->user_super_admin = $result_row->user_super_admin;
			$this->user_licence = $result_row->user_licence;
		}
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->UpdateUser();
		}
	}
	
	public function __set($propriete, $valeur){
		if('id' === $propriete && ctype_digit($valeur)) {
			$this->user_id = (int) $valeur;  
		}elseif('nom' === $propriete){
			$this->user_name = $valeur; 
		}elseif('club' === $propriete){
			$this->user_club = $valeur; 
		}elseif('password' === $propriete){
			$this->user_password = $valeur; 
		}elseif('email' === $propriete){
			$this->user_email = $valeur; 
		}elseif('admin' === $propriete){
			$this->user_admin = $valeur;
		}elseif('superman' === $propriete){
			$this->user_super_admin = $valeur;
		}elseif('licence' === $propriete){
			$this->user_licence = $valeur;
		} else {
			throw new Exception('Propriété ou valeur invalide !');
		}
	}
	
	public function __get($property) {
		if('id' === $property) {
			return $this->user_id;
		}elseif('nom' === $property){
			return $this->user_name;
		}elseif('club' === $property){
			return $this->user_club;
		}elseif('password' === $property){
			return $this->user_password;
		}elseif('email' === $property){
			return $this->user_email;
		}elseif('admin' === $property){
			return $this->user_admin;
		}elseif('superman' === $property){
			return $this->user_super_admin;
		}elseif('licence' === $property){
			return $this->user_licence;
		} else {
			throw new Exception('Propriété invalide !');
		}
	}
	public function UpdateUser(){
		if(!empty($_POST['user_password_new']) && strlen($_POST['user_password_new']) < 6){
				$this->errors[] = "Password must have a minimum length of 6 characters";
		}elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
				$this->errors[] = "Password and confirmation are not the same";
        }elseif (empty($_POST['user_name'])) {
            $this->errors[] = "Empty Username";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif (!empty($_POST['user_email']) && strlen($_POST['user_email']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } elseif (!empty($_POST['user_email']) && !filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
		}else {
            // create a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
				$this->db_connection->close();
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $this->user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $this->user_email = $this->db_connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));
                $this->user_licence = $this->db_connection->real_escape_string(strip_tags($_POST['user_licence'], ENT_QUOTES));

				
				$sql = "UPDATE users SET";
				$sql .= " user_name='".$this->user_name."'";
				if(!empty($_POST['user_password_new'])){
					$user_password = $_POST['user_password_new'];
					$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
					$sql .= ", user_password_hash='".$user_password_hash."'";
				}
				$sql .= ", user_email='".$this->user_email."'";
				//$sql += ", user_club='".$this->user_club."'";
				if(!empty($_POST['user_licence'])){
					$sql .= ", user_licence='".$this->user_licence."'";
				}
				$sql .= ", user_date_mod=CURRENT_TIMESTAMP";
				$sql .= " WHERE user_id=".$this->user_id.";";
		
				$result = $this->db_connection->query($sql);// if user has been added successfully
                    if ($result) {
						//$this->messages[] = $sql;
                        $this->messages[] = "Account has been updated.";
                    } else {
						$this->errors[] = $sql."<br/>";
                        $this->errors[] = "Sorry, account could not be updated. Please try again later.";
                    }
                
            } else {
                $this->errors[] = "No database connexion.";
            }
			$this->db_connection->close();
			return $result;
		}
	}
	
	
	public function getUsers(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$sql = "SELECT user_id, user_name, user_email, user_admin, user_super_admin, user_licence FROM users ORDER BY user_name;";
		$i=0;
		if($result_users = $this->db_connection->query($sql)){
			$all = array();
			while($obj = $result_users->fetch_object()){
				$all[$i] = $obj;
				$i++;
			}
			$result_users->close();
			return $all;
		}else{
			$this->errors[] = $sql;
		}
		return array();
	}
	
	public function updAdmin($id, $admin){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$sql = "UPDATE users SET user_admin=".$admin.", user_date_mod=CURRENT_TIMESTAMP WHERE user_id=".$id.";";
		$result = $this->db_connection->query($sql);
		if($result){
			$this->messages[] = "Udpdate admin successfull.";
		}else{
			$this->errors[] = $sql;
			$this->errors[] = "Update admin unsuccessfull.";
		}
		$this->db_connection->close();
		return $result;
	}
	
	public function updSuperman($id, $admin){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$sql = "UPDATE users SET user_super_admin=".$admin.", user_date_mod=CURRENT_TIMESTAMP WHERE user_id=".$id.";";
		$result = $this->db_connection->query($sql);
		if($result){
			$this->messages[] = "Udpdate admin successfull.";
		}else{
			$this->errors[] = $sql;
			$this->errors[] = "Update admin unsuccessfull.";
		}
		$this->db_connection->close();
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>