<?php
class REFEREE{
	function __construct(){
	}
	private function unique_id($l = 8){
		$better_token = md5(uniqid(rand(), true));
		$rem = strlen($better_token)-$l;
		$unique_code = substr($better_token, 0, -$rem);
		$uniqueid = $unique_code;
		return $uniqueid;
	}
	private function collect(&$formvars){
		$formvars['CURID'] = $_POST['1CURID'];
	}
	private function search(){
		$formvars = array();
		$this->collect($formvars);
		$path_to_check = "../usr/";
		foreach(glob($path_to_check . '*.md') as $filename){
			foreach(file($filename) as $fli=>$fl){
				if(strpos($fl, $formvars['CURID'])!==false) {
					return $filename;
				}
			}
		}
	}
	private function verify($filenames){
		if(count($filenames)==1){
			$XML_RENDER = simplexml_load_file($filenames);
			$a = $XML_RENDER->div[5]; $a=trim($a);
			$b = $_POST['1CURID'];	$b = trim($b);
			if($a==$b){
				//$filename = $filenames[];
				return $filenames;
			}else{
				echo 'Unverified ID';
			}
		}else{
			echo 'ID appears in more than one file';
		}
	}
	private function revokeID($filename){
		if(isset($filename)!==false){
			$formvars = array();
			$this->collect($formvars);
			$XML_RENDER = simplexml_load_file($filename);
			$a = $XML_RENDER->div[5]; 	$a = trim($a);
			$b = $formvars['CURID'];	$b = trim($b);
			if($a==$b){
				$XML_RENDER->div[6] = $XML_RENDER->div[5] . ' + ' .  $XML_RENDER->div[6];
				$XML_RENDER->div[5] = $this->unique_id(8);
				$XML_RENDER->asXML($filename);
				echo 'ID Revoked';
			}else{
			echo $a . " != " . $b;
				echo "
				Target ID not current";
			}
		}else{
			echo $filename;
			echo ' messaging error in revoke ID ';
		}
	}
	private function zombify($filename){
		if(isset($filename)!==false){
			$XML_RENDER = simplexml_load_file($filename);
			$a = $XML_RENDER->div[4];
			$a = trim($a);
			if($a=="human"){
				$XML_RENDER->div[4]='zombie';	$XML_RENDER->asXML($filename);
				echo $filename;
			}else{
				echo 'zombification error?';
			}
		}
	}
	private function humanate($filename){
		if(isset($filename)!==false){
			$XML_RENDER = simplexml_load_file($filename);
			$p = $XML_RENDER->div[4];
			$a = trim($a);
			if($a=="zombie"){
				$XML_RENDER->div[4]='human';	$XML_RENDER->asXML($filename);
				echo $filename;
		}else{
				echo 'rescue error?';
			}
		}
	}
	public function destroy(){
		$this->zombify($this->verify($this->search())); echo "\n";
		$this->revokeID($this->verify($this->search())); echo "\n";
	}
	public function rescue(){
		$this->humanate($this->verify($this->search())); echo "\n";
		$this->revokeID($this->verify($this->search())); echo "\n";
	}
	public function team($ID){
		$XML_RENDER = simplexml_load_file($ID);
		echo $XML_RENDER->div[4];
	}
	public function item(){

	}
}
if(isset($_POST['kill'])){
	if(!isset($_SESSION['CUSER'])){
		echo "Please log in to continue";
	}else{
		$refe = new REFEREE();
		echo $refe->destroy();
	}
}
if(isset($_POST['heal'])){
	if(!isset($_SESSION['CUSER'])){
		echo "Please log in to continue";
	}else{
		if(action($_SESSION['CUSER'])){
			$refe = new REFEREE();
			echo $refe->rescue();
		}
	}
}
?>
