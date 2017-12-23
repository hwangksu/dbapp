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
	$_SESSION['money']=$_SESSION['money']+100;
	$rs = SQL( $db, "update gamehwang1 set money='".$_SESSION['money']."' where name='".$_SESSION['name']."' and account='".$_SESSION['acc']."' ");
	$redir = 'game.php?acc='.$_SESSION['acc'] ;
	header("Location: $redir");
	exit;
} else {
	//不成功則導回重新登入
	header('Location: login.html');
	exit;
}

?>
