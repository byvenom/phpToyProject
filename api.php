<?

include 'logincheck.php';


?>
<style>
	h1 { font-size:14pt; padding:5px; background-color:#AAFFFF; } 
	.button {
   width:125px;
	height:40px;
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
	.button:hover {
    background-color: blue;
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
</style>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
	$(document).ready(function(){
		$.ajax({
			url: "api_all.php",
			type: "post",
			data: {
				gubun:"check"
			}
		}).done(function(data){
			
			if(data!=="false"){
				$('#result').text(data);
				$('#set1').css('display',"none");
				$('#set2').css('display',"");
				$('#set3').css('display',"");
			}else{
				$('#set1').css('display',"");
				$('#set2').css('display',"none");
				$('#set3').css('display',"none");
			}
		});
	});
	function add(){
		$.ajax({
			url: "api_all.php",
			type: "post",
			data: {
				gubun:"add"
			}
		}).done(function(data) {
			
			$('#result').text(data);
			$('#set1').css('display',"none");
			$('#set2').css('display',"");
			$('#set3').css('display',"");
		});
	}
	function update(){
		if(confirm("API KEY를 정말로 재발급 받으시겠습니까??(기존에 사용하던 KEY는 삭제됩니다.)")){
		$.ajax({
			url: "api_all.php",
			type: "post",
			data: {
				gubun:"update"
			}
		}).done(function(data) {
			
			$('#result').text(data);
			
		});
		}else{
			return false;
		}
			
	}
</script>
<h1 align="center">API 정보</h1>
<div align="center" style="height:512px;position:relative;">
<div id="set1" style="position:absolute;float:center;bottom:0px;left:900px;" >
<input class="button" type="button" onclick="add();" value="API KEY 발급">
</div>
<div id="set2" style="display:none;padding:10px;position:absolute;float:center;bottom:50px;left:810px;">
<table style="border:1px solid black;padding:5px;">
	<tr>
		<th>API 키정보</th>
	</tr>
	<tr>
		<td id="result"></td>
	</tr>
</table>
</div>


<span id="set3" style="display:none;position:absolute;float:center;bottom:0px;left:900px;">
<input class="button" type="button" onclick="update();" value="API KEY 재발급">
</span>
</div>