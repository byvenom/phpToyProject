<?

include 'logincheck.php';


$data = "";
$xml = new SimpleXMLElement("CORPCODE.xml",0,true);
$data_arr= $xml->list;




function favoriteadd($corp_code,$stock_code) {
	$host="203.231.238.145";
	$user="root";
	$pw="inet5650";
	$dbName="songtest";
	$conn = mysqli_connect($host,$user,$pw,$dbName);
	$user_id = $_SESSION['user_id'];
	$sql = "select count(*) from favorites where userid='$user_id' and corp_code='$corp_code'";
	$result = mysqli_query($conn,$sql);
	$data = mysqli_fetch_assoc($result); 
	
	if($data["count(*)"]==0){
		$sql= "insert into favorites(userid,corp_code,stock_code) value('$user_id','$corp_code','$stock_code')";
		$result = mysqli_query($conn,$sql);
		mysqli_close($conn);
		if($result){
		echo "<script>alert('즐겨찾기에 추가되었습니다.');</script>";
		}else{
		echo "<script>alert('즐겨찾기에 추가에 실패하였습니다.');</script>";
		}
	}else{
		echo "<script>alert('이미 즐겨찾기에 담겨있습니다.');</script>";
	}
	
}
foreach($data_arr as $row){
if(strlen($row->stock_code) != 1){
	
	$data .= "<tr>";
	$data .= "<td>" . $row->corp_code . "</td>";
	$data .= "<td><a href='jusik2.php?corp_code=".$row->corp_code."&stock_code=".$row->stock_code."&company=".$row->corp_name."'>" . $row->corp_name . "</a></td>";
	$data .= "<td><form method='post'><input type='hidden' name='corp_code' value='".$row->corp_code."'><input class='button_l'type='submit' name='add' id='add' value='추가' style='width:50px;height:30px;margin-top:9px;'></form></td>";
	$data .="</tr>";
}
}
if(array_key_exists('add',$_POST)){
	favoriteadd($_POST['corp_code'],$_POST['stock_code']);
}
?>

<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title>sample page</title> 
<style> h1 { font-size:14pt; padding:5px; background-color:#AAFFFF; } table tr td { padding:5px; background-color:#DDFFCC; } 
.button_l {

    width:50px;

    background-color: #f8585b;

    border: none;

    color:#fff;

    padding: 2px 0;

    text-align: center;

    text-decoration: none;

    display: inline-block;

    font-size: 12px;

    margin: 2px;

    cursor: pointer;
	
	border-radius:10px;
	}
	.button_l:hover {
    background-color: blue;
}
</style>


</head> 
<body> 
<h1 align="center">메인</h1>
<form method="get" action="search.php">
<input type="text" name="str" id="str" style="height:25px;" placeholder="회사명을 입력하세요."/> <input class="button_l" type="submit" value="검색">
</form>
<table style="font-size:12px;width:431px;"> 
<tr>
<th>회사 코드</th>
<th>회사명</th>
<th>담기</th>
</tr> <?php echo $data; ?> 
</table>
</body>


</html>