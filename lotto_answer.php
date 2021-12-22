<style>
	td {
		border:1px solid black;
	}
</style>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
	$(function(){
		
		$.ajax({
			type:"GET",
			url:'http://dunchang.xyz:7000/main.php/info/KtKTkxHZKoE56u6BgIyS2NzYNWUBzB',
			cache:false,
			success: function(obj){
				
				
				for(var i= 1; i<=obj.countUser; i++){
					$("#val1").append(`<option value=${i}>${i} 회</option>`);
				}
			}
		});
	});
	function search(){
		const number = $("#val1").val();
		$.ajax({
			type:"GET",
			url:`http://dunchang.xyz:7000/lotte_c.php/info/KtKTkxHZKoE56u6BgIyS2NzYNWUBzB/${number}`,
			cache:false,
			success: function(obj){
				$("#td1").text(obj.num1);
				$("#td2").text(obj.num2);
				$("#td3").text(obj.num3);
				$("#td4").text(obj.num4);
				$("#td5").text(obj.num5);
				$("#td6").text(obj.num6);
			}
		});
	}
</script>
<div align="center">
<select id="val1" name="val1" style="width">
</select>
<input type="button" id="btn1" value="조회" onclick="search();"/>
</div>
<div align="center" style="padding-top:100px;">
<table style="font-size:60px;">
	<tr >
		<td id="td1"></td>
		<td id="td2"></td>
		<td id="td3"></td>
		<td id="td4"></td>
		<td id="td5"></td>
		<td id="td6"></td>
	</tr>
</table>
</div>