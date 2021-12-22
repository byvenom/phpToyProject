<?
include 'logincheck.php';
?>
<html>
	<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
		<title>sample page</title>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>$(document).keydown(function(event) {
if (event.ctrlKey==true && (event.which == '61' || event.which == '107' || event.which == '173' || event.which == '109'  || event.which == '187'  || event.which == '189'  ) ) {
        event.preventDefault();
     }
    // 107 Num Key  +
    // 109 Num Key  -
    // 173 Min Key  hyphen/underscor Hey
    // 61 Plus key  +/= key
});

$(window).bind('mousewheel DOMMouseScroll', function (event) {
       if (event.ctrlKey == true) {
       event.preventDefault();
       }
});
</script>
		<style> h1 { font-size:14pt; padding:5px; background-color:#AAFFFF; } table tr td { padding:5px;  } select { height:30px;}
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
	.button {

    width:100px;

    background-color: #f8585b;

    border: none;

    color:#fff;

    padding: 15px 0;

    text-align: center;

    text-decoration: none;

    display: inline-block;

    font-size: 15px;

    margin: 4px;

    cursor: pointer;
	
	border-radius:10px;
	}
	.button:hover {
    background-color: blue;
	
}
.parent {
    display: flex;
}
.child {
    flex: 1;
}
iframe { 
	-moz-transform: scale(1.40, 1.40);  // 원래 크기의 85%로 축소
    -webkit-transform: scale(1.40, 1.40); 
    -o-transform: scale(1.40, 1.40); 
    -ms-transform: scale(1.40, 1.40); 
    transform: scale(1.40, 1.40); 
    -moz-transform-origin: top left;  //상단 좌측 정렬
    -webkit-transform-origin: top left; 
    -o-transform-origin: top left; 
    -ms-transform-origin: top left; 
    transform-origin: top left; 
	pointer-events: none;
}



		</style> 
	</head>

	<body>
		<h1 align="center"><?=$_GET['company']?></h1>
		<div align="center">
		<form name="form1" id="form1" method="post" action="jusik3.php">
		<input type="hidden" name="corp_code" value="<?=$_GET['corp_code']?>"/>
		<input type="hidden" name="company" value="<?=$_GET['company']?>"/>
		<table>
			<tr>
				<th>사업연도</th>
				<td>
					<select name="bsns_year">
						<option value="2021">2021</option>
						<option value="2020">2020</option>
						<option value="2019">2019</option>
						<option value="2018">2018</option>
						<option value="2017">2017</option>
						<option value="2016">2016</option>
						<option value="2015">2015</option>
					</select>
				</td>
				<th>보고서종류</th>
				<td>
					<select name="reprt_code">
						<option value="11013">1분기보고서</option>
						<option value="11012">반기보고서</option>
						<option value="11014">3분기보고서</option>
						<option value="11011">사업보고서</option>
					</select>
				</td>
				<td>
					<input class="button" type="submit" name="test" id="test" value="검색"/>
				</td>
			</tr>
		</table>
		
		</form>
		</div>
		<div class='parent' style="width: 100%; height: 100px;">
			<div class='child'>
			<div>
			<iframe src="iframe_2.php?stock_code=<?=$_GET['stock_code']?>" width="980" height="560"scrolling="no" frameborder="0" ></iframe>
			</div>
			</div>
			<div class='child'>
				<div>
					<iframe src="iframe_4.php?stock_code=<?=$_GET['stock_code']?>" width="300" height="360"scrolling="no" frameborder="0" ></iframe>	
				</div>
			</div>
		</div>
		

	</body>	

</html>