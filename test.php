!#/usr/local/php/bin/php -q
<?

include '/home/httpd/python/dbConn.php';
$sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'songtest' AND TABLE_NAME = 'lottos'";
$result = mysqli_query($conn,$sql);
$tableIdx = mysqli_fetch_array($result);
$idx = $tableIdx['AUTO_INCREMENT'];

function file_get_contents_curl($url) { 
	$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)';
	$ch = curl_init();
    curl_setopt ($ch, CURLOPT_USERAGENT,$agent); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); $data = curl_exec($ch); curl_close($ch);
	return $data; 
	}
$url ="https://www.dhlottery.co.kr/common.do?method=getLottoNumber&drwNo=$idx";
$data = file_get_contents_curl($url);
$R = json_decode($data,TRUE);
$num1 = $R['drwtNo1'];
$num2 = $R['drwtNo2'];
$num3 = $R['drwtNo3'];
$num4 = $R['drwtNo4'];
$num5 = $R['drwtNo5'];
$num6 = $R['drwtNo6'];

/* test 
$num1 = 1;
$num2 = 2;
$num3 = 3;
$num4 = 4;
$num5 = 5;
$num6 = 6;
*/
$sql = "insert into lottos(num1,num2,num3,num4,num5,num6) values($num1,$num2,$num3,$num4,$num5,$num6)";
$result = mysqli_query($conn,$sql);
mysqli_close($conn);

?>

