<meta charset="utf-8">
<?php
//Connects to your Database 
$ip=getenv('IP');
mysql_connect($ip, "binugoon", "") or die(mysql_error()); 
mysql_select_db("c9") or die(mysql_error()); 

 //checks cookies to make sure they are logged in 
 if(isset($_COOKIE['ID_your_site'])){ 

 	$username = $_COOKIE['ID_your_site']; 
 	$pass = $_COOKIE['Key_your_site']; 
 	$check = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error()); 

 	$info = mysql_fetch_array( $check ); 

		//if the cookie has the wrong password, they are taken to the login page 
 		if ($pass != $info['password']){
			header("Location: login.php"); 
 		}
		//otherwise they are shown the admin area
		else{
		    if($username == "admin"){
				 echo "Admin Area<p>"; 
		    }
		    else{
     echo "<a href=main.php>홈페이지 접속</a> <p>"; 
     echo "<a href=logout.php>로그아웃</a>"; 
		    }
 		}
	
}

 else{ //if the cookie does not exist, they are taken to the login screen 
	header("Location: login"); 
 }
 ?>
