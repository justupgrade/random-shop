<?php
	class DBObject {
		static protected  $connection = null;
		
		static public function SetUpConnection($connection){
			self::$connection = $connection;
		}
		
		//-------------- CRUD --------------------
		static public function Create($table,$columns,$values) {
			$length = count($columns);
			
			$query = "INSERT into " . $table . " (";
			foreach($columns as $colID => $column) {
				$query .= $column; 
				if($colID < $length -1 ) $query .= ",";
				else $query .= ") VALUES (";
			}
			
			foreach($values as $valueID => $value){
				$query .= self::convert($value);
				if($valueID < $length-1) $query .= ", ";
				else $query .= ")";
			}
			
		//	trigger_error($query);
			
			if(self::$connection->query($query)){
				return self::$connection->insert_id;
			}
			
			return null;
		}
		
		static private function convert($str){
			return (is_string($str)) ? "'".$str."'" : $str;
		}
		
		static public function Load($id) {
		
		}
		
		static public function Update() {
		
		}
		
		static public function Delete($id) {
		
		}
	}
?>