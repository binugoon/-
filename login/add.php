<html>
<head><meta charset="utf-8">
<!-- 합쳐지고 최소화된 최신 CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- 부가적인 테마 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- 합쳐지고 최소화된 최신 자바스크립트 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>
<?php 
//Connects to your Database 
$ip=getenv('IP');
mysql_connect($ip, "binugoon", "") or die(mysql_error()); 
mysql_select_db("c9") or die(mysql_error()); 

//This code runs if the form has been submitted
if (isset($_POST['submit'])) { 

//This makes sure they did not leave any fields blank
if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'] ) {
	die('필요한 부분을 다 입력하시지 않았습니다.');
}

// checks if the username is in use
if (!get_magic_quotes_gpc()) {
	$_POST['username'] = addslashes($_POST['username']);
}

$usercheck = $_POST['username'];
$check = mysql_query("SELECT username FROM users WHERE username = '$usercheck'") 
or die(mysql_error());
$check2 = mysql_num_rows($check);

//if the name exists it gives an error
if ($check2 != 0) {
 	die('이미 이 유저이름 '.$_POST['username'].' 은 사용중입니다..');
}

// this makes sure both passwords entered match
if ($_POST['pass'] != $_POST['pass2']) {
	die('패스워드 확인을 틀리셨습니다. ');
}

// here we encrypt the password and add slashes if needed
$_POST['pass'] = md5($_POST['pass']);

if (!get_magic_quotes_gpc()) {
	$_POST['pass'] = addslashes($_POST['pass']);
	$_POST['username'] = addslashes($_POST['username']);
}

// now we insert it into the database
$insert = "INSERT INTO users (username, password) VALUES ('".$_POST['username']."', '".$_POST['pass']."')";
$add_member = mysql_query($insert);
?>

 <h1>등록되었습니다.</h1>

 <p>회원가입을 축하드립니다. 이 창을 통해 <a href="login.php">로그인</a>하세요.</p>

 <?php 
 }

 else 
 {	
 ?>
 
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

 <table border="0">

 <tr><td>유저이름:</td><td>

 <input type="text" name="username" maxlength="60">

 </td></tr>

 <tr><td>비밀번호:</td><td>

 <input type="password" name="pass" maxlength="10">

 </td></tr>

 <tr><td>비밀번호 확인:</td><td>

 <input type="password" name="pass2" maxlength="10">

 </td></tr>

 <tr><th colspan=2><input type="submit" name="submit" 
value="가입"></th></tr> </table>

 </form>

 <?php
 }
 ?> 
 </html>
