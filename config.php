<?
   $ip=getenv('IP');
$connect=mysql_connect($ip, "binugoon", "") or die(mysql_error()); 
mysql_select_db("c9") or die(mysql_error()); 

?>
