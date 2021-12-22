<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<style>
	h1 { font-size:14pt; padding:5px; background-color:#AAFFFF; } 
</style>

<?
include 'logincheck.php';
include 'dbConn.php';
$no = $_GET['no'];

$sql = "select * from schedule where no=$no";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

$memo = $row['memo'];
?>
<h1 align="center">수정</h1>
<form action='calUpdateOk.php' method="POST">
	<input type="hidden" name="no" value="<?=$no?>"/>
	시작일 <br/><input onchange="changeStart();" type="date" id='frdt' name='frdt' value='<?=$row['frdt']?>'/><br/><br/>
	종료일 <br/><input type="date" id='todt' name='todt' value='<?=$row['todt']?>'/><br/><br/>
	제목 <br/><input type="text" name="name" size="97" value='<?=$row['name']?>' maxlength='30' placeholder='30자까지 입력가능합니다.'/><br/><br/>
	내용 <br/><textarea name="memo" rows="25" cols="99" placeholder='200자까지 입력가능합니다.' style="resize:none;" maxlength='200' ><?=$memo?></textarea><br/><br/>
	<input type="submit" value="수정하기">&nbsp;&nbsp;&nbsp; <input type="button" value="이전으로" onclick="javascript:history.back();">
	

</form>

<script>
	$(function () {
		$("#todt").attr("min",$("#frdt").val());

	
	})
function changeStart(){
		$("#todt").attr("min",$("#frdt").val());
	}
</script>