<?
session_start();
include 'dbConn.php';
$now = date("Y-m-d H:i:s");
$userid=$_SESSION['user_id'];

function generateRandomString($length = 30) {  
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';  
	$charactersLength = strlen($characters);  
	$randomString = '';

	for ($i = 0; $i < $length; $i++) {  
		$randomString .= $characters[rand(0, $charactersLength - 1)];  
	}

	$sql ="select count(*) from api where api_key='$randomString'";
	$result = mysqli_query($conn,$sql);
	$data = mysqli_fetch_assoc($result);

	if($data["count(*)"]>0){
		generateRandomString();
	}else{
		return $randomString;

	}
}
if($_POST['gubun']=='add'){

$randomString=generateRandomString();
echo $randomString;

$sql ="insert into api (userid,api_key,regdate) values('$userid','$randomString','$now')";
$result = mysqli_query($conn,$sql);
mysqli_close($conn);
}else if($_POST['gubun']=='check'){
$sql ="select api_key from api where userid='$userid'";
$result = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($result);

if($data["api_key"]){
	echo $data["api_key"];
}else{
	echo "false";
}
}else if($_POST['gubun']=='update'){
$randomString=generateRandomString();
echo $randomString;

$sql ="update api set api_key='$randomString' where userid='$userid'";
$result = mysqli_query($conn,$sql);
mysqli_close($conn);
}
?>