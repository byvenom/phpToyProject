<?
include 'dbConn.php';


$no=$_POST['no'];
$frdt=$_POST['frdt'];
$todt=$_POST['todt'];
$name=$_POST['name'];
$memo=addslashes($_POST['memo']);
$now=date('Y-m-d');

$sql = "update schedule set frdt='$frdt', todt='$todt',insdt='$now' ,name='$name', memo='$memo' where no=$no";
if(mysqli_query($conn,$sql)){
	echo "<script>
		alert('수정성공');
		location.href='calView.php?no=$no';</script>";
}else{
	echo "<script>
		alert('수정실패');
		location.href='calView.php?no=$no';</script>";
}


?>