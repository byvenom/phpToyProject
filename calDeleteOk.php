<?
include 'dbConn.php';

$no=$_GET['no'];
$sql="delete from schedule where no=$no";
if(mysqli_query($conn,$sql)){
	echo "<script>
		alert('삭제성공');
		location.href='cal.php';</script>";
}else{
	echo "<script>
		alert('삭제실패');
		location.href='calView.php?no=$no';</script>";
}


















?>