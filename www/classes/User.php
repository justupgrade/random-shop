<?php
		
	class User extends DBObject {
		private $id;
		private $name;
		private $email;
		private $postal;
		private $street;
		private $city;
		
		static protected $table = 'users';
		
		protected function __construct($id,$username,$email, $surname='', $postal='', $street='', $city='') {
			$this->id = $id;
			$this->name=$username;
			$this->email=$email;
			$this->surname=$surname;
			$this->postal = $postal;
			$this->street = $street;
			$this->city = $city;
		}
		
		//ABSTRACT HAS TO BE IMPLEMENTED
		static protected function CreateFromArray($data){
			return new User($data['id'], $data['name'], $data['email'], $data['surname'], $data['postal_code'], $data['street'], $data['city']);
		}
		
		//----------- methods -----------------
		static public function Authenticate($email,$password) {
			$query = "SELECT * FROM users WHERE email='".$email."'";
			
			if(($hashed = self::$connection->query($query)))  {
				$data = $hashed->fetch_assoc();
				if(password_verify($password, $data['password'])) {
					return self::CreateFromArray($data);
				}
			}
			
			return null;
		}
		
		public function changePassword($newPass){
			$query = "UPDATE users SET password='" . self::getHashedPassword($newPass) . "' WHERE id=" . $this->id;
			
			return self::$connection->query($query);
		}
		
		//MOVE TO ORDERS ???
		public function getAllOrders() {
			//get all orders for this user
			$query = "SELECT * FROM orders WHERE user_id=".$this->id . " ORDER BY status";
			
			$result = self::$connection->query($query);
			if($result && $result->num_rows > 0) {
				$orders = array();
				while($row = $result->fetch_assoc()){
					$orders[] = new Order($row['id'], $row['status'], $row['user_id'], $row['date']);
				}
				
				return $orders;
			}
			
			return null;
		}
		
		public function sendMail() {
		
		}
		
		//-------------- CRUD --------------------
		static public function Create($username,$email,$password) {
			$columns = array('email', 'name', 'surname', 'password', 'street', 'postal_code', 'city');
			$values = array($email, $username, '', self::getHashedPassword($password), '', '', '');
				
			if(($id = parent::Create($columns, $values)) !== null) {
				return new User($id,$username,$email);
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
		
		
		static public function Update($user) {
			$columns = array('email', 'name', 'surname', 'street', 'postal_code', 'city');
			$values = array($user->getEmail(), $user->getName(), $user->getSurname(), $user->getStreet(), $user->getPostal(), $user->getCity());
			
			return parent::Update($columns,$values, $user->getID());
		}
		
		

		//------------------- OTEHR STATIC -------------------
		
		static public function isUnique($login,$column) {
			$query = "SELECT * FROM users WHERE ".$column."='" . $login ."'";
			$result = self::$connection->query($query);

			if($result && $result->num_rows == 0) return true;

			return false;
		}
		
		// ----------------------- GET / SET
		public function getName() {
			return $this->name;
		}
		
		public function setEmail($new) { $this->email = $new; }
		public function setSurname($new) { $this->surname = $new; }
		public function setStreet($new) { $this->street = $new; }
		public function setPostal($new) { $this->postal = $new; }
		public function setCity($new) { $this->city = $new; }
		
		public function getID() { return $this->id;}
		public function getEmail() { return $this->email; }
		public function getSurname() { return $this->surname; }
		public function getStreet() { return $this->street; }
		public function getPostal() { return $this->postal; }
		public function getCity() { return $this->city; }
		
	}
?>