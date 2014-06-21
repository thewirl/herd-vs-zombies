<?php
class LOGIN{
	private $userID;
	function __construct(){
		$this->userID="";
	}
	private function collect(&$formvars){
		$formvars['usertemp'] = $_POST['username'];
		$formvars['filename'] = "../usr/" . $_POST['username'] . '.md';
		$formvars['password'] = $_POST['password'];
	}
	private function verify(&$formvars){
			$file = fopen($formvars['filename'], "r");
			if($file==false){
				echo "File error";
				fclose($file);
			}else{
				$s = filesize($formvars['filename']);
				$d = new DOMDocument();
				$d->validateOnParse=true;
				$d->loadXML(fread($file,$s));
				$d->preserveWhiteSpace = false;
				$x = new DOMXPath($d);
				$p = $x->query("//*[@id='PASSWORD']")->item(0);	
				$a = $p->nodeValue;	$a = trim($a);	$b = $formvars['password'];	$b = trim($b);
				if($a==$b){
						$this->userID = $formvars['usertemp'];
						echo $p->nodeValue;
						echo $formvars['password'];
						echo "Logged in";
					}else{
						echo $p->nodeValue;
						echo $formvars['password'];
						echo "Login failed";					
				}
			}
			fclose($file);
	}
	public function login(){
		$formvars = array();
		$this->collect($formvars);
		if(isset($_POST['loggedin'])){
			if(file_exists($formvars['filename'])){
				echo $this->verify($formvars);
			}else{
				echo "Username not found";
			}
		}else{
			echo "Submission Error";
		}
	}
	public function logout(){
		$this->userID="";
		echo "logged out";
	}
	public function getuser(){
		if($this->userID!=""){
			echo 'usr/' . $this->userID . '.md';
		}else{
			echo 'User check error';
		}
	}
	public function getuserID(){
		if($this->userID!=""){
			echo $this->userID;
		}else{
			echo 'User check error';
		}
	}
	public function team(){
		$XML_RENDER = simplexml_load_file('../usr/' . $this->userID . '.md');
		echo $XML_RENDER->div[4];
	}
}
session_start();
if(isset($_POST['loggedin'])){
	if(!isset($_SESSION['CUSER'])){
		$_SESSION['CUSER']=new LOGIN();
	}else{
		unset($_SESSION['CUSER']);
		$_SESSION['CUSER']=new LOGIN();
	}
	echo $_SESSION['CUSER']->login();
}
if(isset($_POST['loggedout'])){
	if(!isset($_SESSION['CUSER'])){
		echo "Session error";
	}else{
		 session_destroy();
	}
}
if(isset($_POST['getuser'])){
	if(!isset($_SESSION['CUSER'])){
		echo "Session error";
	}else{
		echo $_SESSION['CUSER']->getuser();
	}
}
if(isset($_POST['team'])){
	if(!isset($_SESSION['CUSER'])){
		echo "Session error";
	}else{
		echo $_SESSION['CUSER']->team();
	}
}
?>
