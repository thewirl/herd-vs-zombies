<?php
class SUPERVISOR{
	public function __construct(){
	
	}
	private function unique_id($l = 8){
		$better_token = md5(uniqid(rand(), true));
		$rem = strlen($better_token)-$l;
		$unique_code = substr($better_token, 0, -$rem);
		$uniqueid = $unique_code;
		return $uniqueid;
	}
	private function collect(&$formvars){
		$formvars['RE'] = $_POST['recipient'];
		$formvars['RE'] = $_POST['message'];
		$formvars['ME'] = $_SESSION['CUSER']->getuserID();
		$formvars['filename'] = $this->unique_id(16) . ".md";
	}
	public function showmessage(){
	
	}
	public function acceptmessage(){
			if(isset($_POST['submitted'])){
				$formvars = array();
				$this->collect($formvars);
				if(file_exists($formvars['filename'])){
					echo "Username Already Taken";
				}else{
					$file = fopen($formvars['filename'], "w");
					if($file==false){
						echo "File Error";
					}else{
					fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>
');
					fwrite($file, '<prof id="REGISTRANT">
');
					fwrite($file, '	<div id="SENDER">');
					fwrite($file, $formvars['ME']);
					fwrite($file, '	</div>
');
					fwrite($file, '	<div id="RECIPIENT">');
					fwrite($file, $formvars['RE']);
					fwrite($file, '	</div>
');
					fwrite($file, '	<div id="SUBJECT">');
					fwrite($file, $formvars['name']);
					fwrite($file, '	</div>
');
					fwrite($file, "	<div id="CONTENTS">
$message
</div>
");
					fwrite($file, '</prof>
');
					}
					fclose($file);
					echo "Message Created";
					chmod($formvars['filename'], 0600);
				}
			}else{
				echo "Submission Error";
			}		
	}
	
}
?>
