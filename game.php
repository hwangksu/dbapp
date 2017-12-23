<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
function loser($db){
	if(($_SESSION['money']-10)>0){
		$_SESSION['money']=$_SESSION['money']-10;
		$rs = SQL( $db, "update gamehwang1 set money='".$_SESSION['money']."' where name='".$_SESSION['name']."' and account='".$_SESSION['acc']."' ");
		if ($rs->rowCount() == 1){
		}
	}else{
		$rs = SQL( $db, "update gamehwang1 set money=0 where name='".$_SESSION['name']."' and account='".$_SESSION['acc']."' ");
		$_SESSION['money']=0;
		echo '<a href="buy.php"><h1>你缺贏元了，請購買贏元!</h1></a>';
		exit;
	}
}
function winner($db){
		$_SESSION['money']=$_SESSION['money']+10;
		$rs = SQL( $db, "update gamehwang1 set money='".$_SESSION['money']."' where name='".$_SESSION['name']."' and account='".$_SESSION['acc']."' ");
}
function getdb($db){
	$rs = SQL( $db, "select * from gamehwang1 where name='".$_SESSION['name']."' and account='".$_SESSION['acc']."' ");
	if ($rs->rowCount() == 1){
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$_SESSION['money']=$row['money'];
			$_SESSION['name']=$row['name'];
		}
	}
}
if( $_SESSION['authenticated']==true){

} else {
      //不成功則導回重新登入
	  header('Location: login.html');
	  exit;
}

if(isset($_GET['acc']) ){
	$acc=$_GET['acc'];
	if ($_SESSION['acc']==$acc){
		getdb($db);
	}else {
      //不成功則導回重新登入
	  header('Location: login.html');
	  exit;
	}	
}
if(isset($_GET['n']) ){
	getdb($db);
	$num=rand(1,4);
	if( $_GET['n']==2 && $num==1 ){
		echo '<h1>電腦嬴,<img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name']."你輸了</h1>";
		loser($db);
	}else if ($_GET['n']==3 && $num==2 ){
		echo '<h1>電腦嬴,<img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name']."你輸了</h1>";
		loser($db);
	}else if ($_GET['n']==4 && $num==3 ){
		echo '<h1>電腦嬴,<img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name']."你輸了</h1>";
		loser($db);
	}else if ($_GET['n']==1 && $num==4 ){
		echo '<h1>電腦嬴,<img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name']."你輸了</h1>";
		loser($db);
	}else if ($_GET['n']==1 && $num==2 ){
		echo '<h1><img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name']."你嬴,電腦輸了</h1>";
		winner($db);
	}else if ($_GET['n']==2 && $num==3 ){
		echo '<h1><img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name']."你嬴,電腦輸了</h1>";
		winner($db);
	}else if ($_GET['n']==3 && $num==4 ){
		echo '<h1><img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name']."你嬴,電腦輸了</h1>";
		winner($db);
	}else if ($_GET['n']==4 && $num==1 ){
		echo '<h1><img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name']."你嬴,電腦輸了</h1>";
		winner($db);
	} else {
		echo "<h1>和局</h1>";
	}

echo '<h1><img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name']."你有贏元".$_SESSION['money']."元</h1>";
echo "電腦挑選的圖片是";
echo '<img src="./pic/4' .$num .'.jpg" width="185" height="205" />';
echo  '<img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name'];
echo "挑選的圖片是";
echo '<img src="./pic/4'.$_GET['n'].'.jpg" width="185" height="205" />';
echo "<p></p>";
echo  '<h1><img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name'];
echo "請挑選圖片,再玩一次</h1>";
		
} else {
echo '<h1><img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name']."你有贏元".$_SESSION['money']."元</h1>";
echo "<p></p>";
echo  '<h1><img src="'.$_SESSION['picpath'].'" width=50 height=60>'.$_SESSION['name'];
echo "請挑選圖片,來玩棒打老虎雞吃蟲</h1>";
}
?>
<a href="game.php?n=1"><img src="./pic/41.jpg" width="85" height="95" / ></a>
<a href="game.php?n=2"><img src="./pic/42.jpg" width="85" height="95" / ></a>
<a href="game.php?n=3"><img src="./pic/43.jpg" width="85" height="95" / ></a>
<a href="game.php?n=4"><img src="./pic/44.jpg" width="85" height="95" / ></a>
<form id="form" action="logout.php" method="post" >
    <input type="submit" value="不玩了"  size="35">
</form>

</body>
</html>
