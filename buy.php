<!DOCTYPE html>

<html lang="zh-Hant-TW" >
<head>
<meta charset="UTF-8" />
</head>
<body>
<?php
$lifeTime = 3600 * 24 * 30;    ////// 30天 
session_set_cookie_params($lifeTime);
session_start();

date_default_timezone_set("asia/taipei");
header('Content-Type: text/html; charset=utf-8');

try{
	$db = new PDO("mysql:host=localhost;dbname=ksuie106", "hwang", "hwang123");
	$db->exec("set names utf8");	
}
catch (PDOException $e){
	echo "Error :".$e->getMessage();
}

function SQL($db,$sql){
	return $db->query($sql);
}
function CSQL($db,$sql){
	return current($db->query($sql)->fetch());
}
function ASQL($db,$sql){
	return current($db->query($sql)->fetchAll(PDO::FETCH_ASSOC));
}
if( $_SESSION['authenticated']==true){
} else {
      //不成功則導回重新登入
	  header('Location: login.html');
	  exit;
}
?>
<p></p>
<form id="form" action="buy100.php" method="post" >
    <input type="submit" value="購買100贏元">
</form>

</body>
</html>
