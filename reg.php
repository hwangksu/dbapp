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
function isDirExist($path){
        if(!file_exists($path)){
                mkdir($path, 0777);
        }
}
	$name=$_POST['name'];
	$code=$_POST['code']; //加以編碼
	$pass=$_POST['pass']; //加以編碼
	$pass2=$_POST['pass2']; //加以編碼
	$male=$_POST['male'];
	$dep=$_POST['mail']; //加以編碼
if((isset($_POST['name'])&& isset($_POST['code']) && isset($_POST['pass']) && isset($_POST['pass2'])) &&( $_POST['name']=="" || $_POST['code']=="" || $_POST['pass']=="" || $_POST['pass2']=="")){
		echo "姓名與帳號與密碼不可空白<br />";
		echo "<a href=\"reg.html\">返回註冊玩家資料</a><br />";
} else {
		//先檢查是否有重複資料
	$rs = SQL($db,"SELECT * FROM gamehwang1 where  account='".$code."'  ");
        if ($rs->rowCount() > 0){
		echo "<h1>帳號重複已有人註冊:</h1><br />";
		echo "<a href=\"reg.html\">返回註冊玩家資料</a><br />";
        } else {
	if ($pass == $pass2){
		if ( $_FILES["fileField"]["error"] > 0 ) {
				$pic="pic/11.jpg";
		}else{
			$type=$_FILES['fileField']['type'];
			$size=$_FILES['fileField']['size'];
			$filename=$_FILES['fileField']['name'];
			$tmp_name=$_FILES['fileField']['tmp_name'];
			if($type=="image/png" || $type=="image/gif" || $type=="image/jpeg" ){
				isDirExist("upload/".$code);
				$pic="upload/".$code."/".$filename;
				move_uploaded_file($tmp_name,$pic);
			}
		}
	$row = SQL($db,"insert into gamehwang1 (name, account, pass , male, depart, pic) values ('".$name."', '".$code."', '".$pass."', '".$male."', '".$dep."', '".$pic."') ");
			if ($row->rowCount() ==1){
				header("location: login.html");
			}
		} else {
			echo "密碼不同錯誤"."<br />";
			echo "<a href=\"reg.html\">返回註冊玩家資料</a><br />";
		}
    }
}
?>
