<?php
	class User extends DBObject {
		private $id;
		private $name;
		private $email;
		private $postal;
		private $street;
		private $city;
		
		protected function __construct($id,$username,$email, $surname='', $postal='', $street='', $city='') {
			$this->id = $id;
			$this->name=$username;
			$this->email=$email;
			$this->surname=$surname;
			$this->postal = $postal;
			$this->street = $street;
			$this->city = $city;
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
			$table = 'users';
			$columns = array('email', 'name', 'surname', 'password', 'street', 'postal_code', 'city');
			$values = array($email, $username, '', self::getHashedPassword($password), '', '', '');
				
			if(($id = parent::Create($table, $columns, $values)) !== null) {
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
		
		static public function Load($id) {
			$data = parent::Load($id,'users');
			
			if($data=$data->fetch_assoc()) {
				return self::CreateFromArray($data);
			}
			
			return null;
		}
		
		static private function CreateFromArray($data){
			return new User($data['id'], $data['name'], $data['email'], $data['surname'], $data['postal_code'], $data['street'], $data['city']);
		}
		
		static public function Update($user) {
			$table = 'users';
			$columns = array('email', 'name', 'surname', 'street', 'postal_code', 'city');
			$values = array($user->getEmail(), $user->getName(), $user->getSurname(), $user->getStreet(), $user->getPostal(), $user->getCity());
			
			return parent::Update($table,$columns,$values, $user->getID());
		}
		
		static public function Delete($id) {
			return parent::Delete($id, 'users');
		}
		

		//------------------- OTEHR STATIC -------------------
		static public function GetAllUsers() {
			$data = parent::GetAll('users');
			
			if($data) {
				$users = array();
				while($row = $data->fetch_assoc()){
					$users[] = self::CreateFromArray($row);
				}
				
				return $users;
			}
			
			return null;
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