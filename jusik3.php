<?
include 'logincheck.php';
function file_get_contents_curl($url) { 
	$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)';
	$ch = curl_init();
    curl_setopt ($ch, CURLOPT_USERAGENT,$agent); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); $data = curl_exec($ch); curl_close($ch);
	return $data; 
	}

?>

<?

$url="https://opendart.fss.or.kr/api/fnlttSinglAcnt.json?crtfc_key=74b7f8732a9fb83c2187f5bb5cc82422cb17ed81&";
$url.="corp_code=".$_POST['corp_code']."&bsns_year=".$_POST['bsns_year']."&reprt_code=".$_POST['reprt_code'];
$data = file_get_contents_curl($url);

$hw2= "";
$R = json_decode($data,TRUE);
if($R['status']!="013"){
foreach($R['list'] as $key => $value){
	$value2 = array_keys($value);
/*	$hw .="<th>";
	$hw .=$value2[$key];
	$hw .="</th>";
*/
	if($value2[$key] == "reprt_code"){
		$kind="";
		if($_POST['reprt_code']=="11013"){
			$kind="1분기보고서";
		}else if($_POST['reprt_code']=="11012"){
			$kind="반기보고서";
		}else if($_POST['reprt_code']=="11014"){
			$kind="3분기보고서";
		}else if($_POST['reprt_code']=="11011"){
			$kind="사업보고서";
		}
		$hw2 .="<td>";
		$hw2 .=$kind;
		$hw2 .="</td>";
	
	}else if($value2[$key]=="rcept_no"){
		$hw2 .="<td><a target='_blank' href='http://dart.fss.or.kr/dsaf001/main.do?rcpNo=".$value[$value2[$key]]." '>";
		$hw2 .=$value[$value2[$key]];
		$hw2 .="</a></td>";
	}
	
	else if($value[$value2[$key]] =="" || $value2[$key] =="ord"){
	
	}
	else{
	
	$hw2 .="<td>";
	$hw2 .=$value[$value2[$key]];
	$hw2 .="</td>";
	}
}
}else{
	$check=true;
	$hw2= "조회된 데이터가 없습니다.";
	
}


?>

<html>
	<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
		<title>sample page</title> 
		<style> h1 { font-size:14pt; padding:5px; background-color:#AAFFFF; } table tr td { padding:5px; background-color:#DDFFCC; } 
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
	</head>

	<body>
		<h1 align="center"><? echo $_POST['company']." ".$_POST['bsns_year']."년 ".$kind;?> </h1> 
		<table style="font-size:12px;">
			<? if($check == false) { ?>
			<tr>
				<th>접수번호</th>
				<th>보고서 종류</th>
				<th>사업 연도</th>
				<th>고유 번호</th>
				<th>종목 코드</th>
				<th title="CFS:연결재무제표, OFS:재무제표">개별/연결구분</th>
				<th>개별/연결명</th>
				<th title="BS:재무상태표, IS:손익계산서">재무제표구분</th>
				<th>재무제표명</th>
				<th>계정명</th>
				<th>당기명</th>
				<th>당기일자</th>
				<th>당기금액</th>
				<th>전기명</th>
				<th>전기일자</th>
				<th>전기금액</th>
				<? if($_POST['reprt_code'] == "11011") { ?>
				<th>전전기명</th>
				<th>전전기일자</th>
				<th>전전기금액</th>
				<? } ?>
			
				<!-- <? echo $hw; ?> -->
			</tr>
			<? } ?>
			<tr>
				<? echo $hw2; ?>
			</tr>
			
		</table>
		
	</body>	

</html>