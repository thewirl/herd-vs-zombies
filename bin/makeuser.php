<?php
class USER{
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
		$formvars['name'] = $_POST['name'];
		$formvars['email'] = crypt($_POST['email']);
		$formvars['username'] = $_POST['user'];
		$formvars['filename'] = "../usr/" . $_POST['user'] . '.md';
		$formvars['password'] = crypt($_POST['pass']);
		$formvars['initid'] = $this->unique_id;
	}
	public function register(){
		if(isset($_POST['submitted'])){
			$formvars = array();
			$this->collect($formvars);
			if($formvars['name']!=''){
				echo "Username may not be empty";
				if(file_exists($formvars['filename'])){
					echo "Username Already Taken";
				}else{
					$file = fopen($formvars['filename'], "w+");
					if($file==false){
						echo "File Error";
					}else{
						fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>
	');
						fwrite($file, '<prof id="REGISTRANT">
	');
						fwrite($file, '	<div id="PROFILE">
	This field accepts Markdown formatting and displays it as the user profile
	=====================================================================
		</div>
	');
						fwrite($file, '	<div id="NAME">');
						fwrite($file, $formvars['name']);
						fwrite($file, '	</div>
	');
						fwrite($file, '	<div id="EMAIL">');
						fwrite($file, $formvars['email']);
						fwrite($file, '	</div>
	');
						fwrite($file, '	<div id="USERID">');
						fwrite($file, $formvars['username']);
						fwrite($file, '	</div>
	');
						fwrite($file, '	<div id="ROLE">');
						fwrite($file, "human");
						fwrite($file, '	</div>
	');
						fwrite($file, '	<div id="CURID">');
						fwrite($file, $formvars['initid']);
						fwrite($file, '	</div>
	');
						fwrite($file, '	<div id="DISID">');
						fwrite($file, $formvars['username']);
						fwrite($file, '	</div>
	');
						fwrite($file, '	<div id="PASSWORD">');
						fwrite($file, $formvars['password']);
						fwrite($file, '	</div>
	');
						fwrite($file, '</prof>
	');
						fclose($file);
						echo "User Created";
					}
					chmod($formvars['filename'], 0600);
				}
			}
		}else{
			echo "Submission Error";
		}
	}
}
if(isset($_POST['submitted'])){
	$temp = new USER();
	$temp->register();
}
?>
