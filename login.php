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
		$name=$_POST['name'];
		$code=$_POST['code']; //加以編碼
	if((isset($_POST['name'])&&isset($_POST['code']))&& ($_POST['name']=="" || $_POST['code']=="")){
		echo "帳號與密碼不可空白<br />";
		echo "<a href=\"login.html\">返回登入資料</a><br />";
	} else {
	$rs = SQL($db,"SELECT * FROM gamehwang1 where account='".$name."' and pass='".$code."' ");
	if ($rs->rowCount() ==1){  //登入成功
	   $row = $rs->fetch(PDO::FETCH_ASSOC);
                    // 寫入 Session 變數值
                  $_SESSION['authenticated'] = true;
	   $_SESSION['picpath']=$row['pic'];
	   $_SESSION['money']=$row['money'];
	   $_SESSION['name']=$row['name'];
	   $_SESSION['acc']=$row['account'];
//                     $redir = 'game2.php?acc='.$name;
                     $redir = 'game.php?acc='.$name;
                 header("Location: $redir");
              }else{
                     header("Location: login.html");
	}
}
?>
