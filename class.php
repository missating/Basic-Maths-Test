<?php 
class game{
	
	function game(){
		if(isset($_GET['restart'])){
		game::restart();
		}
		elseif(isset($_POST['submit_ans'])){
		game::evaluate();		
		}
		elseif(isset($_POST['startgame'])){
		//game::HTML();
		game::start($_POST['mode']);
		}else{
		game::HTML();
		game::menu();
		}
	}
	
	//the constructor
	function HTML(){
	echo"
	<!DOCTYPE HTML>
	<html>
	<head>
	<title> Basic Maths Test</title>
	<style type='text/css'>
	body{}
	#game_container{
	padding:1em;
	width:50%;
	margin:5% auto;
	text-align:center;
	border:1px outset purple;
	border-radius:15px;
	font-size:150%;
	cursor:crosshair;
	background:yellow;
	animation:mymove 10s infinite;
	/*Safari and Chrome:*/
	-webkit-animation:mymove 10s infinite;
	}

	@keyframes mymove
	{
	from {background-color:yellow;}
	to {background-color:lime;}
	}

	/*Safari and Chrome:*/
	@-webkit-keyframes mymove
	{
	from {background-color:yellow;}
	to {background-color:lime;}
	}
	hr{
	border:1px outset purple;
	}
	</style>
	</head>
	<body>
	<div id='game_container'>
	<h2>Nkoyo's Maths Game</h2>
	<hr>
	";
	}
	function menu(){
	echo"
	<form action='' method='post'>
	<p>Select Game Mode</p>
	<label><input type='radio' name='mode' value='1'>Addition</label><br>
	<label><input type='radio' name='mode' value='2'>Subtraction</label><br>
	<label><input type='radio' name='mode' value='3'>Multiplication</label><br>
	<label><input type='radio' name='mode' value='4'>All</label><br>
	<hr>
	<input type='submit' value='Start Game' name='startgame'>
	</form>
	</body>
	";
	}
	
	function start($mode){
	game::HTML();
	$a = rand(1,15);
	$b = rand(0,10);
	if($mode==4)
	{
		$gtype = rand(1,3);
	}else{
		$gtype =  $mode;
	}
	echo "<form action='' method='post'>\n";
	switch($gtype){
		case 1:{
				echo "$a + $b = <input type='number' name='answer' size='5' required>";
				$c = $a + $b;
				break;
			   }
		case 2:{
				echo "$a - $b = <input type='number' name='answer' size='5' required>";
				$c = $a - $b;
				break;
			   }
		case 3:{
				echo "$a x $b = <input type='number' name='answer' size='5' required>";
				$c = $a * $b;
				break;
			   }
	}
	game::post_answer($mode,$c);
	}
	
	function post_answer($mode, $c){
	echo "
	<input type='hidden' value='$c' name='c'>
	<input type='hidden' value='$mode' name='mode'>
	<input type='submit' value='Submit' name='submit_ans'>";
	}

	function evaluate(){
	$mode = $_POST['mode'];
	game::start($mode);
	$real_answer = $_POST['c'];
	$myanswer = $_POST['answer'];
	echo "<hr>";
	if($myanswer==$real_answer){
	echo "Correct!<br>";
	game::show_scores(1);
	}
	else{
	echo "Wrong!, The Correct answer is $real_answer<br>";
	game::show_scores(0);
	}
	}
	
	function show_scores($right){
	$right = (isset($_COOKIE['r']))?(int)$_COOKIE['r']+$right:0;
	$total = isset($_COOKIE['w'])?(int)$_COOKIE['w']+1:0;
	setcookie('r', $right, false, '', '');
    setcookie('w', $total, false, '', '');
	echo "SCORES: $right / $total";
	game::js_focus();
	}
	
	function restart(){
	setcookie('r', 0, false, '', '');
    setcookie('w', 0, false, '', '');
	header("location:$_SERVER[PHP_SELF]");
	}
	
	static function js_focus(){
	echo "<hr>
	<a href='?restart=1'>Restart</a>
	<script>
	document.forms[0].elements[0].focus();
	</script>
	</body>
	</html>
	";
	}
	
}


?>