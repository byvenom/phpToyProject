<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="/random.js"></script>
<html>
	<head></head>	
	<body>
		<font style="color:red;">0~100 사이의 자연수 성공확률을 입력하시오</font><br/><br/>
		성공확률 : 
		<input id="val" type="text" >
		
		<input type="button" onclick="abc();" value="test" style="width:50px;height:50px;background:skyblue;"/>		
		<div>
			시도횟수 : <input type="text" id="val1" value="0" readonly style="width:25px;"> <br/>
			성공횟수 : <input type="text" id="val2" value="0" readonly style="width:25px;"> <br/>
			실패횟수 : <input type="text" id="val3" value="0" readonly style="width:25px;"> <br/>
		</div>
	</body>
</html>