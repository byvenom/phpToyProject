<?
	session_start();
	include './dbConn2.php';
	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
	$uri = explode('/', $uri); 
	if ($uri[2] !== 'info') { 
	header("HTTP/1.1 404 Not Found"); 
	exit(); 
	}
	$api_arrry=array();

	$sql="select api_key,userid from api";
	$result = mysqli_query($conn, $sql); 
	while($row=mysqli_fetch_row($result)){
		array_push($api_arrry,$row[0]);
	
	}
	if(!in_array($uri[3],$api_arrry)){
		header("HTTP/1.1 400 Bad Request"); 
		exit(); 
	}
	/*else{
		$sql = "select userid from api where api_key='$uri[3]'";
		$result = mysqli_query($conn, $sql);
		$data = mysqli_fetch_assoc($result);
		if($data['userid'] !== $_SESSION['user_id']){
			header("HTTP/1.1 405 Bad Request"); 
			exit(); 
		}
	}*/  // 로그인 유저 체크
	$requestMethod = $_SERVER["REQUEST_METHOD"]; 
	switch ($requestMethod) {
	 case 'GET':
		require_once 'lotte_check.php';
		
		break;
	 default:
		break; 
	}
	
?>

