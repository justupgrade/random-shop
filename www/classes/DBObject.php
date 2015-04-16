<?php
	class DBObject {
		static protected  $connection = null;
		
		static public function SetUpConnection($connection){
			self::$connection = $connection;
		}
		
		// ----------- static all -------------
		
		static public function GetAll($table){
			$query = "SELECT * FROM " . $table;
			return self::$connection->query($query);
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
			if($str === null || $str === "") return "''";
			return (is_string($str)) ? "'".$str."'" : $str;
		}
		
		static public function Load($id,$table) {
			$query = "SELECT * FROM " . $table . " WHERE id=".$id;
			
			return self::$connection->query($query);
		}
		
		static public function Update($table,$columns,$values,$ID) {
			$length = count($columns);
			
			$query = "UPDATE " . $table . " SET";
			
			for($i=0;$i<$length;$i++) {
				$query .= " " . $columns[$i] . "=" . self::convert($values[$i]);
				if($i < $length-1) $query .= ', ';
				else $query .= " WHERE id=" . $ID;
			}
			//trigger_error($query);
			return self::$connection->query($query);
		}
		
		static public function Delete($id,$table) {
			$query = "DELETE  FROM " . $table . " WHERE id=" . $id;
			self::$connection->query($query);
			return mysqli_affected_rows(self::$connection);
		}
	}
?>