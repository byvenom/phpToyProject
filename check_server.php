<? 
	$select_query = "SELECT COUNT(*) as counter from lottos";  
	$result_query = mysqli_query($conn, $select_query); 
	$result_model = $result_query->fetch_array();
	if($result_model != 0){ 
	echo json_encode(array(
	'countUser'=>$result_model['counter'],
	
	));  
	
	} 
	mysqli_close($conn); 
?>
