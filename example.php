<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
<?
ini_set("allow_url_fopen",1);

include 'logincheck.php';
include "simple_html_dom.php";
include 'dbConn.php';
$chartArr = array();
$resultset = array();
$today_Info_Arr = array();
$url_list = array();
$html = new simple_html_dom();
$mh = curl_multi_init();
$user_id = $_SESSION['user_id'];
$sql = "select stock_code from favorites where userid='$user_id'";
$result = mysqli_query($conn,$sql);
while($data=mysqli_fetch_row($result)){
	$resultset[] = $data;
}

foreach ($resultset as $i=>$row){

	$url_list[$i]="https://finance.naver.com/item/main.nhn?code=$row[0]";

}
$c = MultiHTMLParser($url_list);

foreach($c as $index=>$strs){
$str = $strs['content'];

$html->load($str);
$str = htmlspecialchars($str);
$a = $html->find("span.blind");
$value = "";
$value2 = 0;
$value3 = 0;
$sum = "";
$sum2 = "";
$sum3 = "";
$upDownCheck="";
foreach($a as $b=>$c){
		if($b==12){
		$value=preg_replace("/[^0-9]*/s", "", $c);
		}
}
$a = $html->find("p.no_exday");

foreach($a as $b=>$c){
	$c = explode(" ",$c);
	
	foreach($c as $dv=>$d){
		$value2 = preg_replace("/[^0-9]*/s", "", $c[19]);
		
		
		if(strpos($d,'상승') !== false){
			$upDownCheck = "up";
		}
		if(strpos($d,'하락') !== false){
			$upDownCheck = "down";
		}
		if(strpos($c[38],'>') !== false){
				$value3 = explode('<',explode(">",$c[38])[1])[0];
		}else if(strpos($c[41],'>') !== false){
				$value3 = explode('<',explode(">",$c[41])[1])[0];
		}
		if(strpos($c[39],'>') !== false){
				$value3 = explode('<',explode(">",$c[39])[1])[0];
			}
	
	}
	
		
	
}
$value3.="%";

$value = number_format($value);
$color = "";
if($upDownCheck =="up"){
	$value2 = "+".$value2;
	$value3 = "+".$value3;
	$color="red";
}else if($upDownCheck =="down"){
	$value2 = "-".$value2;
	$value3 = "-".$value3;
	$color="blue";
}
$a = $html->find("em#_market_sum");
foreach($a as $b)
{
	$sum = preg_replace("/[^0-9]*/s", "", $b);
}
if($sum >10000){
	
	$sum2 = substr($sum,-4);
	$sum3 = substr($sum,0,-4);
	$sum = number_format($sum3)."조".number_format($sum2)."억원";
}else{
	$sum = number_format($sum)."억원";
}
$a = $html->find("div.tab_con1");

foreach($a as $b)
{
	$val4 = strip_tags($b);
	
}
$val4 = str_replace(array('& nbsp;','　',' ',"\t","\n","\r","\0","\x0B"),'',$val4);

$a = $html->find("div.wrap_company");
$value0 = "";
foreach($a as $b)
{
	$value0 = strip_tags($b);
  
	
}
$value0=explode(' ',$value0);
$value0=$value0[1];
array_push($today_Info_Arr,array($value0,$value,$value2,$value3,$sum,$color));
$chartArr[$value0] = str_replace('%','',$value3);
}






/*  함수 Start  */
function MultiHTMLParser($data, $options = array(
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_TIMEOUT => 5,
          CURLOPT_FOLLOWLOCATION => TRUE,
          CURLOPT_AUTOREFERER => TRUE,
          CURLOPT_BINARYTRANSFER => TRUE,
          CURLOPT_MAXREDIRS => 5,
          CURLOPT_USERAGENT => "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0)",
         )) {

 // array of curl handles
 $curly = array();
 // data to be returned
 $result = array();

 // multi handle
 $mh = curl_multi_init();

 // loop through $data and create curl handles
 // then add them to the multi-handle
 foreach ($data as $id => $d) {

  $curly[$id] = curl_init();

  $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;

  curl_setopt ($curly[$id], CURLOPT_URL, $url);
  curl_setopt ($curly[$id], CURLOPT_HEADER, 0);
  curl_setopt ($curly[$id], CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0)");
  if(substr_count("https://",$url)) curl_setopt ($curly[$id], CURLPROTO_HTTPS , 1);

  // post?
  if (is_array($d)) {
   if (!empty($d['post'])) {
    curl_setopt($curly[$id], CURLOPT_POST,       1);
    curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
   }
  }

  // extra options?
  if (!empty($options)) {
   curl_setopt_array($curly[$id], $options);
  }

  curl_multi_add_handle($mh, $curly[$id]);
 }

 // execute the handles
 $running = null;
 do {
  $mrc = curl_multi_exec($mh, $running);
 /// echo $mrc."<BR>"; flush();
 } while ($mrc == CURLM_CALL_MULTI_PERFORM);

 while ($running && $mrc == CURLM_OK) {
  if (curl_multi_select($mh) != -1) {
   do {
    $mrc = curl_multi_exec($mh, $running);
   } while ($mrc == CURLM_CALL_MULTI_PERFORM);
  }
 // echo curl_multi_select($mh)."<BR>";
 }

 // get content and remove handles
 foreach($curly as $id => $c) {
	
	$D = curl_multi_getcontent($c);
	$D = iconv("EUC-KR","UTF-8",$D);
  $result[$id] = array('content'=>$D);
  $result[$id]['header'] = curl_getinfo($c);
  curl_multi_remove_handle($mh, $c);
 }
 // print_r($result);
 // all done
 curl_multi_close($mh);
 unset($mh);
 return $result;
}
/*  함수 END  */
?>

<script>
//window.setTimeout('window.location.reload()',5000); // 5초에 한번씩 새로고침
var js_array = <?php echo json_encode($chartArr)?>;

	var ctx = document.getElementById('myChart');
	var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: Object.keys(js_array),
        datasets: [{
            label:'횟수',
            data: Object.values(js_array),
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
		plugins:{
		title: {
        display: true,
        text: '번호별 횟수',
        fontSize: '32px'
		},
		legend:{
			display:false
		}
		},
        indexAxis: 'y',
		
	
    },
	
	
});
</script>
<style>

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
	h1 { font-size:14pt; padding:5px; background-color:#AAFFFF; } 
.myTable { table-layout: auto; width: 100%; min-width: 320px; max-width: 100%; overflow: hidden; border: 0; border-collapse: collapse; background-color: #FAFAFA; margin: auto; margin-bottom: 20px; text-align: center; font-size: 0.9em } .wiDe { min-width: 640px; } .nArrow { max-width: 480px } .myTable tr { height: 40px; } .myTable td, th { border: 1px white solid; padding: 8px; } .myTable th { background-color: #ffa775; color: whitesmoke; } .headerOrange th { background-color: #F5F5F5; } .headerGreen th { background-color: #81e281; } .headerBlue th { background-color: #7799ff; } .myTable.headerH tr:nth-Child(odd) { background-color: #F0F0F0; } .myTable.headerH td, .myTable.headerH th { border-width: 0 1px; } .myTable.headerH tr:hover td { border-color: transparent; background-color: #E6E6E6; } .myTable.headerH tr:hover td:first-Child { border-left-color: white; } .myTable.headerH tr:hover td:last-Child { border-right-color: white; } .myTable.headerV { width: 50%; } .myTable.headerV td:nth-Child(odd) { background-color: #F0F0F0; } .myTable.headerHybrid tr:first-Child th:first-Child { background-color: transparent; } /* 복합 형식 1번 셀 */ .myTable.headerHybrid td:hover { background-color: #E6E6E6; } .myTable caption { margin: 4px 0; }
</style>
<h1 align="center">주가</h1>
<div class="left">
<table class="myTable headerH">
	<tr>
		<th>종목명</th>
		<th>현재가</th>
		<th>전일대비</th>
		<th>전일대비(%)</th>
		<th>시가총액</th>
	</tr>	
	<? foreach($today_Info_Arr as $value) { ?>
	<tr style="color:<?=$value[5]?>">
		<td><b><?=$value[0]?></b></td>
		<td><?=$value[1]?></td>
		<td><?=$value[2]?></td>
		<td><?=$value[3]?></td>
		<td><?=$value[4]?></td>
	</tr>
	<? } ?>
</table>

</div>
<div class="right">
	<canvas id="myChart"   style='width:95%;height:90%;'></canvas>
</div>

<script>
//window.setTimeout('window.location.reload()',10000); // 10초에 한번씩 새로고침
var js_array = <?php echo json_encode($chartArr)?>;
var col_array = Object.values(js_array);
for(var i=0;i<col_array.length;i++){
	if(Number(col_array[i])>0)col_array[i]="rgba(255, 99, 132, 0.9)";
	else if(Number(col_array[i])<0)col_array[i]="rgba(54, 162, 235, 0.9)";
	else col_array[i]="";
}

	var ctx = document.getElementById('myChart');
	var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: Object.keys(js_array),
        datasets: [{
            label:'전일대비 (%) ',
            data: Object.values(js_array),
            backgroundColor: col_array,
    
        }]
    },
    options: {
		responsive: false,
		plugins:{
		autocolors: false,
		annotation:{
			annotations:{
			line1:{	
				type:"line",
				xMin:0,
				xMax:0,
				borderColor: 'rgb(255,0,255,0.9)',
				borderWidth: 2,
				 label: {
              content: "기준",
              enabled: true,
              position: "start"
				}
				}
				
			}
		}
		,
		title: {
        display: true,
        text: '전일대비 (%) ',
        fontSize: '32px'
		},
		legend:{
			display:false
		}
		},
        indexAxis: 'y',
		
	
    },
	
	
});
</script>

