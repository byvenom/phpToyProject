<?php
include 'dbConn.php';
if(!isset($_POST['user_id']) || !isset($_POST['user_pw'])) exit;
$user_id = $_POST['user_id'];
$user_pw = $_POST['user_pw'];
$sql = "select count(*) from users where userid='$user_id'";
$result = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($result);

if($data["count(*)"]==0) {
        echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
        exit;
}else{
	$sql = "select * from users where userid='$user_id'";
	$result = mysqli_query($conn,$sql);
	$data = mysqli_fetch_assoc($result);
	
	$user_name = $data['name'];
	if($data['password'] != $user_pw){
		echo "<script>alert('아이디 또는 패스워드가 잘못되었습니다.');history.back();</script>";
        exit;
	}
}

session_start();
$access_ip = $_SERVER["REMOTE_ADDR"];
date_default_timezone_set('Asia/Seoul');
$date = date('Y-m-d H:i:s');
$sql = "insert into login_log(access_ip,userid,access_time) values('$access_ip','$user_id','$date')";
$result = mysqli_query($conn,$sql);
mysqli_close($conn);
$_SESSION['user_id'] = $user_id;
$_SESSION['user_name'] = $user_name;
?>
<meta http-equiv='refresh' content='0;url=index.php'>