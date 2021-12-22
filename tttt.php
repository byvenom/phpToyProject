<?php
ini_set("allow_url_fopen",1);
include 'logincheck.php';
$user_id = $_SESSION['user_id'];
include "simple_html_dom.php";
include 'dbConn.php';
$html = new simple_html_dom();
$sql = "select stock_code from favorites where userid='$user_id'";
$resultset = array();
$today_Info_Arr = array();
$mh = curl_multi_init();
$result = mysqli_query($conn,$sql);
while($data=mysqli_fetch_row($result)){
	$resultset[] = $data;
}
$url_list = array();
foreach ($resultset as $i=>$row){

	$url_list[$i]="https://finance.naver.com/item/main.nhn?code=$row[0]";

}



$c = MultiHTMLParser($url_list);
print_r($c);
foreach($c as $index=>$strs)
{
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
}
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
function getMultiContents($url_list)
{
 
    $mh = curl_multi_init();

    $ch_list = array();
   
    foreach ($url_list as $url) {
        $ch_list[$url] = curl_init($url);
        curl_setopt($ch_list[$url], CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch_list[$url], CURLOPT_TIMEOUT, 1);
        curl_setopt($ch_list[$url], CURLOPT_SSL_VERIFYPEER, false);
        curl_multi_add_handle($mh, $ch_list[$url]);
    }
  
    $running = null;
    do {
        curl_multi_exec($mh, $running);
    } while ($running);
  
    foreach ($url_list as $url) {
     
        $results[$url] = curl_getinfo($ch_list[$url]);
        $results[$url]["content"] = curl_multi_getcontent($ch_list[$url]);
        curl_multi_remove_handle($mh, $ch_list[$url]);
        curl_close($ch_list[$url]);
    }
   
    curl_multi_close($mh);
   
    return $results;
}
/*
foreach ($resultset as $i=>$row){
	$ch[$i] = curl_init();
	curl_setopt($ch[$i], CURLOPT_URL, "https://finance.naver.com/item/main.nhn?code=$row[0]");
	curl_setopt($ch[$i], CURLOPT_HEADER, 0);
	curl_multi_add_handle($mh,$ch[$i]);
}
//execute the multi handle
do {
    $status = curl_multi_exec($mh, $active);
	
    if ($active) {
        // Wait a short time for more activity
        curl_multi_select($mh);
		
    }
} while ($active && $status == CURLM_OK);

//close the handles
foreach ($resultset as $i=>$row){
	curl_multi_remove_handle($mh, $ch[$i]);
}

curl_multi_close($mh);
*/
?>

<style>
	
.myTable { table-layout: auto; width: 100%; min-width: 320px; max-width: 100%; overflow: hidden; border: 0; border-collapse: collapse; background-color: #FAFAFA; margin: auto; margin-bottom: 20px; text-align: center; font-size: 0.9em } .wiDe { min-width: 640px; } .nArrow { max-width: 480px } .myTable tr { height: 40px; } .myTable td, th { border: 1px white solid; padding: 8px; } .myTable th { background-color: #ffa775; color: whitesmoke; } .headerOrange th { background-color: #F5F5F5; } .headerGreen th { background-color: #81e281; } .headerBlue th { background-color: #7799ff; } .myTable.headerH tr:nth-Child(odd) { background-color: #F0F0F0; } .myTable.headerH td, .myTable.headerH th { border-width: 0 1px; } .myTable.headerH tr:hover td { border-color: transparent; background-color: #E6E6E6; } .myTable.headerH tr:hover td:first-Child { border-left-color: white; } .myTable.headerH tr:hover td:last-Child { border-right-color: white; } .myTable.headerV { width: 50%; } .myTable.headerV td:nth-Child(odd) { background-color: #F0F0F0; } .myTable.headerHybrid tr:first-Child th:first-Child { background-color: transparent; } /* 복합 형식 1번 셀 */ .myTable.headerHybrid td:hover { background-color: #E6E6E6; } .myTable caption { margin: 4px 0; }
</style>
<h1 align="center">임시샘플</h1>
<table class="myTable headerH">
	<tr>
		<th>종목명</th>
		<th>현재가</th>
		<th>전일대비</th>
		<th>전일대비%</th>
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