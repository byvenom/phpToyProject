<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<style>
	h1 { font-size:14pt; padding:5px; background-color:#AAFFFF; } 
</style>

<?
include 'logincheck.php';

$startDate = sprintf('%04d',$_POST['y'])."-".sprintf('%02d',$_POST['m'])."-".sprintf('%02d',$_POST['d']);

?>
<h1 align="center">작성</h1>
<form name='mForm' action='calInsertOk.php' method="POST" onsubmit="return doAction();">
	시작일 <br/><input type="date" id='frdt' name='frdt' value='<?=$startDate?>' readonly/><br/><br/>
	종료일 <br/><input type="date" id='todt' name='todt' min='<?=$startDate?>' /><br/><br/>
	제목 <br/><input type="text" id='name' name="name" size="97" maxlength='30' placeholder='30자까지 입력가능합니다.'/><br/><br/>
	내용 <br/><textarea id='memo' name="memo" rows="25" cols="99" placeholder='200자까지 입력가능합니다.' style="resize:none;" maxlength='200'></textarea><br/><br/>
	<input type="submit" value="작성하기">&nbsp;&nbsp;&nbsp; <input type="button" value="이전으로" onclick="javascript:history.back();">
	

</form>

<script>
	$(function () {
		$("#todt").attr("min",$("#frdt").val());

	
	})
function changeStart(){
		$("#todt").attr("min",$("#frdt").val());
	}
function isEmpty(obj,msg){
	if(typeof obj == "string"){
		obj = document.querySelector("#"+ obj);
	}
	if(obj.value ==""){
		alert(msg);
		obj.focus();
		return true;
	}
	return false;
}
function doAction(){
	var f = document.mForm;
	if(isEmpty(f.frdt,"시작일 정보가 없습니다!")) return false;
	if(isEmpty(f.todt,"종료일 정보가 없습니다!")) return false;
	if(isEmpty(f.name,"제목 정보가 없습니다!")) return false;
	if(isEmpty(f.memo,"내용 정보가 없습니다!")) return false;
	return true;
}
</script>