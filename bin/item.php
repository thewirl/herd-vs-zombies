<?php
//require_conce();
$ITEM_CONST = array('HEAL' => 1 ,'NONE' => 0);
class ITEM(){
	private $itemID;
	private $item_const;
	private $associate;
	private function collect(&$formvars){
		$formvars['assoc'] = $_POST['assoc'];
		$formvars['const'] = 1;
		$formvars['filename'] = "../usr/itm" . $_POST['user'] . '.md';
		$formvars['initid'] = $this->itemID;
	}
	public function __construct(){
		$better_token = md5(uniqid(rand(), true));
		$rem = strlen($better_token)-$l;
		$unique_code = substr($better_token, 0, -$rem);
		$uniqueid = $unique_code;
		return $uniqueid;
	}
	public function register($input, $userID){
		if($input==$this->itemID){
			$this->$associate = $userID;
			if(isset($_POST['submitted'])){
				$formvars = array();
				$this->collect($formvars);
				if(file_exists($formvars['filename'])){
					echo "Username Already Taken";
				}else{
					$file = fopen($formvars['filename'], "w+");
					if($file==false){
						echo "File Error";
					}else{
						fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>
');
						fwrite($file, '<item id="CONSUMABLE">
');
						fwrite($file, '	<div id="ITEM">
	Item
	=====================================================================
		</div>
');
						fwrite($file, '	<div id="CONST">');
						fwrite($file, $formvars['const']);
						fwrite($file, '	</div>
');
						fwrite($file, '	<div id="ASSOC">');
						fwrite($file, $formvars['assoc']);
						fwrite($file, '	</div>
');
						fwrite($file, '</item>
');
						fclose($file);
						echo "User Created";
					}
					chmod($formvars['filename'], 0600);
				}
			}else{
				echo "Submission Error";
			}
		}
	}
	public function action($targetID)
}
?>
