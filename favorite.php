<?

include 'logincheck.php';
include 'dbConn.php';

$data = "";
$xml = new SimpleXMLElement("CORPCODE.xml",0,true);
$data_arr= $xml->list;




function favoritedelete($corp_code) {
	$host="203.231.238.145";
	$user="root";
	$pw="inet5650";
	$dbName="songtest";
	$conn = mysqli_connect($host,$user,$pw,$dbName);
	$user_id = $_SESSION['user_id'];
	$sql = "select count(*) from favorites where userid='$user_id' and corp_code='$corp_code'";
	$result = mysqli_query($conn,$sql);
	$data = mysqli_fetch_assoc($result); 
	if($data["count(*)"]>0){
		$sql= "delete from favorites where userid='$user_id' and corp_code='$corp_code'";
		$result = mysqli_query($conn,$sql);
		mysqli_close($conn);
		if($result){
		echo "<script>alert('즐겨찾기에서 삭제되었습니다.');location.replace('favorite.php');</script>";
		}else{
		echo "<script>alert('즐겨찾기 삭제에 실패하였습니다.');</script>";
		}
	}else{
		echo "<script>alert('없는정보입니다.');</script>";
	}
	
}
$user_id = $_SESSION['user_id'];
$sql = "select corp_code from favorites where userid='$user_id'";
$result = mysqli_query($conn,$sql);
$corp_Arr = array();
$info_Arr = array();

while($row = mysqli_fetch_row($result)){
	array_push($corp_Arr,$row[0]);
	
}




foreach($data_arr as $row){
if(strlen($row->stock_code) != 1){
	if(in_array($row->corp_code,$corp_Arr)){
	array_push($info_Arr,$row->corp_name);
	array_push($info_Arr,$row->stock_code);
	$data .= "<tr>";
	$data .= "<td>" . $row->corp_code . "</td>";
	$data .= "<td><a href='jusik2.php?corp_code=".$row->corp_code."&stock_code=".$row->stock_code."&company=".$row->corp_name."'>" . $row->corp_name . "</a></td>";
	$data .= "<td><form method='post'><input type='hidden' name='corp_code' value='".$row->corp_code."'><input class='button_l' type='submit' name='delete' id='delete' value='삭제' style='width:50px;height:30px;margin-top:9px;'></form></td>";
	$data .="</tr>";
}
}
}
$data2 = "";
$data3 = "";
foreach($info_Arr as $key => $val){
	if($key % 2 ==0){
		$data2.="<h3>$val</h3>";
		
	}else{
		$data3.="<div><iframe class=''src='iframe_5.php?stock_code=$val' width='680' height='70'scrolling='no' frameborder='0' ></iframe></div>";
		$data2.="<div><iframe src='iframe_1.php?stock_code=$val' width='680' height='555'scrolling='no' frameborder='0' ></iframe></div>";
		$data3.="<div><iframe src='iframe_3.php?stock_code=$val' width='680' height='555'scrolling='no' frameborder='0' ></iframe></div>";
	}
	
}

if(array_key_exists('delete',$_POST)){
	favoritedelete($_POST['corp_code']);
}
?>

<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title>sample page</title> 
<style> h1 { font-size:14pt; padding:5px; background-color:#AAFFFF; } table tr td { padding:5px; background-color:#DDFFCC; } 

iframe{
	pointer-events: none;
}
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
.parent {
    display: flex;
}
.child {
    flex: 1;
}
</style>

	
<script>
$(document).keydown(function(event) {
if (event.ctrlKey==true && (event.which == '61' || event.which == '107' || event.which == '173' || event.which == '109'  || event.which == '187'  || event.which == '189'  ) ) {
        event.preventDefault();
     }
if( event.which =='9'){

	event.preventDefault();
}
    // 107 Num Key  +
    // 109 Num Key  -
    // 173 Min Key  hyphen/underscor Hey
    // 61 Plus key  +/= key
});

$(window).bind('wheel', function (event) {
		
       if (event.ctrlKey == true) {
	
       event.preventDefault();
		  event.stopPropagation();
       }
});
</script>
</head> 
<body>

<h1 align="center">즐겨찾기</h1>
<!-- <form method="post" action="search.php">
<input type="text" name="str" id="str" style="height:25px;" placeholder="회사명을 입력하세요."/> <input class="button_l" type="submit" value="검색">
</form> -->

<? if(count($corp_Arr) != 0){ ?>
<div class="parent" style="width: 100%; height: 100px; ">
<div class="child" >
<table style="font-size:12px;width:431px;"> 
<tr>
<th width="63px">회사 코드</th>
<th width="296px">회사명</th>
<th width="64px">담기</th>
</tr> <?php echo $data; ?> 
</table>
</div>
<div class="child" >
<? echo $data2; ?>
</div>
<div class="child" >
<? echo $data3; ?>
</div>
	
</div>
</div>
<? } else{ ?>
<p>즐겨찾기에 등록된 정보가 없습니다.</p>
<? } ?>
</body>


</html>