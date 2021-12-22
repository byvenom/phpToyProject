<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
	let today = new Date();
	function insert_Schedule(y,m,d){
		post_to_url('calInsert.php',{'y':y,'m':m,'d':d});
	}
	function post_to_url(path,params,method){
		method = method || "post";
		
		var form = document.createElement("form");
		form.setAttribute("method",method);
		form.setAttribute("action",path);
		for(var key in params){
			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type","hidden");
			hiddenField.setAttribute("name",key);
			hiddenField.setAttribute("value",params[key]);
			form.appendChild(hiddenField);
		}
	document.body.appendChild(form);
	form.submit();
		

	}
	function nowOver(d){
		$(`#now${d}`).show();
	}
	function nowOut(d){
		$(`#now${d}`).hide();
	}
	function beforeOver(d){
		$(`#before${d}`).show();
	}
	function beforeOut(d){
		$(`#before${d}`).hide();
	}
	function afterOver(d){
		$(`#after${d}`).show();
	}
	function afterOut(d){
		$(`#after${d}`).hide();
	}
	function moveToday(){
		var yy = today.getFullYear();
		var mm =today.getMonth()+1;
		location.href=`cal.php?yy=${yy}&mm=${mm}`;
	}
	function before(mm){
		var yy = $('#yy option:selected').val();
		if(mm==1){
			location.href=`cal.php?yy=${Number(yy)-1}&mm=12`;
		}else{
			location.href=`cal.php?yy=${yy}&mm=${mm-1}`;
		}
	}
	function after(mm){
		var yy = $('#yy option:selected').val();
		if(mm==12){
			location.href=`cal.php?yy=${Number(yy)+1}&mm=1`;
		}else{
			location.href=`cal.php?yy=${yy}&mm=${Number(mm)+1}`;
		}
	}
</script>
<style>
	h1 { font-size:14pt; padding:5px; background-color:#AAFFFF; } 
	div.left {
        width: 50%;
        float: left;
        box-sizing: border-box;
        
      
    }
    div.right {
        width: 50%;
        float: right;
        box-sizing: border-box;
        
     
    }
</style>
<?


include 'logincheck.php';
include 'dbConn.php';
$abc = 1;
$yy = $_REQUEST['yy'];
$mm = $_REQUEST['mm'];
if($yy == '') $yy = date('Y');
if($mm == '') $mm = date('m');

function sel_yy($yy, $func) {
	if($yy == '') $yy = date('Y');

	if($func=='') {
		$str = "<select  name='yy'>\n<option value=''></option>\n";
	} else {
		$str = "<select  id='yy' name='yy' onChange='$func'>\n<option value=''></option>\n";
	}
	$gijun = date('Y');
	for($i=$gijun-5;$i<$gijun+5;$i++) {
		if($yy == $i) $str .= "<option value='$i' selected>$i</option>";
		else $str .= "<option value='$i'>$i</option>";
	}
	$str .= "</select>";
	return $str;
}

function sel_mm($mm, $func) {
	if($func=='') {
		$str = "<select name='mm'>\n";
	} else {
		$str = "<select name='mm' onChange='$func'>\n";
	}
	for($i=1;$i<13;$i++) {
		if($mm == $i) $str .= "<option value='$i' selected>{$i}월</option>";
		else $str .= "<option value='$i'>{$i}월</option>";
	}
	$str .= "</select>";
	return $str;
}

function get_schedule($yy,$mm,$dd) {
	include 'dbConn.php';
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
	$dd = str_pad($dd, 2, "0", STR_PAD_LEFT);
	$dtstr = $yy."-".$mm."-".$dd;
	$sql = "SELECT *
FROM schedule
WHERE frdt <= '$dtstr'
AND todt >= '$dtstr'
AND userid = '$_SESSION[user_id]'
ORDER BY frdt, todt";
	$str="";
	$ret = mysqli_query($conn,$sql);
	
	while($row = mysqli_fetch_assoc($ret)) {
		if(strlen($row['name'])>20){
	$name = iconv_substr($row['name'],0,10,"utf-8")."...";
}else{
	$name = $row['name'];
}
		$str .= "<br/><font id='$dtstr' style='font-size:8pt;'><a href='calView.php?no=$row[no]' title='$row[name]'>- $name</a></font>";
		echo "<script>$(document).ready(function() {
				$('#$dtstr').parent().css({'background-color':'#FFC0CB'});
		})</script>";
	}
	return $str;
}
function get_schedule_before($yy,$mm,$dd) {
	include 'dbConn.php';
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
	$dd = str_pad($dd, 2, "0", STR_PAD_LEFT);
	$dtstr = $yy."-".$mm."-".$dd;
	$sql = "SELECT *
FROM schedule
WHERE frdt <= '$dtstr'
AND todt >= '$dtstr'
AND userid = '$_SESSION[user_id]'
ORDER BY frdt, todt";
	$str="";
	$ret = mysqli_query($conn,$sql);
	
	while($row = mysqli_fetch_assoc($ret)) {
		if(strlen($row['name'])>20){
	$name = iconv_substr($row['name'],0,10,"utf-8")."...";
}else{
	$name = $row['name'];
}
		$str .= "<br/><font id='$dtstr' style='font-size:8pt;'><a href='calView.php?no=$row[no]' title='$row[name]'>- $name</a></font>";
		echo "<script>$(document).ready(function() {
				$('#$dtstr').parent().css({'background-color':'#b2ff8c'});
		})</script>";
	}
	return $str;
}
function get_schedule_after($yy,$mm,$dd) {
	include 'dbConn.php';
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
	$dd = str_pad($dd, 2, "0", STR_PAD_LEFT);
	$dtstr = $yy."-".$mm."-".$dd;
	$sql = "SELECT *
FROM schedule
WHERE frdt <= '$dtstr'
AND todt >= '$dtstr'
AND userid = '$_SESSION[user_id]'
ORDER BY frdt, todt";
	$str="";
	$ret = mysqli_query($conn,$sql);
	
	while($row = mysqli_fetch_assoc($ret)) {
		if(strlen($row['name'])>20){
	$name = iconv_substr($row['name'],0,10,"utf-8")."...";
}else{
	$name = $row['name'];
}
		$str .= "<br/><font id='$dtstr' style='font-size:8pt;'><a href='calView.php?no=$row[no]' title='$row[name]'>- $name</a></font>";
		echo "<script>$(document).ready(function() {
				$('#$dtstr').parent().css({'background-color':'#ffa369'});
		})</script>";
	}
	return $str;
}


// 1. 총일수 구하기
$last_day = date("t", strtotime($yy."-".$mm."-01"));
$mm2=$mm-1;
$last_day_before = date("t", strtotime($yy."-".$mm2."-01"));
// 2. 시작요일 구하기
$start_week = date("w", strtotime($yy."-".$mm."-01"));

// 3. 총 몇 주인지 구하기
$total_week = ceil(($last_day + $start_week) / 7);

// 4. 마지막 요일 구하기
$last_week = date('w', strtotime($yy."-".$mm."-".$last_day));

$def = $last_day_before-$start_week+1;
?>
<h1 align="center">캘린더</h1>
<div class="left">
<form name="form" method="get">
<table width='98%' cellpadding='0' cellspacing='1' bgcolor="#999999">
<tr>
<td height="50" align="center" bgcolor="#FFFFFF" >
	<input type="button" value="&lt" onclick="before('<?=$mm?>')">
</td>
<td height="50" align="center" bgcolor="#FFFFFF" colspan="5" >
<?=sel_yy($yy,'submit();')?>년 <?=sel_mm($mm,'submit();')?>월 <input type="button" value="Today" onclick="moveToday()"></td>
<td height="50" align="center" bgcolor="#FFFFFF">
	<input type="button" value="&gt" onclick="after('<?=$mm?>')">
</td>
</tr>
<tr>
<td width="130" height="30" align="center" bgcolor="#DDDDDD"><b>일</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>월</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>화</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>수</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>목</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>금</b></td>
<td width="130" align="center" bgcolor="#DDDDDD"><b>토</b></td>
</tr>

<?
$today_yy = date('Y');
$today_mm = date('m');
// 5. 화면에 표시할 화면의 초기값을 1로 설정
$day=1;


// 6. 총 주 수에 맞춰서 세로줄 만들기
for($i=1; $i <= $total_week; $i++){?>
<tr>
<?

	// 7. 총 가로칸 만들기
	for ($j=0; $j<7; $j++){
?>

  <?
	// 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않아야하므로
	//    그 반대의 경우 -  ! 으로 표현 - 에만 날자를 표시한다.
	if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))){ ?>
<td width="130" height="120" align="left" valign="top" bgcolor="skyblue" onmouseover="nowOver('<?=$day?>')" onmouseout="nowOut('<?=$day?>')">
<?
		if($j == 0){
			// 9. $j가 0이면 일요일이므로 빨간색
			echo "<font color='#FF0000'><b>";
		}else if($j == 6){
			// 10. $j가 0이면 일요일이므로 파란색
			echo "<font color='#0000FF'><b>";
		}else{
			// 11. 그외는 평일이므로 검정색
			echo "<font color='#000000'><b>";
		}

		// 12. 오늘 날자면 굵은 글씨
		if($today_yy == $yy && $today_mm == $mm && $day == date("j")){
			echo "<u>";
		}
		
		// 13. 날자 출력
		echo $day;
	
		if($today_yy == $yy && $today_mm == $mm && $day == date("j")){
			echo "</u>";
		}
			if($today_yy == $yy && $today_mm == $mm && $day == date("j")){
			echo "<font id='toto' align='right' style='color:red'>  Today</font>";
			echo "<script>$(document).ready(function() {
				$('#toto').parent().parent().parent().css({'border':'1px solid blue'});
		})</script>";
		}
		echo "</b></font> &nbsp;";

		//스케줄 출력
		$schstr = get_schedule($yy,$mm,$day);
		echo $schstr;
		echo "<div align='center' id='now$day' algin='right' style='display:none';><input type='button' value='+' onclick='insert_Schedule($yy,$mm,$day);'></div>";
		// 14. 날자 증가
		$day++;
	}else if($i == 1 && $j < $start_week){ ?>
<td width="130" height="120" align="left" valign="top" bgcolor="skyblue" onmouseover="beforeOver('<?=$def?>')" onmouseout="beforeOut('<?=$def?>')">
<?
		
		$mm2=$mm-1;
		$yy2=$yy-1;
		if($mm2 != 0){
		$schstr = get_schedule_before($yy,$mm2,$def);
		}else{
		$schstr = get_schedule_before($yy2,12,$def);
		}
		echo $def;
		echo $schstr;
		if($mm2 != 0){
		echo "<div align='center' id='before$def' algin='right' style='display:none';><input type='button' value='+' onclick='insert_Schedule($yy,$mm2,$def);'></div>";
		}else{
		echo "<div align='center' id='before$def' algin='right' style='display:none';><input type='button' value='+' onclick='insert_Schedule($yy2,12,$def);'></div>";
		}
		$def++;
		
	}else if($i == $total_week && $j > $last_week){ ?>
<td width="130" height="120" align="left" valign="top" bgcolor="skyblue" onmouseover="afterOver('<?=$abc?>')" onmouseout="afterOut('<?=$abc?>')"> <?
		$mm3=$mm+1;
		$yy2=$yy+1;
		if($mm3 != 13){
		$schstr = get_schedule_after($yy,$mm3,$abc);
}else{
		$schstr = get_schedule_after($yy2,1,$abc);
}
		echo $abc;
		echo $schstr;
			if($mm3 != 13){
		echo "<div align='center' id='after$abc' algin='right' style='display:none';><input type='button' value='+' onclick='insert_Schedule($yy,$mm3,$abc);'></div>";
}else{
		echo "<div align='center' id='after$abc' algin='right' style='display:none';><input type='button' value='+' onclick='insert_Schedule($yy2,1,$abc);'></div>";
}
		
		$abc++;
	}
	?>
</td>
<?}?>
</tr>
<?}?>
</table> 
</form>
</div>
<?
$data="";
$yymm=$yy."-".sprintf("%02d",$mm);
$sql = "select * from schedule where frdt like '%$yymm%' order by frdt";
$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){
if(strlen($row['name'])>20){
	$name = iconv_substr($row['name'],0,10,"utf-8")."...";
}else{
	$name = $row['name'];
}
if(strlen($row['memo'])>80){
	$memo = iconv_substr($row['memo'],0,40,"utf-8")."...";
}else{
	$memo = $row['memo'];
}
$data.="<tr onclick='javascript:location.href=\"calView.php?no=$row[no]\"' style='cursor:pointer'>
		<td bgcolor='#FFFFFF'>$row[frdt]</td>
		<td bgcolor='#FFFFFF'>$row[todt]</td>
		<td bgcolor='#FFFFFF' title='$row[name]'>$name</td>
		<td bgcolor='#FFFFFF' title='$row[memo]'>$memo</td>
		</tr>";
}


?>
<div class="right">
	<table width='95%' cellpadding='2' cellspacing='1' bgcolor="#999999">
	<tr>
		<td bgcolor='#FFFFFF' align="center" colspan='4'><b style="font-size:24px;"><?=$yy?>년 <?=$mm?>월 시작 일정</b></td>
	</tr>
	<tr>
		<th width='120' bgcolor="#DDDDDD">시작일</th>
		<th width='120' bgcolor="#DDDDDD">종료일</th>
		<th width='180'bgcolor="#DDDDDD">제목</th>
		<th width='485' bgcolor="#DDDDDD">내용</th>
	</tr>
	<? echo $data;
	?>
	</table>
</div>