<?
include 'dbConn.php';
session_start();



$frdt=$_POST['frdt'];
$todt=$_POST['todt'];
$name=$_POST['name'];
$memo=addslashes($_POST['memo']);
$now=date('Y-m-d');
$userid=$_SESSION['user_id'];
$sql = "insert into schedule values(no,'$frdt','$todt','$now','$memo','$name','$userid')";
if(mysqli_query($conn,$sql)){
	echo "<script>
		alert('작성성공');
		location.href='cal.php';</script>";
}else{
	echo("쿼리오류 발생: " . mysqli_error($conn));
	
}


?>