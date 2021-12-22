<?
include "dbConn.php";
if($_POST['adminCheck'] =="Yeot"){
$sort_Arr = array();
for($i=1;$i<=6;$i++){
array_push($sort_Arr,$_POST['num'.$i]);
}
sort($sort_Arr);

$sql = "insert into lottos(num1,num2,num3,num4,num5,num6) values($sort_Arr[0],$sort_Arr[1],$sort_Arr[2],$sort_Arr[3],$sort_Arr[4],$sort_Arr[5])";
$result = mysqli_query($conn,$sql);
mysqli_close($conn);
}
else{
$result = false;
}

echo $result;
?>