<?php
	class User extends DBObject {
		private $id;
		private $name;
		private $email;
		private $postal;
		private $street;
		private $city;
		
		protected function __construct($id,$username,$email) {
			$this->id = $id;
			$this->name=$username;
			$this->email=$email;
		}
		
		//----------- methods -----------------
		public function authenticate() {
		
		}
		
		public function getAllOrders() {
		
		}
		
		public function sendMail() {
		
		}
		
		//-------------- CRUD --------------------
		static public function Create($username,$email,$password) {
			$table = 'users';
			$columns = array('email', 'name', 'surname', 'password', 'street', 'postal_code', 'city');
			$values = array($email, $username, '', self::getHashedPassword($password), '', '', '');
				
			if(($id = parent::Create($table, $columns, $values)) !== null) {
				return new User($id,$username,$email,$password);
			}
				
			return null;
		}
		
		static private function getHashedPassword($password) {
			$options = array(
					'cost' => 5,
					'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
			);
		
			return password_hash($password, PASSWORD_BCRYPT, $options);
		}
		
		static public function Load($id) {
				
		}
		
		static public function Update($user) {
				
		}
		
		static public function Delete($id) {
				
		}
		

		//------------------- OTEHR STATIC -------------------
		static public function GetAllUsers() {
				
		}
		
		// -----------------------
		public function getName() {
			return $this->name;
		}
		
	}
?>