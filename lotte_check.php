<? 
	$select_query = "SELECT num1,num2,num3,num4,num5,num6 from lottos where no=$uri[4]";  
	$result_query = mysqli_query($conn, $select_query); 
	$result_model = $result_query->fetch_array();
	if($result_model != 0){ 
	echo json_encode(array(
	'num1'=>$result_model['num1'],
	'num2'=>$result_model['num2'],
	'num3'=>$result_model['num3'],
	'num4'=>$result_model['num4'],
	'num5'=>$result_model['num5'],
	'num6'=>$result_model['num6']	
	));  
	
	} 
	mysqli_close($conn); 
?>
