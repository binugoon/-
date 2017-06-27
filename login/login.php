<head>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-item.css" rel="stylesheet">
    <meta charset="utf-8">
</head>
<?php 

//Connects to your Database 
$ip=getenv('IP');
$conect = mysqli_connect($ip,"binugoon","", "c9") or die(mysql_error()); 



 //if the login form is submitted 
 if (isset($_POST['submit'])) {

	// makes sure they filled it in
 	if(!$_POST['username']){
 		die('유저이름을 입력하시지 않았습니다.');
 	}
 	if(!$_POST['pass']){
 		die('비밀번호를 입력하시지 않았습니다.');
 	}

 	// checks it against the database
 	if (!get_magic_quotes_gpc()){
 		$_POST['email'] = addslashes($_POST['email']);
 	}

 	$check = mysqli_query($conect, "SELECT * FROM users WHERE username = '".$_POST['username']."'")or die(mysql_error());

 //Gives error if user dosen't exist
 $check2 = mysqli_num_rows($check);
 if ($check2 == 0){
	die('그런 유저이름은 없습니다.<br /><br />틀리셨다 생각하시면 <a href="login.php">다시 시도하세요</a>.');
}

while($info = mysqli_fetch_array( $check )){
	$_POST['pass'] = stripslashes($_POST['pass']);
 	$info['password'] = stripslashes($info['password']);
 	$_POST['pass'] = md5($_POST['pass']);

	//gives error if the password is wrong
 	if ($_POST['pass'] != $info['password']){
 		die('비밀번호를 틀리셨습니다, 다시 <a href="login.php">시도하세요</a>.');
 	}
	
	else{ // if login is ok then we add a cookie 
		$_POST['username'] = stripslashes($_POST['username']); 
		$hour = time() + 3600; 
		setcookie(ID_your_site, $_POST['username'], $hour); 
		setcookie(Key_your_site, $_POST['pass'], $hour);	 
 
		//then redirect them to the members area 
		header("Location: members.php"); 
	}
}
}
else{
// if they are not logged in 
?>
 <center>
 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 

 <table border="0"> 

 <tr><td colspan=2><h1>로그인 창</h1></td></tr> 

 <tr><td>유저이름:</td><td> 

 <input type="text" name="username" maxlength="40"> 

 </td></tr> 

 <tr><td>패스워드:</td><td> 

 <input type="password" name="pass" maxlength="50"> 

 </td></tr> 

 <tr><td colspan="2" align="right"> 

 <input type="submit" name="submit" value="Login"> 

 </td></tr> 

 </table> 

 </form> 
 </center>
 <?php 
 }
 ?> 
