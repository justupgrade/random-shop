<?php

	class Picture extends DBObject {
		private $id;
		private $path;
		private $itemID;
		
		static protected $table = 'pictures';
		
		//WHAT DO I NEED THIS FOR? FOR CLARITY? Single responsibility principle
		protected function __construct($id,$path,$itemID){
			$this->id=$id;
			$this->path = $path;
			$this->itemID = $itemID;
		}
		
		static protected function CreateFromArray($data) {
			return new Picture($data['id'], $data['path'], $data['item_id']);
		}
		
		static public function Create() {
			trigger_error("CANNOT CREATE PICTURE WITHOUT DATA; CALL Picture::Upload(...)!");
		}
		//save to db ? private ?
		static protected function CreatePicture($itemID, $path) {
			//validate path? how? 
			$columns = array('path', 'item_id');
			$values = array($path, $itemID);
			
			if(($id = parent::Create($columns, $values))) {
				return new Picture($id,$path,$itemID);
			}
			
			return null;
		}
		
		//load from db :: ALL PICTURES FOR SPECYFIED ITEM
		static public function Load($itemID) {
			return parent::LoadArray($itemID);
		}
		
		//what to update? picture itself? path to picture?
		static public function Update($picture) {
			//do not allow to update for now...
			trigger_error('Picture can not be updated!');
		}
		
		/* DELETE FORM DB + DELETE FILE FROM DRIVE!!!
		 * why the ... is this static? super() is static...
		 * */
		static public function Delete($picture) {
			if(parent::Delete($picture->getID()) === 1) {
				//keep directory structure? for now yes...
				if(unlink($picture->getPath())) return 1;
			}
			
			return 0;
		}
		
		//------------------ methods --------------------
		//watermark? description? other effects?
		public function edit() {
			
		}
		
		public function download() {
			//what for?  what to download? =D binary data or what?
		}
		
		public function save() { //save edited? save, so admin can restore? 
			
		}
		
		public function changePath($newPath) {
			//move file... why would someone move file?
			//is new path valid?
			//moved successfully? -> saveToDb!!!
		}
		
		//------------------ PICTURES ----------------------
		static public function Upload($name, $file, $item){
			$hashed_name = md5($name);
			$begining = substr($hashed_name, 0, 2);
			$ending = substr($hashed_name, strlen($hashed_name)-2, 2);
			$structure = $_SERVER['DOCUMENT_ROOT'].'/uploads/' . $item->getCategoryID() . '/';
			$structure .= date("Y") . '/' . date("m") . '/' . date("d") . '/';
			$structure .= $begining.$ending . '/';
			
			if(!is_dir($structure)) mkdir($structure,0777,true);
			
			if(!move_uploaded_file($file, $structure.$name)) return null;
			//uploaded? -> create
			
			return self::CreatePicture($item->getID(), $structure.$name);
		}
		
		//----------------- GET / SET --------------------
		public function getID() { return $this->id; }
		public function getItemID() { return $this->itemID; }
		public function getPath() { return $this->path; }
		
		public function setPath($new) { $this->path = $new; }  //LET THIS TO EXIST? move file while called?

	}
?>