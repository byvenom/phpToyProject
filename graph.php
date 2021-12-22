<?

$a = array();

for($i=1;$i<=45;$i++){
	$a[$i."번"] = $_POST['count'.$i];
}

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<div>
	<canvas id="myChart" width='400' height='400'></canvas>
</div>
<script>

	var js_array = <?php echo json_encode($a)?>;

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