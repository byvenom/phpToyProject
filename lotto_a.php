<?
if($_GET["chk"] != true){
	include 'logincheck.php';
}
include 'dbConn.php';


$sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'songtest' AND TABLE_NAME = 'lottos'";
$result = mysqli_query($conn,$sql);
$tableIdx = mysqli_fetch_array($result);
$idx = $tableIdx['AUTO_INCREMENT'];
$sql="select * from lottos";
$result=mysqli_query($conn,$sql);
$goodData = "";
$data = "";
$data2 = "";
$data3 = "";
$data4 = "";
$data5 = "";
$num = array();
$num2 = array();
$count=mysqli_num_rows($result)-20;

function Percent_draw($items_list,$percent_list,$arr) {
    $range_now = 0;
    $range_last = 0;
    $decimal = 4;
    if(count($percent_list) != count($items_list)) return false;
    $draw = mt_rand(1,pow(10,$decimal)*array_sum($percent_list));
    for($sequence=0; $sequence<count($percent_list); $sequence++) {
        $range_now += pow(10,$decimal)*$percent_list[$sequence];
        if($range_now >= $draw && $range_last < $draw) {
            if(in_array($items_list[$sequence],$arr)){
				Percent_draw($items_list,$percent_list,$arr);
			}else{
			return $items_list[$sequence];
			}
        }else{
            $range_last = $range_now;
        }
    }
}
function recommendNumber($items,$itempercent) {
	$good = array();
	
	for ($i1=0; $i1 < 6; $i1++) {
		array_push($good,Percent_draw($items,$itempercent,$good));
	}
	
	sort($good);
	
	foreach($good as $val){
		$goodData.= $val."\r\n";
	}
	return $goodData;
}

while($row = mysqli_fetch_row($result)){

array_push($num,$row[1]);
array_push($num,$row[2]);
array_push($num,$row[3]);
array_push($num,$row[4]);
array_push($num,$row[5]);
array_push($num,$row[6]);
$data.= "<tr>";
$data.= "<th style='color:red;'>".$row[0]." 회</th>";
$data.= "<td align='center' valign='middle'>".$row[1]."</td>";
$data.= "<td align='center' valign='middle'>".$row[2]."</td>";
$data.= "<td align='center' valign='middle'>".$row[3]."</td>";
$data.= "<td align='center' valign='middle'>".$row[4]."</td>";
$data.= "<td align='center' valign='middle'>".$row[5]."</td>";
$data.= "<td align='center' valign='middle'>".$row[6]."</td>";
$data.= "</tr>";

if($count<$row[0]){
array_push($num2,$row[1]);
array_push($num2,$row[2]);
array_push($num2,$row[3]);
array_push($num2,$row[4]);
array_push($num2,$row[5]);
array_push($num2,$row[6]);
$data4.= "<tr>";
$data4.= "<th style='color:red;'>".$row[0]." 회</th>";
$data4.= "<td align='center' valign='middle'>".$row[1]."</td>";
$data4.= "<td align='center' valign='middle'>".$row[2]."</td>";
$data4.= "<td align='center' valign='middle'>".$row[3]."</td>";
$data4.= "<td align='center' valign='middle'>".$row[4]."</td>";
$data4.= "<td align='center' valign='middle'>".$row[5]."</td>";
$data4.= "<td align='center' valign='middle'>".$row[6]."</td>";
$data4.= "</tr>";
}
}

$temp = array_count_values($num);
$temp2 = array_count_values($num);
$temp3 = array_count_values($num2);
ksort($temp);
arsort($temp2);
arsort($temp3);
$items = array();
$itempercent_temp = array();
$itempercent = array();
$sums = 0;
foreach($temp as $x => $x_value){
	$sums = $sums + $x_value;
	array_push($items,$x);
	array_push($itempercent_temp,$x_value);
	$data2.="<tr>";
	$data2.="<th style='color:blue;'>$x 번</th>";
	$data2.="<td align='center' valign='middle'>$x_value</td>";
	$data2.="</tr>";	
}
foreach($itempercent_temp as $val){
	array_push($itempercent,$val/$sums*100);
	
}

$goodData=recommendNumber($items,$itempercent);
if($_GET["chk"] == true){
	$goodData=recommendNumber($items,$itempercent);
	echo $goodData;
}
$index =0;
foreach($temp2 as $x => $x_value){
	if($index < 20){
	$data3.="<tr>";
	$data3.="<th style='color:blue;'>$x 번</th>";
	$data3.="<td align='center' valign='middle'>$x_value</td>";
	$data3.="</tr>";
	}
	$index++;
}
$index2 =0;
foreach($temp3 as $x => $x_value){
	if($index2 < 20){
	$data5.="<tr>";
	$data5.="<th style='color:blue;'>$x 번</th>";
	$data5.="<td align='center' valign='middle'>$x_value</td>";
	$data5.="</tr>";
	}
	$index2++;
}





?>
<? if($_GET["chk"] != true){ ?>
<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<title>sample page</title> 
<style> 

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
h1 { font-size:14pt; padding:5px; background-color:#AAFFFF; } table tr td { padding:3px; background-color:#DDFFCC; } 
#num1 {
	width:25px;
	border-radius:30%;
    border: solid 2px red;
	font-weight:bold;
	text-align:center;
}
#num2 {
	width:25px;
	border-radius:30%;
    border: solid 2px orange;
	font-weight:bold;
	text-align:center;
}
#num3 {
	width:25px;
	border-radius:30%;
    border: solid 2px #f7e600;
	font-weight:bold;
	text-align:center;
}
#num4 {
	width:25px;
	border-radius:30%;
    border: solid 2px green;
	font-weight:bold;
	text-align:center;
}
#num5 {
	width:25px;
	border-radius:30%;
    border: solid 2px blue;
	font-weight:bold;
	text-align:center;
}
#num6 {
	width:25px;
	border-radius:30%;
    border: solid 2px navy;
	font-weight:bold;
	text-align:center;
}
#adminCheck{
	border:2px solid #8b00ff;border-radius:10% / 50%;padding:4px;margin-top:10px;font-weight:bold;text-align:center;
}
#adminCheck:focus{
	outline:none;
}
.parent {
    display: flex;
}
.child {
    flex: 1;
}
.button_l {

    width:50px;

    background-color: #f8585b;

    border: none;

    color:#fff;

    padding: 4px 0;

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
	input[type="number"]::-webkit-outer-spin-button,
	input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
$(document).ready(function() {
	$('#table4 tr:last ').css('border-width','5px');
	$('#table4 tr:last ').css('border-style','solid');
	$('#table4 tr:last ').css('border-color',"#ff6347");
	$('#table4 tr:last ').mouseenter(function(){
		$('#table4 tr:last ').css('border-color',"#00498c");
		$('#table4 tr:last ').css('zoom','1.3');
	});
	$('#table4 tr:last ').mouseleave(function(){
		$('#table4 tr:last ').css('border-color',"#ff6347");
		$('#table4 tr:last ').css('zoom','1.0');
	});
});
var numArr =new Array();
for(var i=1;i<=6;i++){

$(document).on("keyup", "input[name^=num"+i+"]", function() {
    var val= $(this).val();
	
    if(val.replace(/[0-9]/g, "").length > 0) {
        alert("숫자만 입력해 주십시오.");
        $(this).val('');
    }
	if(val !=""){
    if(val < 1 || val > 45) {
        alert("1~45 범위로 입력해 주십시오.");
        $(this).val('');
    }
	}
});
$(document).on("blur", "input[name^=num"+i+"]", function() {
	
    var val= $(this).val();
	
	if(val!="" && $(this).prop('readonly') == false){
		if(numArr.includes(val)){
			alert("중복된 값이 있습니다.");
			$(this).val('');
		}else{
		$(this).attr('readonly',true);
		numArr.push(val);
		}
	}

});
}



function onSubmit() {
		var params = $("#form").serialize();
	
		if($('#num1').val() != "" && $('#num2').val() != "" && $('#num3').val() != "" && $('#num4').val() != "" && $('#num5').val() != "" && $('#num6').val() != ""){
		if($('#adminCheck').val() !=""){
			$.ajax({
			url:'lotto_i.php',
			type:'POST',
			data:params,
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
        	dataType: 'html',
        	success: function (result) {
            if (result){
               location.reload()
            }else{
				alert('등록 키가 잘못되었습니다.');
				}
		}
		
		});
	}else{
		alert('등록 키를 입력해주세요.');
	}
	}else{
		alert('비어있는값이 있습니다.');
	}
}


function goGraph(){
	var gsWin = window.open('about:blank','graphviewer');
	var theForm = document.grForm;
	
	var js_array= <?php if($_GET["chk"] != true) echo json_encode($temp)?>;
	for(var i=1;i<=45;i++){
		var input = document.createElement('input');
		input.type = 'hidden';
		input.name = 'count'+[i];
		input.value = js_array[i];
		theForm.appendChild(input); 
	}
	theForm.target ="graphviewer";
	$('#grForm').submit();
	
}
function onReset(){
	if(numArr.length > 0){
	for(var i=1 ; i<=6 ;i++){
		$("#num"+i).val('');
		$("#num"+i).attr('readonly',false);
	}
	numArr = [];
	}
	else{
		alert('초기화 할 값이 없습니다.');
	}
}

function reload(){
	$.ajax({
		type : "GET",
		url : "lotto_a.php",
		data : {"chk":true},
		success : function(data){
			
			$('#good').html("추천번호 : "+data);
		}
	});
}
</script>

</head> 
<body>

<h1 align="center">로또정보</h1>
<div align="center">
<b>매주 <span style="color:blue">토요일</span> 밤 11시에 최신 회차 로또 당첨번호가 자동 업데이트 됩니다.</b>
<br/><br/>
<form id="form" name="form">
	
			<span id="good" style="font-size:32px;background:-webkit-linear-gradient(top, rgb(255, 180, 0), rgb(255, 0, 255));-webkit-background-clip:text;-webkit-text-fill-color:transparent;"><?="추천번호 : ".$goodData?></span>&nbsp;
<br/><br/>
<input class="button_l" type="button" onclick="reload();" value="돌리기" />
<div style="display:none;">
			<span style="margin-bottom:3px;"><b style='color:purple;'><?=$idx?>회</b></span>&nbsp;
			<input id="num1" class="num1" type="text" name="num1" />
			<input id="num2" class="num1" type="text" name="num2"/>
			<input id="num3" class="num1" type="text" name="num3"/>
			<input id="num4" class="num1" type="text" name="num4"/>
			<input id="num5" class="num1" type="text" name="num5"/>
			<input id="num6" class="num1" type="text" name="num6"/>
			<input type="button" class="button_l" value="등록" onclick="onSubmit();"/>&nbsp;<input type="button" value="초기화" class="button_l" onclick="onReset();"/>
			<br/>
			<br/>
			<b>등록 키 </b><br/><input type="text" id="adminCheck" name="adminCheck" />
</div>
</form>	
</div>
<!-- <form method="post" action="search.php">
<input type="text" name="str" id="str" style="height:25px;" placeholder="회사명을 입력하세요."/> <input class="button_l" type="submit" value="검색">
</form> -->

<div class="parent" style="width: 100%; height: 100px; ">
    <div class="child" style="width:20%">
<table valign="middle">
<tr>
	<th colspan="7">전체 회차</th>
</tr>
<tr>
<th>회차정보</th>
<th>n1</th>
<th>n2</th>
<th>n3</th>
<th>n4</th>
<th>n5</th>
<th>n6</th>
</tr> <?php if($_GET["chk"] != true) echo $data; ?> 
</table>
    </div>
    <div class="child" style="width:30%">
	<div class="parent">
	<div class="child">
	<table>
		<form name='grForm' id='grForm' method="POST" action="graph.php">
		
		<tr width="3%"><th colspan="2" >번호별 횟수 <img id="lookGraph" src="graph.jpeg" onclick="goGraph();" width="30px" height="30px" style="cursor:pointer;" title="그래프 보기"/></th></tr>
		<tr><th>번호</th><th>횟수</th></tr>
		<? if($_GET["chk"] != true) echo $data2; ?>
		</form>
	</table>
	</div>
	<div class="child">
	<table>
		<tr width="3%"><th colspan="2" >전체 TOP 20 번호</th></tr>
		<tr><th>번호</th><th>횟수</th></tr>
		<? if($_GET["chk"] != true) echo $data3 ?>
	</table>
	</div>
	</div>
    </div>
    <div class="child" style="width:50%">
		<div class="parent">
		<div class="child">
		<table id="table4" valign="middle" style="border-collapse:collapse;">
			<tr>
				<th colspan="7">최근 20회차 정보</th>
			</tr>
			<tr>
			<th>회차정보</th>
			<th>n1</th>
			<th>n2</th>
			<th>n3</th>
			<th>n4</th>
			<th>n5</th>
			<th>n6</th>
			</tr> <?php if($_GET["chk"] != true) echo $data4; ?> 
		</table>
		</div>
			<div class="child">
				<table>
					<tr width="3%"><th colspan="2" >최근 TOP 20 번호</th></tr>
					<tr><th>번호</th><th>횟수</th></tr>
					<? if($_GET["chk"] != true) echo $data5 ?>
				</table>
			</div>
		</div>
    </div>
</div>


</body>


</html>

<? } ?>