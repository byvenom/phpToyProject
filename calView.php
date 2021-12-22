<script>
	function onUpdate(no){
		location.href=`calUpdate.php?no=${no}`;
	}
	function onDelete(no){
		if(confirm("정말로 삭제 하시겠습니까??")){
			location.href=`calDeleteOk.php?no=${no}`;
		}
	}
</script>
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


?>

<h1 align="center">내용</h1>
	<input type="hidden" name="no" value="<?=$no?>"/ >
	시작일 <br/><input type="date" name='frdt' value='<?=$row['frdt']?>'readonly/><br/><br/>
	종료일 <br/><input type="date" name='todt' value='<?=$row['todt']?>'readonly/><br/><br/>
	제목 <br/><input type="text" name="name" size="97" value='<?=$row['name']?>'readonly/><br/><br/>
	내용 <br/><textarea name="memo" rows="25" cols="99" style="resize:none;" readonly/><?=$row['memo']?></textarea><br/><br/>
	<input type="button" value="수정하기" onclick="onUpdate(<?=$no?>)"> &nbsp;&nbsp;&nbsp; <input type="button" value="삭제하기" onclick="onDelete(<?=$no?>)">&nbsp;&nbsp;&nbsp; <input type="button" value="이전으로" onclick="javascript:history.back();">
	

