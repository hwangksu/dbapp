<?php
$lifeTime = 3600 * 24 * 30;    ////// 30天 
session_set_cookie_params($lifeTime);
session_start();

date_default_timezone_set("asia/taipei");
header('Content-Type: text/html; charset=utf-8');

try{
	$db = new PDO("mysql:host=localhost;dbname=ksuie105a", "ksu4010e000", "ksu");
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
session_unset();
session_destroy();
                   // 重導到相關頁面
                     header("Location: login.html");
					 exit;

?>
